<?php

namespace Aop\Aspect;

use Exception;
use PHPUnit\Framework\TestCase;
use Go\Core\AspectKernel;
use Go\Core\AspectContainer;
use Aop\Aspect\Stub\ClassThatThrowsExceptionStub;

class ExceptionLogAspectTest extends TestCase
{
    /**
     * @covers \Aop\Aspect\ExceptionLoggerAspect::writeExceptionLog
     * @expectedException Exception
     */
    public function testIfWriteLogWhenExceptionThrown()
    {
        $logger = $this->getMockBuilder('\Psr\Log\LoggerInterface')
            ->getMock();

        $aspect = new ExceptionLoggerAspect();
        $aspect->withLogger($logger);

        $aspectCollection = new AspectCollection();
        $aspectCollection->add($aspect);

        $aspectKernel = ApplicationAspectKernel::getInstance();
        $aspectKernel->setAspectCollection($aspectCollection);
        $aspectKernel->init(
            array(
                'debug'     => true,
                'cacheDir'  => '/tmp/',
                'includePaths' => array(
                    realpath(dirname(__FILE__) . '/Stub')
                )
            )
        );

        $exceptionMessage = "An any exception";

        $logger->expects($this->once())
            ->method('error')
            ->with($exceptionMessage);

        $stub = new ClassThatThrowsExceptionStub();
        $stub->throwException($exceptionMessage);
    }
}
