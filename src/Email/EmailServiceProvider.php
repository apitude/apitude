<?php
namespace Apitude\Core\Email;

use Apitude\Core\Email\Service\MandrillSender;
use Apitude\Core\Email\Service\SimpleSender;
use Apitude\Core\Provider\AbstractServiceProvider;
use Silex\Application;

class EmailServiceProvider extends AbstractServiceProvider
{
    protected $services = [
        MandrillSender::class,
        SimpleSender::class,
        EmailService::class,
    ];

    public function register(Application $app)
    {
        if (!array_key_exists('mandrill_api_key', $app['config']['email'])) {
            $app['config'] = $app->extend('config', function($config) {
                if (!isset($config['email'])) {
                    $config['email'] = [];
                }
                $config['email']['mandrill_api_key'] = getenv('MANDRILL_API_KEY');
            });
        }
    }
}
