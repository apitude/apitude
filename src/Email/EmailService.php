<?php
namespace Apitude\Core\Email;

use Apitude\Core\Email\Service\SenderInterface;
use Apitude\Core\Provider\ContainerAwareInterface;
use Apitude\Core\Provider\ContainerAwareTrait;
use Apitude\Core\Qless\QlessAwareInterface;
use Apitude\Core\Qless\QlessAwareTrait;
use Qless\Job;

class EmailService implements ContainerAwareInterface, SenderInterface, QlessAwareInterface
{
    use ContainerAwareTrait;
    use QlessAwareTrait;

    const SEND_BODY = 'SEND_BODY';
    const SEND_TEMPLATE = 'SEND_TEMPLATE';

    /**
     * @return SenderInterface
     */
    private function getSender() {
        $config = $this->container['config']['email'];
        $sender = $this->container[$config['sender']];
        if (!$sender) {
            throw new \RuntimeException('Email sender not configured');
        }
        return $sender;
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
        return $this->getSender()->sendTemplate(
            $to,
            $fromEmail,
            $fromName,
            $subject,
            $template,
            $parameters,
            $cc,
            $bcc
        );
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
        return $this->getSender()->send(
            $to,
            $fromEmail,
            $fromName,
            $subject,
            $body,
            $contentType,
            $cc,
            $bcc
        );
    }

    public function performSend(Job $job, $params)
    {
        $this->send(
            $params['to'],
            $params['fromEmail'],
            $params['fromName'],
            $params['subject'],
            $params['body'],
            $params['contentType'],
            $params['cc'],
            $params['bcc']
        );

        $job->complete();
    }

    public function performSendTemplate(Job $job, $params)
    {
        $this->sendTemplate(
            $params['to'],
            $params['fromEmail'],
            $params['fromName'],
            $params['subject'],
            $params['template'],
            $params['parameters'],
            $params['cc'],
            $params['bcc']
        );

        $job->complete();
    }

    /**
     * Queues an email to be sent
     * @param string $type (SEND_BODY|SEND_TEMPLATE)
     * @param array $to
     * @param string $fromName
     * @param string $fromEmail
     * @param string $subject
     * @param null|string $body
     * @param string $contentType
     * @param null|string $template
     * @param array $parameters
     * @param array $cc
     * @param array $bcc
     * @param int $delaySeconds
     * @return string
     */
    public function queueEmail(
        $type,
        $to,
        $fromName,
        $fromEmail,
        $subject,
        $body = null,
        $contentType = 'text/html',
        $template = null,
        $parameters = [],
        $cc = [],
        $bcc = [],
        $delaySeconds = 0
    ) {
        $payload = [
            'to' => $to,
            'fromName' => $fromName,
            'fromEmail' => $fromEmail,
            'subject' => $subject,
            'cc' => $cc,
            'bcc' => $bcc,
        ];

        if ($type === self::SEND_TEMPLATE) {
            $method = 'performSendTemplate';
            $payload['template'] = $template;
            $payload['parameters'] = $parameters;
        } else {
            $method = 'performSend';
            $payload['body'] = $body;
            $payload['contentType'] = $contentType;
        }

        return $this->addJob('email', $payload, self::class, $delaySeconds, $method);
    }
}
