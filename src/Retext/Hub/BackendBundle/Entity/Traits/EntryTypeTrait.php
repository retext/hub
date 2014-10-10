<?php

namespace Retext\Hub\BackendBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Retext\Hub\BackendBundle\Entity\EntryType;
use Retext\Hub\BackendBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;
use Gedmo\Mapping\Annotation as Gedmo;

trait EntryTypeTrait
{
    /**
     * The type.
     *
     * @ORM\ManyToOne(targetEntity="EntryType")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     * @Assert\Type("\Retext\Hub\BackendBundle\Entity\EntryType")
     * @Assert\NotBlank()
     * @var EntryType
     */
    protected $type;

    /**
     * @return EntryType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param EntryType $type
     */
    public function setType(Entrytype $type)
    {
        $this->type = $type;
    }
}
