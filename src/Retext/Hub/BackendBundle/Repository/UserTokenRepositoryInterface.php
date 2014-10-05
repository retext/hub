<?php

namespace Retext\Hub\BackendBundle\Repository;

use Retext\Hub\BackendBundle\Entity\User;
use Retext\Hub\BackendBundle\Entity\UserToken;
use Retext\Hub\BackendBundle\Exception\InvalidArgumentException;

interface UserTokenRepositoryInterface
{
    /**
     * Returns whether the user has tokens of scope $scope which have been created after $created
     *
     * @param User      $user
     * @param string    $scope
     * @param \DateTime $created
     *
     * @return bool
     */
    function hasTokens(User $user, $scope, \DateTime $created);

    /**
     * @param UserToken $token
     *
     * @return self
     *
     * @throws InvalidArgumentException if $user is invalid.
     */
    function persist(UserToken $token);

    /**
     * @return self
     */
    function flush();
}
