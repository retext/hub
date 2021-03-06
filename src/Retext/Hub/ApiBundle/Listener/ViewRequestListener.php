<?php

namespace Retext\Hub\ApiBundle\Listener;

use Doctrine\Common\Annotations\Reader;
use Retext\Hub\APIBundle\Controller\Annotation\ApiRequest;
use PhpOption\Option;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\ValidatorInterface;

class ViewRequestListener
{
    /**
     * @var Reader
     */
    private $reader;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * Constructor
     *
     * @param Reader             $reader
     * @param ValidatorInterface $validator
     */
    public function __construct(Reader $reader, ValidatorInterface $validator)
    {
        $this->reader    = $reader;
        $this->validator = $validator;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();
        $object     = new \ReflectionObject($controller[0]);
        $method     = $object->getMethod($controller[1]);
        $request    = $event->getRequest();

        // The class for validating the request data can be set via the routing definition as _dothiv.ApiRequest
        // or as an attribute on the Method as @ApiRequest.
        $annotation = Option::fromValue($request->attributes->get('_hub.ApiRequest'))
            ->map(function ($requestClass) {
                return new ApiRequest(array('value' => $requestClass));
            })
            ->getOrElse($this->reader->getMethodAnnotation($method, 'Retext\Hub\APIBundle\Controller\Annotation\ApiRequest'));

        if (empty($annotation)) {
            return;
        }

        $modelClass = $annotation->getModel();
        $model      = new $modelClass;

        $this->setModelData($request, $model);
        $this->setModelDataFromRouteParams($request, $model);

        $errors = $this->validator->validate($model);

        if (count($errors) == 0) {
            $request->attributes->set('model', $model);
            return;
        }

        throw new BadRequestHttpException(
            (string)$errors
        );
    }

    protected function setModelData(Request $request, $model)
    {
        $ctype = $request->headers->get('content-type');
        if (stristr($ctype, 'application/json') !== false) {
            $this->setModelDataFromJson($request, $model);
        } elseif (stristr($ctype, 'application/x-www-form-urlencoded') !== false) {
            $this->setModelDataFromForm($request, $model);
        } elseif (stristr($ctype, 'multipart/form-data') !== false) {
            $this->setModelDataFromForm($request, $model);
        } else {
            $this->setModelDataFromQuery($request, $model);
        }
    }

    protected function setModelDataFromJson(Request $request, $model)
    {
        $this->setModelDataFromArray(json_decode($request->getContent()), $model);
    }

    protected function setModelDataFromForm(Request $request, $model)
    {
        $this->setModelDataFromArray($request->request->all(), $model);
    }

    protected function setModelDataFromQuery(Request $request, $model)
    {
        $this->setModelDataFromArray($request->query->all(), $model);
    }

    protected function setModelDataFromArray($data, $model)
    {
        foreach ($data as $k => $v) {
            $setter = $this->toSetter($k);
            if (method_exists($model, $setter)) {
                $model->$setter($v);
            } elseif (property_exists($model, $k)) {
                $model->$k = $v;
            }
        }
    }

    /**
     * @param string $propertyName
     *
     * @return string
     */
    protected function toSetter($propertyName)
    {
        return 'set' . $this->toCamelCase($propertyName);
    }

    /**
     * @param string $propertyName
     *
     * @return string
     */
    protected function toCamelCase($propertyName)
    {
        return ucwords(preg_replace('/_/', ' ', $propertyName));
    }

    /**
     * @param $request
     * @param $model
     */
    protected function setModelDataFromRouteParams($request, $model)
    {
        $routeParams = array();
        foreach ($request->attributes->get('_route_params') as $k => $v) {
            if (substr($k, 0, 1) === '_') {
                continue;
            }
            $routeParams[$k] = $v;
        }
        $this->setModelDataFromArray($routeParams, $model);
    }
}
