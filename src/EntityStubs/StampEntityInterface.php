<?php
namespace B2k\Apitude\EntityStubs;


use B2k\Apitude\Entities\User;

interface StampEntityInterface
{
    public function setCreated(\DateTime $dateTime);
    public function setModified(\DateTime $dateTime);
    public function setCreatedBy(User $user);
    public function setModifiedBy(User $user);

    public function getCreated();
    public function getModified();
    public function getCreatedBy();
    public function getModifiedBy();
}
