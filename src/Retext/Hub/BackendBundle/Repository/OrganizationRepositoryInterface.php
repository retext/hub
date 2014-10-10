<?php

namespace Retext\Hub\BackendBundle\Repository;

use Retext\Hub\BackendBundle\Entity\Organization;
use Retext\Hub\BackendBundle\Exception\InvalidArgumentException;

interface OrganizationRepositoryInterface
{
    /**
     * @param Organization $organization
     *
     * @return self
     *
     * @throws InvalidArgumentException if $organization is invalid.
     */
    function persist(Organization $organization);

    /**
     * @return self
     */
    function flush();
}
