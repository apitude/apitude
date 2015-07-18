<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

$app = require_once '../bootstrap.php';
$em = $app['em'];

return ConsoleRunner::createHelperSet($em);
