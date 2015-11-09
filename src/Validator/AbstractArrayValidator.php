<?php

namespace Apitude\Core\Validator;

use Apitude\Core\Entities\AbstractEntity;
use Apitude\Core\Provider\ContainerAwareInterface;
use Apitude\Core\Provider\ContainerAwareTrait;
use Apitude\Core\Provider\Helper\EntityManagerAwareInterface;
use Apitude\Core\Provider\Helper\EntityManagerAwareTrait;
use Apitude\Core\Validator\Constraints\EntityConstraintInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Validator;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Abstract class for validating arrays
 *
 * Simply extend this class and define getConstraints to create a concrete Validator
 */
abstract class AbstractArrayValidator implements ContainerAwareInterface, EntityManagerAwareInterface
{
    use ContainerAwareTrait;
    use EntityManagerAwareTrait;

    const MISSING = 'MISSING';

    /**
     * @var array
     */
    protected $contextData;

    /**
     * Validate an associative array using the constraints defined in
     * getConstraints() and getOptionalConstraints().
     *
     * All constraints from getConstraints() are used.
     *
     * Constraints from getOptionalConstraints() are only used if the field exists in $values.
     *
     * @param  array                   $values Values to validate
     * @param  AbstractEntity $contextEntity   The existing entity to which the validated values
     *                                         will be applied.  Optional.
     * @return ConstraintViolationList
     */
    public function validate(array $values, AbstractEntity $contextEntity = null)
    {
        $this->contextData = $values;

        $constraints = $this->getConstraints($values, $contextEntity);

        $arrayConstraint = new Assert\Collection([
            'fields'               => $constraints,
            'missingFieldsMessage' => self::MISSING,
        ]);

        /** @noinspection PhpUndefinedMethodInspection */
        return $this->container['validator']->validateValue(
            $values,
            $arrayConstraint
        );
    }

    /**
     * @param $constraintClass
     * @param $options
     * @return Constraint
     */
    public function createConstraint($constraintClass, $options)
    {
        return new $constraintClass($options);
    }

    /**
     * @param $constraintClass
     * @param $entityClass
     * @param $options
     * @return EntityConstraintInterface
     */
    public function createEntityConstraint($constraintClass, $entityClass, $options)
    {
        return new $constraintClass($this->getEntityManager(), $entityClass, $options);
    }

    /**
     * Return an array of validation rules for use with Symfony Validator
     *
     * @link http://silex.sensiolabs.org/doc/providers/validator.html#validating-associative-arrays
     *
     * In order to make a field optional, simply use the Optional constraint.
     *
     * If a field should be optional, but should have constraints if it exists,
     * simply provide the constraints to the constructor of the Optional constraint as such:
     *
     *     'first_name' => new Assert\Optional(new Assert\NotBlank())
     *
     * To add multiple constraints, provide an array:
     *
     *     'first_name' => new Assert\Optional([
     *         new Assert\NotBlank(),
     *         new Assert\NotNull(),
     *     ])
     *
     * Alternatively, configuration options such as allowMissingFields and
     * allowExtraFields can be set in the constraints array.
     *
     * @link http://symfony.com/doc/current/reference/constraints/Collection.html#presence-and-absence-of-fields
     *
     * @param  array $contextData             Context data that may be passed to a constraint if needed.
     * @param  AbstractEntity $contextEntity  The existing entity to which the validated values will be applied.
     *                                        Optional.
     * @return array Associative array of Symfony\Component\Validator\Constraints\*
     *               objects sharing keys from the array being validated.
     */
    abstract protected function getConstraints(array $contextData, AbstractEntity $contextEntity = null);
}
