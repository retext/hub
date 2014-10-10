<?php

namespace Retext\Hub\BackendBundle\Repository;

use Dothiv\ValueObject\IdentValue;
use PhpOption\Option;
use Retext\Hub\BackendBundle\Exception\InvalidArgumentException;
use Retext\Hub\BackendBundle\Entity\Entry;

interface EntryRepositoryInterface
{
    /**
     * @param Entry $entry
     *
     * @return self
     *
     * @throws InvalidArgumentException if $entry is invalid.
     */
    function persist(Entry $entry);

    /**
     * @return self
     */
    function flush();

    /**
     * @param IdentValue $orgHandle
     * @param IdentValue $projectHandle
     * @param IdentValue $entryHandle
     *
     * @return Option of Entry
     */
    function findByHandle(IdentValue $orgHandle, IdentValue $projectHandle, IdentValue $entryHandle);
}
