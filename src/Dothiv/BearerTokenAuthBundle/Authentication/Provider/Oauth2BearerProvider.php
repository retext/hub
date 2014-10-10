<?php


namespace Dothiv\BearerTokenAuthBundle\Authentication\Provider;

use Dothiv\BearerTokenAuthBundle\Authentication\Token\Oauth2BearerToken;
use Dothiv\BearerTokenAuthBundle\UserServiceInterface;
use Dothiv\BearerTokenAuthBundle\UserTokenInterface;
use Dothiv\BearerTokenAuthBundle\UserTokenRepositoryInterface;
use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class Oauth2BearerProvider implements AuthenticationProviderInterface
{
    /**
     * @var UserTokenRepositoryInterface
     */
    private $userTokenRepo;

    /**
     * @var UserServiceInterface
     */
    private $userService;

    public function __construct(
        UserProviderInterface $userProvider,
        UserTokenRepositoryInterface $userTokenRepo,
        UserServiceInterface $userService
    )
    {
        $this->userTokenRepo = $userTokenRepo;
        $this->userService   = $userService;
    }

    public function authenticate(TokenInterface $token)
    {
        if (!($token instanceof Oauth2BearerToken)) {
            return $token;
        }
        $optionalToken = $this->userTokenRepo->getTokenByBearerToken($token->getBearerToken());

        if ($optionalToken->isDefined()) {
            /* @var UserTokenInterface $userToken */
            $userToken = $optionalToken->get();
            if ($userToken->isRevoked()) {
                return $token;
            }
            $user = $userToken->getUser();
            $user->setRoles($this->userService->getRoles($user));
            $authenticatedToken = new Oauth2BearerToken($user->getRoles());
            $authenticatedToken->setUser($user);
            $authenticatedToken->setBearerToken($token->getBearerToken());
            return $authenticatedToken;
        }

        return $token;
    }

    public function supports(TokenInterface $token)
    {
        return $token instanceof Oauth2BearerToken;
    }
} 
