<?php

namespace Retext\Hub\BackendBundle\Repository;

use Dothiv\ValueObject\IdentValue;
use PhpOption\Option;
use Retext\Hub\BackendBundle\Entity\Project;
use Retext\Hub\BackendBundle\Exception\InvalidArgumentException;

interface ProjectRepositoryInterface
{
    /**
     * @param Project $project
     *
     * @return self
     *
     * @throws InvalidArgumentException if $project is invalid.
     */
    function persist(Project $project);

    /**
     * @return self
     */
    function flush();

    /**
     * @param IdentValue $orgHandle
     * @param IdentValue $projectHandle
     *
     * @return Option
     */
    function findByHandle(IdentValue $orgHandle, IdentValue $projectHandle);
}
