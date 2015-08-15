<?php
namespace Apitude\Core\API\Writer;


interface WriterInterface
{
    public function writeObject($object);
    public function writeCollection(CollectionInterface $collection);
}
