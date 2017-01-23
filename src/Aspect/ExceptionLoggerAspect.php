<?php

namespace AspectOrientedProgramming\Aspect;

use Go\Aop\Aspect;
use Go\Lang\Annotation\AfterThrowing;
use Go\Aop\Intercept\MethodInvocation;
use Psr\Log\LoggerInterface;

class ExceptionLoggerAspect implements Aspect
{
    private $logger;

    public function withLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
        return $this;
    }

    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    /**
     * @AfterThrowing("execution(public **->*(*))")
     */
    public function writeExceptionLog(MethodInvocation $invocation)
    {
        $this->getLogger()->error('teste');
    }
}
