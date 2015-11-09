<?php

namespace Apitude\Core\Validator\Constraints;

use Symfony\Component\Validator\Constraints\NotBlank;

class NotBlankOrWhitespace extends NotBlank
{
    public $message = 'BLANK';
}
