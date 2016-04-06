<?php
namespace Apitude\Core\Email;

use Apitude\Core\Email\Commands\SendMessage;
use Apitude\Core\Email\Service\MailgunSender;
use Apitude\Core\Email\Service\MandrillSender;
use Apitude\Core\Email\Service\SimpleSender;
use Apitude\Core\Provider\AbstractServiceProvider;
use Handlebars\Handlebars;
use Handlebars\Loader\FilesystemLoader;
use Http\Adapter\Guzzle6\Client as HttpClient;
use Mailgun\Mailgun;
use Silex\Application;

class EmailServiceProvider extends AbstractServiceProvider
{
    protected $commands = [
        SendMessage::class,
    ];

    protected $services = [
        MailgunSender::class,
        MandrillSender::class,
        SimpleSender::class,
        EmailService::class,
    ];

    public function register(Application $app)
    {
        parent::register($app);
        $config = $app['config'];
        if (!isset($config['email'])) {
            $config['email'] = ['sender' => SimpleSender::class];
        }
        if (!array_key_exists('mandrill_api_key', $config['email'])) {
            if (getenv('MANDRILL_API_KEY')) {
                $config['email']['mandrill_api_key'] = getenv('MANDRILL_API_KEY');
            }
        }
        if (array_key_exists('mailgun_api_key', $config['email'])) {
            $app['mailgun'] = $app->share(function ($app) use ($config) {
                return new Mailgun(
                    $config['email']['mailgun_api_key'],
                    new HttpClient()
                );
            });
        }

        $app['config'] = $config;
    }
}
