<?php

namespace Aop\Aspect;

use Go\Core\AspectKernel;
use Go\Core\AspectContainer;
use Go\Aop\Aspect;
use Monolog\Logger;

/**
 * Manages application aspects
 *
 * @package  ApplicationAspectKernel\Aspect
 * @author   Ricardo Ledo de Tulio <ledo.tulio@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html GPL 3.0
 * @link     https://github.com/ricardotulio/Aop
 *
 * @method null registerAspect(Go\Aop\Aspect $aspect)
 * @method null configureAop(Go\Core\AspectContainer $aspect)
 */
class ApplicationAspectKernel extends AspectKernel
{

    /**
     *
     * @var array
     */
    protected $aspects = array();

    /**
     * Register an aspect
     *
     * @param \Go\Aop\Aspect $aspect Aspect to be registered
     *
     * @return null
     */
    public function registerAspect(Aspect $aspect)
    {
        array_push($this->aspects, $aspect);
    }

    /**
     * Configure an AspectKernel with advisors, aspects and pointcuts
     *
     * @param \Go\Aop\AspectContainer $container Aspect DI container
     *
     * @return null
     */
    protected function configureAop(AspectContainer $container)
    {
        foreach ($this->aspects as $aspect) {
            $container->registerAspect($aspect);
        }
    }
}
