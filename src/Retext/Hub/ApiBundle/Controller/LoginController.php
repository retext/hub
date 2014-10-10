<?php

namespace Retext\Hub\ApiBundle\Controller;

use JMS\Serializer\SerializerInterface;
use Retext\Hub\ApiBundle\Request\LoginLinkRequest;
use Retext\Hub\BackendBundle\Exception\RateLimitExceededException;
use Retext\Hub\BackendBundle\Service\UserServiceInterface;
use Retext\Hub\ApiBundle\Controller\Annotation\ApiRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

class LoginController
{
    use Traits\CreateJsonResponseTrait;

    /**
     * @var UserServiceInterface
     */
    private $userService;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(
        UserServiceInterface $userService,
        SerializerInterface $serializer
    )
    {
        $this->userService = $userService;
        $this->serializer  = $serializer;
    }

    /**
     * @param Request $request
     *
     * @ApiRequest("\Retext\Hub\ApiBundle\Request\LoginLinkRequest")
     *
     * @throws TooManyRequestsHttpException If to many login attempts are made
     *
     * @return Response
     */
    public function loginAction(Request $request)
    {
        /** @var LoginLinkRequest $model */
        $model = $request->attributes->get('model');
        $user  = $this->userService->getOrCreateUserByEmail($model->getEmail());
        try {
            $this->userService->createLoginLinkRequest($user);
        } catch (RateLimitExceededException $e) {
            throw new TooManyRequestsHttpException();
        }
        $response = $this->createResponse();
        $response->setStatusCode(201);
        return $response;
    }
} 
