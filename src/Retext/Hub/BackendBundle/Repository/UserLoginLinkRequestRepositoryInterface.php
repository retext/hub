<?php

namespace Retext\Hub\BackendBundle\Repository;

use Retext\Hub\BackendBundle\Entity\UserLoginLinkRequest;
use Retext\Hub\BackendBundle\Exception\InvalidArgumentException;

interface UserLoginLinkRequestRepositoryInterface
{
    /**
     * @param UserLoginLinkRequest $user
     *
     * @return self
     *
     * @throws InvalidArgumentException if $user is invalid.
     */
    function persist(UserLoginLinkRequest $user);

    /**
     * @return self
     */
    function flush();
}
