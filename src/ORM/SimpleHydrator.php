<?php
namespace Apitude\Core\ORM;


use Doctrine\ORM\Internal\Hydration\AbstractHydrator;

class SimpleHydrator extends AbstractHydrator
{
    /**
     * Hydrates all rows from the current statement instance at once.
     *
     * @return array
     */
    protected function hydrateAllData()
    {
        return $this->_stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
