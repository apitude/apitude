<?php

namespace Apitude\Core\Validator\Constraints;

use Symfony\Component\Validator\Constraints\NotBlankValidator;
use Symfony\Component\Validator\Constraint;

class NotBlankOrWhitespaceValidator extends NotBlankValidator
{
    /**
     * Trim value before passing to NotBlankValidator
     *
     * {@inheritdoc}
     *
     * @param  string     $value      Value to validate
     * @param  Constraint $constraint Constraint object
     */
    public function validate($value, Constraint $constraint)
    {
        $value = trim($value);

        parent::validate($value, $constraint);
    }
}
