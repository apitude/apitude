<?php
namespace Apitude\Core\API\Writer;


use Doctrine\Common\Collections\Collection;

interface WriterInterface
{
    public function writeObject($object);
    public function writeCollection(Collection $collection);
}
