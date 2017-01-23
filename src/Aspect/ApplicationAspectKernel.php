<?php

namespace AspectOrientedProgramming\Aspect;

use Go\Core\AspectKernel;
use Go\Core\AspectContainer;
use Go\Aop\Aspect;
use Monolog\Logger;

/**
 * Application Aspect Kernel
 */
class ApplicationAspectKernel extends AspectKernel
{
    protected $aspects = array();

    public function registerAspect(Aspect $aspect)
    {
        array_push($this->aspects, $aspect);
    }

    /**
     * Configure an AspectKernel with advisors, aspects and pointcuts
     *
     * @param AspectContainer $container Aspect kernel dependency injection container
     *
     * @return void
     */
    protected function configureAop(AspectContainer $container)
    {
        foreach($this->aspects as $aspect)
        {
            $container->registerAspect($aspect);
        }
    }
}
