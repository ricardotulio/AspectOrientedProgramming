<?php

namespace Aop\Aspect;

use PHPUnit\Framework\TestCase;
use Doctrine\DBAL\Connection;
use Go\Aop\Intercept\MethodInvocation;

/**
 * Manage transactions
 *
 * @package Aop\Aspect
 * @author  Ricardo Ledo de Tulio <ledo.tulio@gmail.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GPL 3.0
 * @link    https://github.com/ricardotulio/AspectOrientedProgramming 
 */
final class TransactionalAspect
{
    /**
     * @var \Doctrine\DBAL\Connection;
     */
    private $connection;

    /**
     * Get connection object
     *
     * @return \Doctrine\DBAL\Connection
     * @codeCoverageIgnore
     */
    public function getConnection(): Connection
    {
        return $this->connection;
    }

    /**
     * Set connection object
     *
     * @param \Doctrine\DBAL\Connection
     * @return \Aop\Aspect\TransactionalAspect
     * @codeCoverageIgnore
     */
    public function withConnection(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Start transaction
     *
     * @param \Go\Aop\Intercept\MethodInvocation
     * @return void 
     *
     * @Before("@execution(Aop\Annotation\Transactional)")
     */
    public function beginTransaction(MethodInvocation $invocation)
    {
        $this->connection->beginTransaction();
    }

    /**
     * Commit transaction
     *
     * @param \Go\Aop\Intercept\MethodInvocation
     * @return void
     *
     * @After("@execution(Aop\Annotation\Transactional)")
     */
    public function commit(MethodInvocation $invocation)
    {
        $this->connection->commit();
    }

    /**
     * Rollback if throw exception
     *
     * @param \Go\Aop\Intercept\MethodInvocation
     * @return void
     *
     * @AfterThrowing("@execution(Aop\Annotation\Transactional)");
     */
    public function rollBack(MethodInvocation $invocation)
    {
        $this->connection->rollBack();
    }
}
