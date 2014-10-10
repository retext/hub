<?php

namespace Retext\Hub\BackendBundle\Entity;

use Dothiv\ValueObject\EmailValue;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as AssertORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="Retext\Hub\BackendBundle\Repository\UserRepository")
 * @AssertORM\UniqueEntity("email")
 * @Serializer\ExclusionPolicy("all")
 * @ORM\Table(name="HubUser", uniqueConstraints={
 *      @ORM\UniqueConstraint(name="user__email",columns={"email"}),
 *      @ORM\UniqueConstraint(name="user__handle",columns={"handle"})
 * })
 */
class User
{
    use Traits\IdTrait;
    use Traits\CreateUpdateTimeTrait;
    use Traits\HandleTrait;

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
