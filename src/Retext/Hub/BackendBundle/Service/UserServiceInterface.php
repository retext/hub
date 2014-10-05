<?php

namespace Retext\Hub\BackendBundle\Service;

use Dothiv\ValueObject\EmailValue;
use Retext\Hub\BackendBundle\Entity\User;
use Retext\Hub\BackendBundle\Exception\RateLimitExceededException;

interface UserServiceInterface
{
    /**
     * Looks up a user by their email. If no user is found, a new user is created.
     *
     * @param EmailValue $email
     *
     * @return User
     */
    function getOrCreateUserByEmail(EmailValue $email);

    /**
     * Sends a login link to a user.
     *
     * @param User $user
     *
     * @return void
     *
     * @throws RateLimitExceededException If user has to wait before a new login link can be requested.
     */
    function sendLoginLink(User $user);
} 
