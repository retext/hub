<?php

namespace Retext\Hub\BackendBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

trait IdTrait
{
    /**
     * database primary key
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * gets the database primary key
     */
    public function getId()
    {
        return $this->id;
    }
} 
