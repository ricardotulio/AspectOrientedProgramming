<?php

namespace AspectOrientedProgramming\Aspect;

use Exception;
use PHPUnit\Framework\TestCase;
use Go\Core\AspectKernel;
use Go\Core\AspectContainer;
use AspectOrientedProgramming\Aspect\Stub\ClassThatThrowsExceptionStub;

/**
 * This class tests the behavior of ExceptionLogAspect
 */
class ExceptionLogAspectTest extends AspectTestCase
{
    /**
     * @expectedException Exception
     */
    public function testIfWriteLogWhenExceptionThrown()
    {
        $logger = $this->getMockBuilder('Psr\Log\LoggerInterface')
            ->getMock();

        $exceptionLoggerAspect = new ExceptionLoggerAspect();
        $exceptionLoggerAspect->withLogger($logger);

        $this->registerAspect($exceptionLoggerAspect);
        $this->init();

        $exceptionMessage = "An any exception";

        $logger->expects($this->once())
            ->method('error')
            ->with($exceptionMessage);

        $stub = new ClassThatThrowsExceptionStub();
        $stub->throwException($exceptionMessage);
    }
}
