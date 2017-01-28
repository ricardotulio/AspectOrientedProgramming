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
 * @method void setAspectCollection(\Aop\Aspect\AspectCollectionInterface
 * @method \Aop\Aspect\AspectCollectionInterface getAspectCollection
 * @method void registerAspect(\Go\Aop\Aspect $aspect)
 * @method void configureAop(\Go\Core\AspectContainer $aspect)
 */
final class ApplicationAspectKernel extends AspectKernel
{

    /**
     *
     * @var \Aop\Aspect\AspectCollectionInterface
     */
    private $aspectCollection;

    /**
     * Set aspect collection object
     *
     * @param \Aop\Aspect\AspectCollectionInterface
     *
     * @return null
     */
    public function setAspectCollection(AspectCollectionInterface $aspectCollection)
    {
        $this->aspectCollection = $aspectCollection;
    }

    /**
     * Get aspect collection object
     *
     * @return \Aop\Aspect\AspectCollectionInterface
     */
    public function getAspectCollection(): ?AspectCollectionInterface
    {
        return $this->aspectCollection;
    }

    /**
     * Register an aspect
     *
     * @param \Go\Aop\Aspect $aspect Aspect to be registered
     *
     * @return null
     */
    public function registerAspect(Aspect $aspect)
    {
        $this->getAspectCollection()->add($aspect);
    }

    /**
     * Configure an AspectKernel with advisors, aspects and pointcuts
     *
     * @param \Go\Aop\AspectContainer $container Aspect DI container
     *
     * @return null
     *
     * @codeCoverageIgnore
     */
    protected function configureAop(AspectContainer $container)
    {
        foreach ($this->getAspectCollection() as $aspect) {
            $container->registerAspect($aspect);
        }
    }
}
