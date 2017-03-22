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
     * @test
     */
    public function mustWriteLogWhenExceptionThrown()
    {
        $loggerMock = $this->getMockBuilder('\Psr\Log\LoggerInterface')
            ->getMock();

        $methodInvocationMock = $this->getMockBuilder(
            '\Go\Aop\Intercept\MethodInvocation'
        )->getMock();

        $aspect = new ExceptionLoggerAspect();
        $aspect->withLogger($loggerMock);

        $exceptionMessage = 'An any exception';

        $loggerMock->expects($this->once())
            ->method('error')
            ->with($exceptionMessage);

        $aspect->writeExceptionLog(
            $methodInvocationMock,
            new \Exception($exceptionMessage)
        );
    }
}
