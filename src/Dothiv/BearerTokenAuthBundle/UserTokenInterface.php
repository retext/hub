<?php

namespace Dothiv\BearerTokenAuthBundle;

interface UserTokenInterface
{
    /**
     * Returns whether this token is revoked,
     *
     * @return bool
     */
    function isRevoked();

    /**
     * Returns the associated user.
     *
     * @return UserInterface
     */
    function getUser();
} 
