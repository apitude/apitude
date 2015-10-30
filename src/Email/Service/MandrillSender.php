<?php
namespace Apitude\Core\Email\Service;

use Apitude\Core\Provider\ContainerAwareInterface;
use Apitude\Core\Provider\ContainerAwareTrait;
use DotBlue\Mandrill\Exporters\MessageExporter;
use DotBlue\Mandrill\Mailer;
use DotBlue\Mandrill\Mandrill;
use DotBlue\Mandrill\Message;
use DotBlue\Mandrill\TemplateMessage;

class MandrillSender implements SenderInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @return Mailer
     */
    protected function getMandrill()
    {
        return new Mailer(new MessageExporter(), new Mandrill($this->container['config']['mandrill_api_key']));
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
        $message = new TemplateMessage($template);
        $message->setSubject($subject)
            ->setFrom($fromEmail, $fromName);
        foreach(['to' => 'addTo', 'cc' => 'addCc', 'bcc' => 'addBcc'] as $type => $method) {
            foreach($$type as $item) {
                if (is_array($item)) {
                    $message->{$method}($item['email'], $item['name']);
                } else {
                    $message->{$method}($item);
                }
            }
        }
        foreach ($parameters as $key=>$value) {
            $message->setGlobalMergeVar($key, $value);
        }

        $this->getMandrill()->sendTemplate($message);
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
        $message = new Message();
        $message->setSubject($subject)
            ->setFrom($fromEmail, $fromName);
        if ($contentType === 'text/html') {
            $message->setHtml($body)
                ->setText(strip_tags($body));
        } else {
            $message->setText($body);
        }
        foreach(['to' => 'addTo', 'cc' => 'addCc', 'bcc' => 'addBcc'] as $type => $method) {
            foreach($$type as $item) {
                if (is_array($item)) {
                    $message->{$method}($item['email'], $item['name']);
                } else {
                    $message->{$method}($item);
                }
            }
        }

        $this->getMandrill()->send($message);
    }
}
