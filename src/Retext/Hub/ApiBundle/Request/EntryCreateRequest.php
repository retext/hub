<?php

namespace Retext\Hub\ApiBundle\Request;

use Dothiv\ValueObject\EmailValue;
use Dothiv\ValueObject\IdentValue;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Model for an entry create request
 */
class EntryCreateRequest
{
    /**
     * @var IdentValue
     * @Assert\NotNull
     * @Assert\NotBlank
     */
    protected $organization;

    /**
     * @var IdentValue
     * @Assert\NotNull
     * @Assert\NotBlank
     */
    protected $project;

    /**
     * @var IdentValue
     * @Assert\NotNull
     * @Assert\NotBlank
     */
    protected $type;

    /**
     * @return mixed
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * @param string $orgHandle
     */
    public function setOrganization($orgHandle)
    {
        $this->organization = new IdentValue($orgHandle);
    }

    /**
     * @return IdentValue
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param string $projectHandle
     */
    public function setProject($projectHandle)
    {
        $this->project = new IdentValue($projectHandle);
    }

    /**
     * @return IdentValue
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $typeHandle
     */
    public function setType($typeHandle)
    {
        $this->type = new IdentValue($typeHandle);
    }
}
