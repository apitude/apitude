<?php
namespace Apitude\Core\Validator\Constraints;

class EntityDoesNotExist extends EntityExists
{
    const RECORD_EXISTS = 'RECORD_EXISTS';
    public $message = self::RECORD_EXISTS;
}
