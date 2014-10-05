<?php

namespace Retext\Hub\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Retext\Hub\BackendBundle\Entity\Traits\CreateTimeTrait;
use Dothiv\ValueObject\IdentValue;
use Retext\Hub\BackendBundle\Entity\Traits\IdTrait;
use Retext\Hub\BackendBundle\Entity\Traits\ProcessedTimeTrait;
use Retext\Hub\BackendBundle\Entity\Traits\UserTrait;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Represents a user's login link request
 *
 * @ORM\Entity(repositoryClass="Retext\Hub\BackendBundle\Repository\UserLoginLinkRequestRepository")
 * @ORM\Table()
 *
 * @Serializer\ExclusionPolicy("all")
 */
class UserLoginLinkRequest
{
    use IdTrait;
    use CreateTimeTrait;
    use ProcessedTimeTrait;
    use UserTrait;
}
