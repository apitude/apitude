<?php
namespace Apitude\API\Writer;


interface WriterInterface
{
    public function writeObject($object);
    public function writeCollection(CollectionInterface $collection);
}
