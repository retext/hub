<?php

namespace Retext\Hub\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
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
    use Traits\IdTrait;
    use Traits\CreateTimeTrait;
    use Traits\ProcessedTimeTrait;
    use Traits\UserTrait;
}
