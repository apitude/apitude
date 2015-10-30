<?php
namespace Apitude\Core\Email\Service;

class SimpleSender implements SenderInterface
{
    /**
     * @param array $to
     * @param string $fromEmail
     * @param string $fromName
     * @param string $subject
     * @param string $template
     * @param array $parameters
     * @param array $cc
     * @param array $bcc
     * @return mixed|void
     */
    function sendTemplate(array $to, $fromEmail, $fromName, $subject, $template, $parameters = [], $cc = [], $bcc = [])
    {
        $body = "Template: {$template}\n" . json_encode($parameters, JSON_PRETTY_PRINT);
        $message = new \Swift_Message($subject, $body, 'text/plain');
        $message->setFrom($fromEmail, $fromName);
        foreach(['to' => 'addTo', 'cc' => 'addCc', 'bcc' => 'addBcc'] as $type => $method) {
            foreach($$type as $item) {
                if (is_array($item)) {
                    $message->{$method}($item['email'], $item['name']);
                } else {
                    $message->{$method}($item);
                }
            }
        }
        $mailer = new \Swift_SendmailTransport();
        $mailer->send($message);
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
        $message = new \Swift_Message($subject, $body, $contentType);
        $message->setFrom($fromEmail, $fromName);
        foreach(['to' => 'addTo', 'cc' => 'addCc', 'bcc' => 'addBcc'] as $type => $method) {
            foreach($$type as $item) {
                if (is_array($item)) {
                    $message->{$method}($item['email'], $item['name']);
                } else {
                    $message->{$method}($item);
                }
            }
        }
        $mailer = new \Swift_SendmailTransport();
        $mailer->send($message);
    }
}
