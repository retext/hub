<?php

namespace Retext\Hub\BackendBundle\Service;

use Dothiv\ValueObject\EmailValue;
use Dothiv\ValueObject\ClockValue;
use Retext\Hub\BackendBundle\Entity\User;
use Retext\Hub\BackendBundle\Entity\UserLoginLinkRequest;
use Retext\Hub\BackendBundle\Entity\UserToken;
use Retext\Hub\BackendBundle\Exception\RateLimitExceededException;
use Retext\Hub\BackendBundle\Repository\UserLoginLinkRequestRepositoryInterface;
use Retext\Hub\BackendBundle\Repository\UserRepositoryInterface;
use Retext\Hub\BackendBundle\Repository\UserTokenRepositoryInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserService implements UserServiceInterface, UserProviderInterface, \Dothiv\BearerTokenAuthBundle\UserServiceInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepo;

    /**
     * @var UserTokenRepositoryInterface
     */
    private $userTokenRepo;

    /**
     * @var ClockValue
     */
    private $clock;

    /**
     * @var int Time to wait until a new token can be requested.
     */
    private $loginTokenWait = 3600;

    public function __construct(
        UserRepositoryInterface $userRepo,
        UserTokenRepositoryInterface $userTokenRepo,
        UserLoginLinkRequestRepositoryInterface $userLoginLinkRequestRepo,
        ClockValue $clock
    )
    {
        $this->userRepo                 = $userRepo;
        $this->userTokenRepo            = $userTokenRepo;
        $this->userLoginLinkRequestRepo = $userLoginLinkRequestRepo;
        $this->clock                    = $clock;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrCreateUserByEmail(EmailValue $email)
    {
        $optionalUser = $this->userRepo->findByEmail($email);
        if ($optionalUser->isDefined()) {
            return $optionalUser->get();
        }
        $user = new User();
        $user->setEmail($email);
        $this->userRepo->persist($user)->flush();
        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function createLoginLinkRequest(User $user)
    {
        $limitTime = $this->clock->getNow()->modify(sprintf('-%d seconds', $this->loginTokenWait));
        if ($this->userTokenRepo->hasTokens($user, UserToken::SCOPE_LOGIN, $limitTime)) {
            throw new RateLimitExceededException(
                sprintf(
                    'User %s has active %s token. Wait until %s before creating a new one.',
                    $user,
                    UserToken::SCOPE_LOGIN,
                    $limitTime
                )
            );
        }

        $event = new UserLoginLinkRequest();
        $event->setUser($user);
        $this->userLoginLinkRequestRepo->persist($event)->flush();
    }

    /**
     * @param int $loginTokenWait
     */
    public function setLoginTokenWait($loginTokenWait)
    {
        $this->loginTokenWait = $loginTokenWait;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function loadUserByUsername($username)
    {
        $user = $this->getOrCreateUserByEmail(new EmailValue($username));
        $user->setRoles($this->getRoles($user));
        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function refreshUser(UserInterface $user)
    {
        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return $class === 'Retext\Hub\BackendBundle\Entity\User';
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles(\Dothiv\BearerTokenAuthBundle\UserInterface $user)
    {
        $roles = array('ROLE_USER');
        return $roles;
    }

}
