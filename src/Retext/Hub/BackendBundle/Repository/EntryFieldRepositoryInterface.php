<?php

namespace Retext\Hub\BackendBundle\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Retext\Hub\BackendBundle\Entity\EntryField;
use Retext\Hub\BackendBundle\Entity\EntryType;
use Retext\Hub\BackendBundle\Exception\InvalidArgumentException;

interface EntryFieldRepositoryInterface
{
    /**
     * @param EntryField $entryField
     *
     * @return self
     *
     * @throws InvalidArgumentException if $entryField is invalid.
     */
    function persist(EntryField $entryField);

    /**
     * @return self
     */
    function flush();
}
