<?php

namespace Retext\Hub\BackendBundle\Entity;

use Dothiv\ValueObject\EmailValue;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Retext\Hub\BackendBundle\Entity\Traits\CreateUpdateTimeTrait;
use Retext\Hub\BackendBundle\Entity\Traits\IdTrait;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as AssertORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="Retext\Hub\BackendBundle\Repository\UserRepository")
 * @AssertORM\UniqueEntity("email")
 * @Serializer\ExclusionPolicy("all")
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="user__email",columns={"email"})})
 */
class User
{
    use IdTrait;
    use CreateUpdateTimeTrait;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     * @Serializer\Expose
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Email()
     */
    private $email;

    /**
     * @return EmailValue
     */
    public function getEmail()
    {
        return new EmailValue($this->email);
    }

    /**
     * @param EmailValue $email
     *
     * @return $this
     */
    public function setEmail(EmailValue $email)
    {
        $this->email = strtolower((string)$email);
        return $this;
    }
} 
