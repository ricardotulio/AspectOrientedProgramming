<?php

namespace Aop\Aspect;

use PHPUnit\Framework\TestCase;
use Go\Aop\Aspect;

class AspectCollectionTest extends TestCase
{
    public function testIfAddAspect()
    {
        $collection = new AspectCollection();
        $mock = $this->getMockBuilder('Go\Aop\Aspect')
            ->getMock();
        $collection->add($mock);
        $this->assertEquals(1, $collection->count());

        return array(
            'collection' => $collection,
            'mock' => $mock
        );
    }

    /**
     * @depends testIfAddAspect
     */
    public function testIfGetAspect($args)
    {
        $this->assertEquals($args['mock'], $args['collection']->get(0));
        return $args['collection'];
    }

    /**
     * @depends testIfGetAspect
     */
    public function testIfRemoveAspect($collection)
    {
        $collection->remove(0);
        $this->assertNull($collection->get(0));
    }

    public function testIfCollectionIsIterable()
    {
        $collection = new AspectCollection();

        $mockOne = $this->getMockBuilder('Go\Aop\Aspect')
            ->getMock();
        $mockTwo = $this->getMockBuilder('Go\Aop\Aspect')
            ->getMock();
        $mockThree = $this->getMockBuilder('Go\Aop\Aspect')
            ->getMock();

        $collection->add($mockOne);
        $collection->add($mockTwo);
        $collection->add($mockThree);
        $iterations = 0;

        foreach ($collection as $item) {
            $this->assertInstanceOf('Go\Aop\Aspect', $item);
            $iterations++;
        }

        $this->assertEquals(3, $iterations);
    }
}
