<?php

namespace Retext\Hub\ApiBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Dothiv\ValueObject\IdentValue;
use PhpOption\Option;
use Retext\Hub\ApiBundle\Controller\Annotation\ApiRequest;
use Doctrine\Common\Util\Debug;
use Doctrine\ORM\EntityManager;
use JMS\Serializer\SerializerInterface;
use Retext\Hub\ApiBundle\Model\PaginatedList;
use Retext\Hub\ApiBundle\Model\PaginatedListModel;
use Retext\Hub\ApiBundle\Model\Transformer\EntryTransformer;
use Retext\Hub\ApiBundle\Model\Transformer\PaginatedListTransformer;
use Retext\Hub\ApiBundle\Request\EntryCreateRequest;
use Retext\Hub\BackendBundle\Entity\Entry;
use Retext\Hub\BackendBundle\Entity\EntryType;
use Retext\Hub\BackendBundle\Entity\Organization;
use Retext\Hub\BackendBundle\Entity\Project;
use Retext\Hub\BackendBundle\Repository\EntryFieldRepository;
use Retext\Hub\BackendBundle\Repository\EntryFieldRepositoryInterface;
use Retext\Hub\BackendBundle\Repository\EntryRepositoryInterface;
use Retext\Hub\BackendBundle\Repository\EntryTypeRepositoryInterface;
use Retext\Hub\BackendBundle\Repository\PaginatedRepositoryInterface;
use Retext\Hub\BackendBundle\Repository\ProjectRepositoryInterface;
use Retext\Hub\BackendBundle\Service\EntryValueValidatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;

class EntryController
{
    use Traits\CreateJsonResponseTrait;

    /**
     * @var ProjectRepositoryInterface
     */
    private $projectRepo;

    /**
     * @var EntryTypeRepositoryInterface
     */
    private $typeRepo;

    /**
     * @var EntryFieldRepositoryInterface
     */
    private $fieldRepo;

    /**
     * @var EntryRepositoryInterface
     */
    private $entryRepo;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var EntryValueValidatorInterface
     */
    private $validator;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var string
     */
    private $entryRoute;

    public function __construct(
        ProjectRepositoryInterface $projectRepo,
        EntryTypeRepositoryInterface $typeRepo,
        EntryFieldRepositoryInterface $fieldRepo,
        EntryRepositoryInterface $entryRepo,
        SerializerInterface $serializer,
        EntryValueValidatorInterface $validator,
        RouterInterface $router,
        $entryRoute
    )
    {
        $this->projectRepo = $projectRepo;
        $this->typeRepo    = $typeRepo;
        $this->fieldRepo   = $fieldRepo;
        $this->entryRepo   = $entryRepo;
        $this->serializer  = $serializer;
        $this->validator   = $validator;
        $this->router      = $router;
        $this->entryRoute  = $entryRoute;
    }

    /**
     * @param Request $request
     *
     * @ApiRequest("\Retext\Hub\ApiBundle\Request\EntryCreateRequest")
     *
     * @return Response
     */
    public function createAction(Request $request)
    {
        /** @var EntryCreateRequest $model */
        /** @var Organization $org */
        /** @var Project $project */
        $model   = $request->attributes->get('model');
        $project = $this->projectRepo->findByHandle($model->getOrganization(), $model->getProject())->getOrCall(function () use ($model) {
            throw new NotFoundHttpException(
                sprintf(
                    'Unknown project: %s/%s',
                    $model->getOrganization(),
                    $model->getProject()
                )
            );
        });
        $types   = $project->getTypes();
        if (!$types->containsKey((string)$model->getType())) {
            throw new NotFoundHttpException(
                sprintf(
                    'Unknown type: %s/%s/s',
                    $model->getOrganization(),
                    $model->getProject(),
                    $model->getType()
                )
            );
        }
        /** @var EntryType $type */
        $type   = $types->get((string)$model->getType());
        $fields = $type->getFields();
        $json   = json_decode($request->getContent());
        $data   = new ArrayCollection();
        foreach ($fields as $field) {
            $h = (string)$field->getHandle();
            $v = null;
            if (property_exists($json, $h)) {
                $v = $json->$h;
            }
            $violations = $this->validator->validate($field, $v);
            if (count($violations) != 0) {
                throw new BadRequestHttpException(
                    sprintf(
                        'Value %s for "%s" is invalid! %s',
                        var_export($v, true),
                        $h,
                        (string)$violations
                    )
                );
            }
            $data->set($h, $v);
        }

        $entry = new Entry();
        $entry->setProject($project);
        $entry->setType($type);
        $entry->setFields($data);
        $this->entryRepo->persist($entry)->flush();

        $model    = $this->transformEntry($entry);
        $response = $this->createResponse();
        $response->setStatusCode(201);
        $response->headers->add(array('Location' => (string)$model->getJsonLdId()));
        return $response;
    }

    /**
     * Returns an entry.
     *
     * @param string $project
     * @param string $entry
     *
     * @return Response
     */
    public function fetchAction($project, $entry)
    {
        $optionalEntry = $this->entryRepo->findByHandle(
            new IdentValue($project),
            new IdentValue($entry)
        );

        if ($optionalEntry->isEmpty()) {
            throw new NotFoundHttpException();
        }

        $response = $this->createResponse();
        // Unwrap fields
        /* @var Entry $entry */
        $entry = $optionalEntry->get();
        $model = $this->transformEntry($entry);
        $response->setContent($this->serializer->serialize($model, 'json'));
        return $response;

    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function listAction(Request $request)
    {
        $paginatedList = $this->createListing(
            $this->entryRepo,
            $request->query->get('offsetKey'),
            $request->query->get('offsetDir'),
            $request->attributes->get('_route')
        );

        $response = $this->createResponse();
        $response->setContent($this->serializer->serialize($paginatedList, 'json'));
        return $response;
    }

    /**
     * @param PaginatedRepositoryInterface $repo
     * @param string                       $offsetKey
     * @param string                       $offsetDir
     *
     * @return PaginatedListModel
     */
    protected function createListing(
        PaginatedRepositoryInterface $repo,
        $offsetKey,
        $offsetDir
    )
    {
        $listTransformer  = new PaginatedListTransformer($this->router, $this->entryRoute);
        $entryTransformer = new EntryTransformer($this->router, $this->entryRoute);
        $paginatedResult  = $repo->getPaginated($offsetKey, $offsetDir);
        $paginatedList    = $listTransformer->transform($paginatedResult);
        foreach ($paginatedResult->getResult() as $entry) {
            $paginatedList->addItem($entryTransformer->transform($entry, null, true));
        }
        return $paginatedList;
    }

    /**
     * @param $entry
     *
     * @return \Retext\Hub\ApiBundle\Model\EntryModel
     */
    protected function transformEntry($entry)
    {
        $entryTransformer = new EntryTransformer($this->router, $this->entryRoute);
        $model            = $entryTransformer->transform($entry);
        return $model;
    }
} 
