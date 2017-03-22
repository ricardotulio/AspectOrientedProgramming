<?php

use Aop\Aspect\ApplicationAspectKernel;

require_once __DIR__.'/../vendor/autoload.php';

$aspectKernel = ApplicationAspectKernel::getInstance();
$aspectKernel->init([
    'debug' => false,
    'includePaths' => [
        ''
    ]
]);
