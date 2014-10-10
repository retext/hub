<?php

namespace Retext\Hub\BackendBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as AssertORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="Retext\Hub\BackendBundle\Repository\EntryRepository")
 * @Serializer\ExclusionPolicy("all")
 * @ORM\Table(name="HubEntry", uniqueConstraints={@ORM\UniqueConstraint(name="entry__project_handle",columns={"project_id", "handle"})})
 */
class Entry
{
    use Traits\IdTrait;
    use Traits\CreateUpdateTimeTrait;
    use Traits\HandleTrait;

    /**
     * The project.
     *
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="entries")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     * @Assert\Type("\Retext\Hub\BackendBundle\Entity\Project")
     * @Assert\NotBlank()
     * @var Project
     */
    protected $project;

    /**
     * The type.
     *
     * @ORM\ManyToOne(targetEntity="EntryType", inversedBy="entries")
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

    /**
     * @var array
     *
     * @ORM\Column(type="json_array", nullable=false)
     * @Serializer\Expose
     * @Assert\Type("array")
     * @Assert\NotNull()
     */
    protected $fields;

    /**
     * @return array
     */
    public function getFields()
    {
        return new ArrayCollection($this->fields);
    }

    /**
     * @param ArrayCollection $fields
     */
    public function setFields(ArrayCollection $fields)
    {
        $this->fields = $fields->toArray();
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
    public function setProject($project)
    {
        $this->project = $project;
    }
}
