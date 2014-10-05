<?php

namespace Retext\Hub\BackendBundle\Entity\Traits;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

trait CreateUpdateTimeTrait
{
    use CreateTimeTrait;

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\Type("\DateTime")
     */
    private $updated;

    /**
     * @param \DateTime $updated
     */
    public function setUpdated(\DateTime $updated)
    {
        $this->updated = $updated;
    }

    /**
     * @return \DateTime|null
     */
    public function getUpdated()
    {
        return $this->updated;
    }

} 
