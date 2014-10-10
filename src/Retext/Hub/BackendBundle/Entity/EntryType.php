<?php

namespace Retext\Hub\BackendBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as AssertORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="Retext\Hub\BackendBundle\Repository\EntryTypeRepository")
 * @Serializer\ExclusionPolicy("all")
 * @ORM\Table(name="HubEntryType", uniqueConstraints={@ORM\UniqueConstraint(name="entrytype__project_handle",columns={"project_id", "handle"})})
 */
class EntryType
{
    use Traits\IdTrait;
    use Traits\CreateUpdateTimeTrait;
    use Traits\HandleTrait;

    /**
     * The project.
     *
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="types")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     * @Assert\Type("\Retext\Hub\BackendBundle\Entity\Project")
     * @Assert\NotBlank()
     * @var Project
     */
    protected $project;

    /**
     * @ORM\OneToMany(targetEntity="EntryField", mappedBy="type", fetch="EAGER")
     * @var EntryType[]|ArrayCollection
     */
    protected $fields;

    /**
     * @ORM\OneToMany(targetEntity="Entry", mappedBy="type", fetch="EAGER")
     * @var EntryType[]|ArrayCollection
     */
    protected $entries;

    public function __construct()
    {
        $this->fields = new ArrayCollection();
    }

    /**
     * @return ArrayCollection|EntryType[]
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @return ArrayCollection|EntryType[]
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * @param ArrayCollection|EntryType[] $entries
     */
    public function setEntries($entries)
    {
        $this->entries = $entries;
    }


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
