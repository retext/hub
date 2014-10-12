<?php

namespace Retext\Hub\BackendBundle\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Retext\Hub\BackendBundle\Entity\EntryType;
use Retext\Hub\BackendBundle\Entity\Project;
use Retext\Hub\BackendBundle\Exception\InvalidArgumentException;

interface EntryTypeRepositoryInterface
{
    /**
     * @param EntryType $entryType
     *
     * @return self
     *
     * @throws InvalidArgumentException if $entryType is invalid.
     */
    function persist(EntryType $entryType);

    /**
     * @return self
     */
    function flush();
}
