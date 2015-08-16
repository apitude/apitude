<?php
namespace Apitude\Core\EntityStubs;


interface StampEntityInterface
{
    public function setCreated(\DateTime $dateTime);
    public function setModified(\DateTime $dateTime);

    public function getCreated();
    public function getModified();
}
