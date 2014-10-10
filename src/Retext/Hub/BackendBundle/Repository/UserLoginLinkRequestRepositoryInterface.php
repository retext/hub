<?php

namespace Retext\Hub\BackendBundle\Repository;

use Doctrine\Common\Collections\ArrayCollection;
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

    /**
     * Returns a list of unprocessed entites.
     *
     * @return ArrayCollection|UserLoginLinkRequest[]
     */
    function findUnprocessed();
}
