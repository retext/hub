<?php

namespace Retext\Hub\ApiBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Dothiv\ValueObject\IdentValue;
use PhpOption\Option;
use Retext\Hub\ApiBundle\Controller\Annotation\ApiRequest;
use Doctrine\Common\Util\Debug;
use Doctrine\ORM\EntityManager;
use JMS\Serializer\SerializerInterface;
use Retext\Hub\ApiBundle\Request\EntryCreateRequest;
use Retext\Hub\BackendBundle\Entity\Entry;
use Retext\Hub\BackendBundle\Entity\Organization;
use Retext\Hub\BackendBundle\Entity\Project;
use Retext\Hub\BackendBundle\Repository\EntryFieldRepository;
use Retext\Hub\BackendBundle\Repository\EntryFieldRepositoryInterface;
use Retext\Hub\BackendBundle\Repository\EntryRepositoryInterface;
use Retext\Hub\BackendBundle\Repository\EntryTypeRepositoryInterface;
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
        $types   = $this->typeRepo->findByProject($project);
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
        $type   = $types->get((string)$model->getType());
        $fields = $this->fieldRepo->findByType($type);
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

        $link = $this->generateLink($entry);

        $response = $this->createResponse();
        $response->setStatusCode(201);
        $response->headers->add(array('Location' => $link));
        return $response;
    }

    /**
     * Returns an entry.
     *
     * @param string $organization
     * @param string $project
     * @param string $entry
     *
     * @return Response
     */
    public function fetchAction($organization, $project, $entry)
    {
        $optionalEntry = $this->entryRepo->findByHandle(
            new IdentValue($organization),
            new IdentValue($project),
            new IdentValue($entry)
        );

        if ($optionalEntry->isEmpty()) {
            throw new NotFoundHttpException();
        }

        $response = $this->createResponse();
        // Unwrap fields
        /* @var Entry $entry */
        $entry            = $optionalEntry->get();
        $data             = $entry->getFields();
        $data['@id']      = $this->generateLink($entry);
        $data['@context'] = 'http://hub.retext.it/jsonld/Entry';
        $response->setContent($this->serializer->serialize($data, 'json'));
        return $response;

    }

    /**
     * @param Entry $entry
     *
     * @return string
     */
    protected function generateLink(Entry $entry)
    {
        $link = $this->router->generate(
            $this->entryRoute,
            array(
                'organization' => (string)$entry->getProject()->getOrganization()->getHandle(),
                'project'      => (string)$entry->getProject()->getHandle(),
                'entry'        => (string)$entry->getHandle()
            ),
            RouterInterface::ABSOLUTE_URL
        );
        return $link;
    }
} 
