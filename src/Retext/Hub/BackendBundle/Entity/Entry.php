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
    use Traits\ProjectTrait;
    use Traits\EntryTypeTrait;

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
}
