<?php
namespace Apitude\Core\Email;

trait EmailSenderAwareTrait
{
    /**
     * @return EmailService
     */
    public function getSender()
    {
        return $this->container[EmailService::class];
    }
}