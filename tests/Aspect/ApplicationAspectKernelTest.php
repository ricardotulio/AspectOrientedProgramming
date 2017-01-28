<?php

namespace Aop\Aspect;

use PHPUnit\Framework\TestCase;

class ApplicationAspectKernelTest extends TestCase
{
    private $aspectKernel;
    private $aspectCollection;

    public function setUp()
    {
        $this->aspectKernel = ApplicationAspectKernel::getInstance();
        $this->aspectCollection = $this->getMockBuilder('\Aop\Aspect\AspectCollectionInterface')
            ->getMock();
    }

    public function testIfSetAspectCollection()
    {
        $this->aspectKernel->setAspectCollection($this->aspectCollection);
    }

    /**
     * @depends testIfSetAspectCollection
     */
    public function testIfGetAspectCollection()
    {
        $aspectCollection = $this->aspectKernel->getAspectCollection();
        $this->assertEquals($this->aspectCollection, $aspectCollection);
    }

    /**
     * @depends testIfSetAspectCollection
     */
    public function testIfRegisterAspect()
    {
        $this->aspectCollection->expects($this->once())
            ->method('add');

        $aspect = $this->getMockBuilder('\Go\Aop\Aspect')
            ->getMock();

        $this->aspectKernel->setAspectCollection($this->aspectCollection);
        $this->aspectKernel->registerAspect($aspect);
    }
}
