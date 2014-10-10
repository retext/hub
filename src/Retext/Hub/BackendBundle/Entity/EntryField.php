<?php

namespace Retext\Hub\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as AssertORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="Retext\Hub\BackendBundle\Repository\EntryFieldRepository")
 * @Serializer\ExclusionPolicy("all")
 * @ORM\Table(name="HubEntryField", uniqueConstraints={@ORM\UniqueConstraint(name="entryfield__entrytype_handle",columns={"type_id", "handle"})})
 */
class EntryField
{
    use Traits\IdTrait;
    use Traits\CreateUpdateTimeTrait;
    use Traits\HandleTrait;
    use Traits\EntryTypeTrait;

    /**
     * @return bool
     */
    public function isRequired()
    {
        return true;
    }
}
