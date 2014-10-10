<?php

namespace Dothiv\BearerTokenAuthBundle;

use Symfony\Component\Security\Core\Role\Role;

interface UserInterface extends \Symfony\Component\Security\Core\User\UserInterface
{
    /**
     * Sets the roles of the user
     *
     * @param Role[] The user roles
     */
    public function setRoles($roles);
} 
