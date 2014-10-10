<?php

namespace Retext\Hub\BackendBundle\Entity;

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
}
