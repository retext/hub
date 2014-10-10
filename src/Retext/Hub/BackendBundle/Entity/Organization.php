<?php

namespace Retext\Hub\BackendBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as AssertORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="Retext\Hub\BackendBundle\Repository\OrganizationRepository")
 * @AssertORM\UniqueEntity("handle")
 * @Serializer\ExclusionPolicy("all")
 * @ORM\Table(name="HubOrganization", uniqueConstraints={@ORM\UniqueConstraint(name="organization__handle",columns={"handle"})})
 */
class Organization
{
    use Traits\IdTrait;
    use Traits\CreateUpdateTimeTrait;
    use Traits\HandleTrait;

    /**
     * @ORM\OneToMany(targetEntity="Project", mappedBy="organization")
     * @var Project[]|ArrayCollection
     */
    protected $projects;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
    }

    /**
     * @return ArrayCollection|Project[]
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * @param ArrayCollection|Project[] $projects
     */
    public function setProjects($projects)
    {
        $this->projects = $projects;
    }
}
