<?php
namespace Apitude\Core\API\Controller;

use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationInterface;
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
     * Given a constraint violation list, convert it to an array to be returned
     * as JSON grouping the validation error messages neatly.
     *
     * Arrays of hashes can be validated with the Symfony Validation "Any" constraint.
     * Validation errors in that case look like the `array_of_hashes` property below.
     * In this example, the first two hashes had no validation errors so they are replaced
     * with `null`, while the third hash had validation errors for its `foo` property.
     *
     * Response format will look like this:
     * {
     *     "errors" : {
     *         "current_password" : [
     *             {
     *                 "message" : "This field is expected",
     *                 "parameters" : {
     *                     "{{ field }}" : "\"current_password"\"
     *                 }
     *             }
     *         ],
     *         "array_of_hashes" : [
     *             null,
     *             null,
     *             [
     *                 {
     *                     "message": "INVALID",
     *                     "parameters": {
     *                         "{{ value }}": "\"foo\"",
     *                     }
     *                 }
     *             ]
     *         ],
     *     }
     * }
     *
     * @param  ConstraintViolationListInterface $violationList List being formatted
     * @return array
     */
    public function getViolationRecursiveArray(ConstraintViolationListInterface $violationList)
    {
        $errors = [];

        foreach ($violationList as $violation) {
            $errors = self::addViolationToOutput($errors, $violation);
        }

        return $errors;
    }

    /**
     * Add a single constraint violation to a partially-built array of errors
     * in the format described in `groupViolationsByField`
     *
     * @param array $errors Array of errors
     * @param ConstraintViolationInterface $violation Violation to add
     * @return array
     */
    private function addViolationToOutput(array $errors, ConstraintViolationInterface $violation)
    {
        $path = self::getPropertyPathAsArray($violation);

        // Drill into errors and find where the error message should be added, building nonexistent portions of the path
        $currentPointer = &$errors;

        while (count($path) > 0) {
            $currentField = array_shift($path);

            if (! array_key_exists($currentField, $currentPointer) or ! is_array($currentPointer[$currentField])) {
                $currentPointer[$currentField] = [];
            }

            if (is_numeric($currentField)) {
                for ($i = 0; $i < (int) $currentField; $i++) {
                    if (! array_key_exists($i, $currentPointer)) {
                        $currentPointer[(int) $i] = null;
                    }
                }

                // Sort the elements of this array so JsonResponse converts this to an array rather than an object
                ksort($currentPointer);
            }

            $currentPointer = &$currentPointer[$currentField];
        }

        $currentPointer[] = $this->getValidationErrorArray($violation);

        return $errors;
    }

    /**
     * Given a constraint violation, return its property path as an array
     *
     * Example:
     *     Property path of violation: "[foo][0][bar][baz]"
     *     Return value: array('foo', '0', 'bar', 'baz')
     *
     * @param  ConstraintViolationInterface $violation Violation whose path to return
     * @return array
     */
    private function getPropertyPathAsArray(ConstraintViolationInterface $violation)
    {
        $path = $violation->getPropertyPath();

        // Remove outer brackets and explode fields into array
        $path = substr($path, 1, strlen($path) - 2);

        return explode('][', $path);
    }

    /**
     * @param ConstraintViolationInterface|ConstraintViolation $error
     * @return array
     */
    private function getValidationErrorArray($error)
    {
        return [
            'i18nKey' => method_exists($error->getConstraint(), 'getI18nKey') ?
                $error->getConstraint()->getI18nKey() : null,
            'messageTemplate' => $error->getMessageTemplate(),
            'plural' => $error->getPlural(),
            'invalidValue' => $error->getInvalidValue(),
            'parameters' => $error->getParameters(),
            'message' => $error->getMessage(),
            'path' => $error->getPropertyPath()
        ];
    }
}
