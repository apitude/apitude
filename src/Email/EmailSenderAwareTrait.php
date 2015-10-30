<?php
namespace Apitude\Core\Email;

trait EmailSenderAwareTrait
{
    /**
     * @return EmailService
     */
    protected function getSender()
    {
        return $this->container[EmailService::class];
    }
}