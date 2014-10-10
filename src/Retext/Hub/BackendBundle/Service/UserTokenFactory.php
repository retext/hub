<?php

namespace Retext\Hub\BackendBundle\Service;

use Dothiv\ValueObject\ClockValue;
use Dothiv\ValueObject\IdentValue;
use Retext\Hub\BackendBundle\Entity\User;
use Retext\Hub\BackendBundle\Entity\UserToken;
use Symfony\Component\Security\Core\Util\SecureRandom;

class UserTokenFactory implements UserTokenFactoryInterface
{
    use Traits\TokenGeneratorTrait;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var ClockValue
     */
    protected $clock;

    /**
     * @param ClockValue $clock
     * @param array      $config
     */
    public function __construct(ClockValue $clock, $config)
    {
        $this->config = $config;
        $this->clock  = $clock;
    }

    /**
     * @param User $user
     *
     * @return UserToken
     */
    public function createLoginToken(User $user)
    {
        $scope     = 'login';
        $userToken = new UserToken();
        $userToken->setUser($user);
        $userToken->setLifeTime($this->clock->getNow()->modify(sprintf('+%d seconds', $this->config[$scope]['lifetime'])));
        $userToken->setToken(new IdentValue($this->generateToken()));
        $userToken->setScope(new IdentValue($scope));
        $userToken->updateBearerToken();
        return $userToken;
    }

} 
