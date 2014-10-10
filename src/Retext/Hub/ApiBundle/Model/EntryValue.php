<?php

namespace Retext\Hub\ApiBundle\Model;

use Retext\Hub\BackendBundle\Entity\EntryField;

class EntryValue
{

    /**
     * @var EntryField
     */
    private $field;

    /**
     * @var mixed
     */
    private $value;

    public function __construct(EntryField $field, $value)
    {
        $this->field = $field;
        $this->value = $value;
    }

    public function isValid()
    {

    }
} 
