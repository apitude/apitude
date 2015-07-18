<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

$app = require_once realpath(__DIR__.'/..').'/bootstrap.php';
$em = $app['em'];

return ConsoleRunner::createHelperSet($em);
