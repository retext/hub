<?php

namespace Retext\Hub\BackendBundle\Service;

use Retext\Hub\BackendBundle\Entity\EntryField;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\ValidatorInterface;

class EntryValueValidator implements EntryValueValidatorInterface
{
    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param EntryField $field
     * @param mixed      $value
     *
     * @return ConstraintViolationListInterface
     */
    public function validate(EntryField $field, $value)
    {
        $constraints = array();
        if ($field->isRequired()) {
            $constraints[] = new NotBlank();
        }
        return $this->validator->validateValue($value, $constraints);
    }
}
