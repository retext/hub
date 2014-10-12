<?php

namespace Retext\Hub\BackendBundle\Entity;

use Dothiv\ValueObject\IdentValue;

interface PaginatedEntityInterface
{
    /**
     * @return IdentValue
     */
    function getIdentifier();
} 
