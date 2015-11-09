<?php
namespace Apitude\Core\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class EntityDoesNotExistValidator extends ConstraintValidator
{
    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     * @return bool
     */
    public function validate($value, Constraint $constraint)
    {
        /** @var EntityExists $constraint */
        if ($constraint->validate($value)) {
            $this->context->addViolation(
                $constraint->message,
                [
                    '{{ type }}' => $constraint->entityClass,
                    '{{ value }}' => $value,
                ]
            );
        }
    }
}
