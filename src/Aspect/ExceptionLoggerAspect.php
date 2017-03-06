<?php

namespace Aop\Aspect;

use Go\Aop\Aspect;
use Go\Lang\Annotation\AfterThrowing;
use Go\Aop\Intercept\MethodInvocation;
use Psr\Log\LoggerInterface;

/**
 * Capture and log runtime exceptions
 *
 * @package  Aop\Aspect
 * @author   Ricardo Ledo de Tulio <ledo.tulio@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html GPL 3.0
 * @link     https://github.com/ricardotulio/Aop
 */
final class ExceptionLoggerAspect implements Aspect
{
    /**
     *
     * @var \Psr\Log\LoggerInterface $logger
     */
    private $logger;

    /**
     * Set logger object
     *
     * @param \Psr\Logger\LoggerInterface $logger Logger class
     * @return \Aop\Aspect\ExceptionLogAspect
     * @codeCoverageIgnore
     */
    public function withLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
        return $this;
    }

    /**
     * Get logger object
     *
     * @return \Psr\Log\LoggerInterface
     * @codeCoverageIgnore
     */
    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    /**
     * Capture and log exceptions
     *
     * @param \Go\Aop\Intercept\MethodInvocation
     *
     * @return null
     *
     * @AfterThrowing("execution(public **->*(*))")
     */
    public function writeExceptionLog(
        MethodInvocation $invocation,
        \Exception $exception
    ) {
        $this->getLogger()->error($exception->getMessage());
    }
}
