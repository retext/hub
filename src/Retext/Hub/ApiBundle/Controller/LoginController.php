<?php

namespace Retext\Hub\ApiBundle\Controller;

use Dothiv\ValueObject\EmailValue;
use JMS\Serializer\SerializerInterface;
use Retext\Hub\BackendBundle\Service\UserServiceInterface;
use Retext\Hub\ApiBundle\Controller\Annotation\ApiRequest;
use Symfony\Component\HttpFoundation\Request;

class LoginController
{
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
     * @ApiRequest("\Retext\Hub\ApiBundle\\Request\LoginLinkRequest")
     */
    public function loginAction(Request $request)
    {
        // FIXME: Implement
        // $user = $this->userService->getOrCreateUserByEmail(new EmailValue($request->attributes->get('model')->email));
        // $this->userService->sendLoginLink($user);
        // create 201 response
    }
} 
