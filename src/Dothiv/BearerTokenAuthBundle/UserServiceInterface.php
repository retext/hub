<?php

namespace Dothiv\BearerTokenAuthBundle;

use Symfony\Component\Security\Core\Role\Role;

interface UserServiceInterface
{
    /**
     * Returns the roles granted to the user $user.
     *
     * @param UserInterface $user
     *
     * @return Role[] The user roles
     */
    function getRoles(UserInterface $user);
} 
