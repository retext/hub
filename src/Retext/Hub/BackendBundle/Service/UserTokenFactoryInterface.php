<?php

namespace Retext\Hub\BackendBundle\Service;

use Retext\Hub\BackendBundle\Entity\User;
use Retext\Hub\BackendBundle\Entity\UserToken;

interface UserTokenFactoryInterface
{
    /**
     * @param User $user
     *
     * @return UserToken
     */
    function createLoginToken(User $user);
} 
