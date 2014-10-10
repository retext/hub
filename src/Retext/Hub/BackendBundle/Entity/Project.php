<?php

namespace Retext\Hub\BackendBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as AssertORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="Retext\Hub\BackendBundle\Repository\ProjectRepository")
 * @AssertORM\UniqueEntity("handle")
 * @Serializer\ExclusionPolicy("all")
 * @ORM\Table(name="HubProject", uniqueConstraints={@ORM\UniqueConstraint(name="project__handle",columns={"handle"})})
 */
class Project
{
    use Traits\IdTrait;
    use Traits\CreateUpdateTimeTrait;
    use Traits\HandleTrait;

    /**
     * The organization.
     *
     * @ORM\ManyToOne(targetEntity="Organization", inversedBy="projects")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     * @Assert\Type("\Retext\Hub\BackendBundle\Entity\Organization")
     * @Assert\NotBlank()
     * @var Organization
     */
    protected $organization;

    /**
     * @ORM\OneToMany(targetEntity="EntryType", mappedBy="project", fetch="EAGER")
     * @var EntryType[]|ArrayCollection
     */
    protected $types;

    public function __construct()
    {
        $this->types = new ArrayCollection();
    }

    /**
     * @return Organization
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * @param Organization $organization
     */
    public function setOrganization(Organization $organization)
    {
        $this->organization = $organization;
    }

    /**
     * @return ArrayCollection|EntryType[]
     */
    public function getTypes()
    {
        return $this->types;
    }
}
