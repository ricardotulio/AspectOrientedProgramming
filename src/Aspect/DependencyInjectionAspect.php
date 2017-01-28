<?php

namespace Aop\Aspect;

use Go\Aop\Aspect;
use Go\Lang\Annotation\Before;
use Psr\Container\ContainerInterface;

final class DependencyInjectionAspect implements Aspect
{
    private $container;

    public function withContainer(ContainerInterface $container): DependencyInjectionAspect
    {
        $this->container = $container;
        return $this;
    }

    public function getContainer(): ?DependencyInjectionAspect
    {
        return $this->container;
    }

    /**
     * @Before(execution(public Codeburner\Container\Container->get(*)))
     */
    public function test()
    {
        die("vai!");
    }

    /**
     * @Before(@initialization(\Aop\Aspect\Annotation\Component))
     */
    public function injectDependencies($param)
    {
    }
}
