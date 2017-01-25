<?php

namespace AspectOrientedProgramming\Aspect;

use Exception;
use PHPUnit\Framework\TestCase;
use Go\Core\AspectKernel;
use Go\Core\AspectContainer;
use AspectOrientedProgramming\Aspect\Stub\ClassThatThrowsExceptionStub;

class ExceptionLogAspectTest extends AspectTestCase
{
    /**
     * @covers \AspectOrientedProgramming\Aspect\ExceptionLoggerAspect::writeExceptionLog
     * @expectedException Exception
     */
    public function testIfWriteLogWhenExceptionThrown()
    {
        $logger = $this->getMockBuilder('Psr\Log\LoggerInterface')
            ->getMock();

        $aspect = new ExceptionLoggerAspect();
        $aspect->withLogger($logger);

        $this->registerAspect($aspect);
        $this->init();

        $exceptionMessage = "An any exception";

        $logger->expects($this->once())
            ->method('error')
            ->with($exceptionMessage);

        $stub = new ClassThatThrowsExceptionStub();
        $stub->throwException($exceptionMessage);
    }
}
