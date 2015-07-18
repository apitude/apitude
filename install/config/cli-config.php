<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

$app = require_once APP_PATH . '/bootstrap.php';
$em = $app['em'];

return ConsoleRunner::createHelperSet($em);
