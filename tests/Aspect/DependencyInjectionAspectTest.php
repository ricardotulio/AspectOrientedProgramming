<?php

namespace Aop\Aspect;

use PHPUnit\Framework\TestCase;
use Codeburner\Container\Container;
use Aop\Aspect\Stub\ClassWithDependencies;

class DependencyInjectionAspectTest extends TestCase
{

    private $container;

    public function setUp()
    {
        $this->aspectKernel = ApplicationAspectKernel::getInstance();
        $this->container = new Container();
    }

    public function testIfInjectDependencyIntoAnnotatedClasses()
    {
        $depInjectionAspect = new DependencyInjectionAspect();
        $depInjectionAspect->withContainer(new Container());

        $this->aspectKernel
            ->registerAspect($depInjectionAspect);

        $this->aspectKernel->init(
            array(
                'debug'        => true,
                'cacheDir'     => '/tmp',
                'includePaths' => array(
                    realpath(dirname(__FILE__) . '/../../src/'),
                    realpath(dirname(__FILE__) . '/Stub/')
                )
            )
        );

        $classWithDep = new ClassWithDependencies();
        $dependencyOne = $classWithDep->getDependencyOne();

        $this->assertInstanceOf('\Aop\Aspect\Stub\DependencyOne', $dependencyOne);
        $this->assertInstanceOf('\Aop\Aspect\Stub\DependencyTwo', $dependencyOne->getDependencyTwo());
        $this->assertInstanceOf('\Aop\Aspect\Stub\DependencyThree', $dependencyOne->getDependencyThree());
    }
}
