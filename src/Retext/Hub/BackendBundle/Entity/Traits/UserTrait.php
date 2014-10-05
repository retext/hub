<?php

namespace Retext\Hub\BackendBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Retext\Hub\BackendBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;
use Gedmo\Mapping\Annotation as Gedmo;

trait UserTrait
{
    /**
     * The user.
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     * @Assert\Type("\Retext\Hub\BackendBundle\Entity\User")
     * @Assert\NotBlank()
     * @var User
     */
    protected $user;

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}
