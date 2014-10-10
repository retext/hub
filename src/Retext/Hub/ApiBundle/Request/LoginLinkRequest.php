<?php

namespace Retext\Hub\ApiBundle\Request;

use Dothiv\ValueObject\EmailValue;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Model for a login link request
 */
class LoginLinkRequest
{
    /**
     * @var EmailValue
     * @Assert\NotNull
     * @Assert\NotBlank
     * @Assert\Email
     */
    protected $email;

    /**
     * @return EmailValue
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = new EmailValue($email);
    }
}
