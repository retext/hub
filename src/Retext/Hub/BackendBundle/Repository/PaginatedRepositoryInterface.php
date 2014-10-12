<?php

namespace Retext\Hub\BackendBundle\Repository;

interface PaginatedRepositoryInterface
{
    /**
     * Returns a list of items
     *
     * @param mixed|null $offsetKey
     * @param mixed|null $offsetDir
     *
     * @return PaginatedResult
     */
    public function getPaginated($offsetKey = null, $offsetDir = null);
} 
