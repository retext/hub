<?php

namespace Retext\Hub\BackendBundle\Service;

use Retext\Hub\BackendBundle\Entity\EntryField;
use Symfony\Component\Validator\ConstraintViolationListInterface;

interface EntryValueValidatorInterface
{
    /**
     * @param EntryField $field
     * @param            $value
     *
     * @return ConstraintViolationListInterface
     */
    public function validate(EntryField $field, $value);
} 
