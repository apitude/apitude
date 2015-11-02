<?php
namespace Apitude\Core\API\Controller;

use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

trait ValidatorTrait
{
    /**
     * @return ValidatorInterface
     */
    protected function getValidator()
    {
        return $this->container['validator'];
    }

    /**
     * @param ConstraintViolationListInterface|ConstraintViolation[] $errors
     * @return array
     */
    protected function getValidationErrorsArray($errors)
    {
        $out = [];
        foreach ($errors as $error) {
            $out[] = [
                'i18nKey' => isset($error::I18NKEY) ? $error::I18NKEY : null,
                'messageTemplate' => $error->getMessageTemplate(),
                'plural' => $error->getPlural(),
                'invalidValue' => $error->getInvalidValue(),
                'parameters' => $error->getParameters(),
                'renderedMessage' => $error->getMessage(),
                'path' => $error->getPropertyPath()
            ];
        }

        return $out;
    }
}