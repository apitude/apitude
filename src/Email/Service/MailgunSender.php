<?php
namespace Apitude\Core\Email\Service;

use Apitude\Core\Provider\ContainerAwareInterface;
use Apitude\Core\Provider\ContainerAwareTrait;

class MailgunSender implements SenderInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @param array $to
     * @param string $fromEmail
     * @param string $fromName
     * @param string $subject
     * @param string $template
     * @param array $parameters
     * @param array $cc
     * @param array $bcc
     * @return mixed
     */
    function sendTemplate(array $to, $fromEmail, $fromName, $subject, $template, $parameters = [], $cc = [], $bcc = [])
    {
        $html = $this->container['handlebars']->render(
            $template,
            $parameters
        );

        return $this->send($to, $fromEmail, $fromName, $subject, $html, 'text/html', $cc, $bcc);
    }

    /**
     * @param array $to
     * @param string $fromEmail
     * @param string $fromName
     * @param string $subject
     * @param string $body
     * @param string $contentType
     * @param array $cc
     * @param array $bcc
     * @return mixed
     */
    function send(array $to, $fromEmail, $fromName, $subject, $body, $contentType = 'text/html', $cc = [], $bcc = [])
    {
        $message = [
            'to' => $to,
            'from' => "{$fromName} <{$fromEmail}>",
            'subject' => $subject,
            'html' => $body,
            'cc' => $cc,
            'bcc' => $bcc,
        ];

        $this->container['mailgun']->sendMessage(
            $this->container['config']['email']['mailgun_domain'],
            $message
        );
    }
}
