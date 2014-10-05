<?php

namespace Retext\Hub\ApiBundle\Request;

/**
 * Model for a login link request
 */
class LoginLinkRequest
{
    /**
     * @var string
     * @Assert\NotNull
     * @Assert\NotBlank
     * @Assert\Email
     */
    public $email;
}
