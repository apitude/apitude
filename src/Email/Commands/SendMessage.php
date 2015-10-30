<?php
namespace Apitude\Core\Email\Commands;

use Apitude\Core\Commands\BaseCommand;
use Apitude\Core\Email\EmailService;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SendMessage extends BaseCommand
{
    public function configure()
    {
        $this->setName('email:send')
            ->addArgument('toEmail', InputArgument::REQUIRED)
            ->addArgument('toName', InputArgument::REQUIRED)
            ->addArgument('fromEmail', InputArgument::REQUIRED)
            ->addArgument('fromName', InputArgument::REQUIRED)
            ->addArgument('subject', InputArgument::REQUIRED)
            ->addOption('file', 'f', InputOption::VALUE_REQUIRED, 'Path to file containing body text')
            ->addOption('body', null, InputOption::VALUE_REQUIRED, 'Text of message')
            ->addOption('contentType', null, InputOption::VALUE_REQUIRED, 'Content Type', 'text/html')
            ->addOption('template', 't', InputOption::VALUE_REQUIRED, 'Template to use')
            ->addOption('templateVars', null, InputOption::VALUE_REQUIRED, 'JSON object of key/values for template')
            ->addOption('queueJob', null, InputOption::VALUE_NONE, 'Queue a job');
        $this->setDescription('Send an email');
        $this->setHelp(<<<TEXT
Send an email.  For a regular message, either use the --file or --body options
or pipe the message contents to the command.
For a templated message, specify the template with the --template option.
TEXT
        );
        parent::configure();
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var EmailService $sender */
        $sender = $this->getSilexApplication()[EmailService::class];

        if (!$input->getOption('template')) {
            if ($input->getOption('file')) {
                $body = file_get_contents($input->getOption('file'));
            } elseif ($input->getOption('body')) {
                $body = $input->getOption('body');
            } else {
                // stdin
                $stdin = fopen('php://stdin', 'r');
                $body = stream_get_contents($stdin);
            }

            if ($input->getOption('queueJob')) {
                $jid = $sender->queueEmail(
                    EmailService::SEND_BODY,
                    [[
                        'email' => $input->getArgument('toEmail'),
                        'name' => $input->getArgument('toName'),
                    ]],
                    $input->getArgument('fromEmail'),
                    $input->getArgument('fromName'),
                    $input->getArgument('subject'),
                    $body,
                    $input->getOption('contentType')
                );
            } else {
                $sender->send(
                    [[
                        'email' => $input->getArgument('toEmail'),
                        'name' => $input->getArgument('toName'),
                    ]],
                    $input->getArgument('fromEmail'),
                    $input->getArgument('fromName'),
                    $input->getArgument('subject'),
                    $body,
                    $input->getOption('contentType')
                );
            }
        } else {
            $params = json_decode($input->getOption('templateVars')) ?: [];

            if ($input->getOption('queueJob')) {
                return $sender->queueEmail(
                    EmailService::SEND_TEMPLATE,
                    [[
                        'email' => $input->getArgument('toEmail'),
                        'name' => $input->getArgument('toName'),
                    ]],
                    $input->getArgument('fromEmail'),
                    $input->getArgument('fromName'),
                    $input->getArgument('subject'),
                    null,
                    null,
                    $input->getOption('template'),
                    $params
                );
            } else {
                $sender->sendTemplate(
                    [[
                        'email' => $input->getArgument('toEmail'),
                        'name' => $input->getArgument('toName'),
                    ]],
                    $input->getArgument('fromEmail'),
                    $input->getArgument('fromName'),
                    $input->getArgument('subject'),
                    $input->getOption('template'),
                    $params
                );
            }

        }

        if (isset($jid)) {
            $output->writeln('Message queued with job id: '.$jid);
        } else {
            $output->writeln("Message sent.");
        }
    }
}
