<?php
namespace Apitude\EntityServices;


use Apitude\EntityStubs\StampEntityInterface;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;

class StampSubscriber implements EventSubscriber
{

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            Events::prePersist,
            Events::preUpdate,
        ];
    }

    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof StampEntityInterface) {
            $entity->setCreated(new \DateTime());
            $entity->setModified(new \DateTime());
            // @TODO set create/modify user
        }
    }

    public function preUpdate(PreUpdateEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof StampEntityInterface) {
            $entity->setModified(new \DateTime());
            // @TODO set modify user
        }
    }
}
