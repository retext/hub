<?php

namespace Retext\Hub\BackendBundle\Repository;

use Dothiv\ValueObject\EmailValue;
use PhpOption\Option;
use Retext\Hub\BackendBundle\Entity\User;
use Retext\Hub\BackendBundle\Exception\InvalidArgumentException;

interface UserRepositoryInterface
{
    /**
     * Finds a user by their email.
     *
     * @param EmailValue $email
     *
     * @return Option of User
     */
    function findByEmail(EmailValue $email);

    /**
     * @param User $user
     *
     * @return self
     *
     * @throws InvalidArgumentException if $user is invalid.
     */
    function persist(User $user);

    /**
     * @return self
     */
    function flush();
}
