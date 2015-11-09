<?php
namespace Apitude\Core\Validator\Constraints;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;

/**
 * Class EntityExists
 *
 * If complex requirements, provide "valuesCallback" in options, which will be fed the value being validated
 * to provide the values used to check existance of the specified entity record.
 *
 * @package Apitude\Core\Validator\Constraints
 */
class EntityExists extends Constraint implements EntityConstraintInterface
{
    const RECORD_DOES_NOT_EXIST = 'RECORD_DOES_NOT_EXIST';
    public $message = self::RECORD_DOES_NOT_EXIST;
    /**
     * @var EntityManagerInterface
     */
    protected $em;
    /**
     * @var string
     */
    public $entityClass;
    /**
     * @var callback
     */
    protected $valuesCallback;

    /**
     * RecordExists constructor.
     *
     * @param EntityManagerInterface $em
     * @param string $entityClass
     * @param array $options
     */
    public function __construct(EntityManagerInterface $em, $entityClass, $options)
    {
        $this->em = $em;
        $this->entityClass = $entityClass;
        if (array_key_exists('valuesCallback', $options)) {
            $this->valuesCallback = $options['valuesCallback'];
        }
        parent::__construct($options);
    }

    /**
     * @param $value
     * @return object|null
     */
    public function validate($value)
    {
        if (isset($this->valuesCallback)) {
            $values = call_user_func($this->valuesCallback, $value);
            return $this->em->getRepository($this->entityClass)
                ->findOneBy($values);
        }
        return boolval($this->em->find($this->entityClass, $value));
    }
}
