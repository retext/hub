<?php

namespace Retext\Hub\BackendBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait ProcessedTimeTrait
{
    /**
     * @var \DateTime $processed
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\Type("\DateTime")
     */
    private $processed;

    /**
     * @param \DateTime $processed
     */
    public function setProcessed(\DateTime $processed)
    {
        $this->processed = $processed;
    }

    /**
     * @return \DateTime|null
     */
    public function getProcessed()
    {
        return $this->processed;
    }
}
