<?php
namespace Apitude\Core\EntityStubs;


use Apitude\Core\Entities\User;

interface StampEntityInterface
{
    public function setCreated(\DateTime $dateTime);
    public function setModified(\DateTime $dateTime);
    public function setCreatedBy(User $user = null);
    public function setModifiedBy(User $user = null);

    public function getCreated();
    public function getModified();
    public function getCreatedBy();
    public function getModifiedBy();
}
