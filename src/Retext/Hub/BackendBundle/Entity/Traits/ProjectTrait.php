<?php

namespace Retext\Hub\BackendBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Retext\Hub\BackendBundle\Entity\EntryType;
use Retext\Hub\BackendBundle\Entity\Project;
use Retext\Hub\BackendBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;
use Gedmo\Mapping\Annotation as Gedmo;

trait ProjectTrait
{
    /**
     * The project.
     *
     * @ORM\ManyToOne(targetEntity="Project")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     * @Assert\Type("\Retext\Hub\BackendBundle\Entity\Project")
     * @Assert\NotBlank()
     * @var Project
     */
    protected $project;

    /**
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param Project $project
     */
    public function setProject(Project $project)
    {
        $this->project = $project;
    }
}
