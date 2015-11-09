<?php
namespace Apitude\Core\Validator\Constraints;

use Doctrine\ORM\EntityManagerInterface;

interface EntityConstraintInterface
{
    public function __construct(EntityManagerInterface $em, $entityClass, $options);
}
