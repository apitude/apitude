<?php
namespace Apitude\Core\Email;

use Apitude\Core\Email\Service\SenderInterface;

interface EmailSenderAwareInterface
{
    /**
     * @return SenderInterface
     */
    function getSender();
}
