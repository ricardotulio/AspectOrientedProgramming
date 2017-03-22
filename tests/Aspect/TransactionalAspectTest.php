<?php

namespace Aop\Aspect;

use PHPUnit\Framework\TestCase;

class TransactionalAspectTest extends TestCase
{
    public function setUp()
    {
        $this->connMock = $this->getMockBuilder('Doctrine\DBAL\Connection')
            ->disableOriginalConstructor()
            ->getMock();

        $this->methodInvocationMock = $this->getMockBuilder(
            'Go\Aop\Intercept\MethodInvocation'
        )->getMock();

        $this->transactionalAspect = new TransactionalAspect();
        $this->transactionalAspect->withConnection(
            $this->connMock
        );
    }

    /**
     * @test
     */
    public function mustStartTransaction()
    {
        $this->connMock->expects($this->once())
            ->method('beginTransaction');

        $this->transactionalAspect->beginTransaction(
            $this->methodInvocationMock
        );
    }

    /**
     * @test
     */
    public function mustCommit()
    {
        $this->connMock->expects($this->once())
            ->method('commit');

        $this->transactionalAspect->commit($this->methodInvocationMock);
    }

    /**
     * @test
     */
    public function mustRollback()
    {
        $this->connMock->expects($this->once())
            ->method('rollBack');

        $this->transactionalAspect->rollBack($this->methodInvocationMock);
    }
}
