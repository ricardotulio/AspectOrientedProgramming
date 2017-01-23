<?php

use AspectOrientedProgramming\Aspect\ApplicationAspectKernel;
use AspectOrientedProgramming\Aspect\A;

require_once '../vendor/autoload.php';

$aspectKernel = ApplicationAspectKernel::getInstance();
$aspectKernel->init(
    array(
        'debug'        => true,
        'cacheDir'     => '../cache/',
        'includePaths' => array(
            '../src'
        )
    )
);

$a = new A();
$a->b();
