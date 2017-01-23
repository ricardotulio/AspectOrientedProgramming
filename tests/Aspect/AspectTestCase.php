<?php

namespace AspectOrientedProgramming\Aspect;

use PHPUnit\Framework\TestCase;
use Go\Aop\Aspect;

class AspectTestCase extends TestCase
{
    protected $aspectKernel;

    public function __construct()
    {
        $this->aspectKernel = ApplicationAspectKernel::getInstance();
    }

    public function registerAspect(Aspect $aspect)
    {
        $this->aspectKernel->registerAspect($aspect);
    }

    public function init()
    {
        $this->aspectKernel->init(
            array(
                'debug'     => true,
                'cacheDir'  => '/tmp/',
                'includePaths' => array(
                    realpath(dirname(__FILE__) . '/Stub')
                )
            )
        );
    }
}
