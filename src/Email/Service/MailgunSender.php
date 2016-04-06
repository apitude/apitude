<?php
namespace Apitude\Core\Email\Service;

use Apitude\Core\Provider\ContainerAwareInterface;
use Apitude\Core\Provider\ContainerAwareTrait;

class MailgunSender implements SenderInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    protected function convertEmailsArrayToString($emails)
    {
        $emailStrings = array_map(
            function ($email) {
                if (is_string($email)) {
                    return $email;
                }
                return "{$email['name']} <{$email['email']}>";
            },
            $emails
        );

        return implode(',', $emailStrings);
    }

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
            'to' => $this->convertEmailsArrayToString($to),
            'from' => "{$fromName} <{$fromEmail}>",
            'subject' => $subject,
            'html' => $body,
        ];

        if ($cc) {
            $message['cc'] = $this->convertEmailsArrayToString($cc);
        }

        if ($bcc) {
            $message['bcc'] = $this->convertEmailsArrayToString($bcc);
        }

        if (!preg_match('/@(.+)$/', $fromEmail, $matches)) {
            throw new \Exception("Invalid from address: {$fromEmail}");
        }
        $domain = $matches[1];

        $this->container['mailgun']->sendMessage(
            $domain,
            $message
        );
    }
}
