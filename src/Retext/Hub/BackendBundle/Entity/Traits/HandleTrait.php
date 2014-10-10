<?php

namespace Retext\Hub\BackendBundle\Entity\Traits;

use Dothiv\ValueObject\IdentValue;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait HandleTrait
{
    /**
     * Public id
     *
     * @ORM\Column(type="string", nullable=false)
     * @Assert\Type("string")
     * @Assert\NotBlank()
     *
     * @var string
     */
    protected $handle;

    /**
     * @param IdentValue $handle
     *
     * @return self
     */
    public function setHandle(IdentValue $handle)
    {
        $this->handle = (string)$handle;
        return $this;
    }

    /**
     * @return IdentValue
     */
    public function getHandle()
    {
        return new IdentValue($this->handle);
    }
}
