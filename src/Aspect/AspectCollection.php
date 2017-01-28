<?php

namespace Aop\Aspect;

use Countable;
use Iterator;
use Go\Aop\Aspect;

/**
 * Represents a set of aspects
 *
 * @method void add(\Go\Aop\Aspect)
 * @method \Go\Aop\Aspect get(int $offset)
 */
final class AspectCollection implements AspectCollectionInterface
{
    private $current = 0;
    private $position = 0;
    private $collection = array();

    /**
     * Add aspect to collection
     *
     * @param \Go\Aop\Aspect $aspect
     * @return null
     */
    public function add(Aspect $aspect)
    {
        $this->collection[$this->current++] = $aspect;
    }

    /**
     * Get aspect from collection
     *
     * @param int $offset
     * @return \Go\Aop\Aspect
     */
    public function get(int $offset): ?Aspect
    {
        return isset($this->collection[$offset]) ? $this->collection[$offset] : null;
    }

    /**
     * Remove aspect from collection
     *
     * @param int $offset
     * @return \Go\Aop\Aspect
     *
     * @todo Refector this method
     */
    public function remove(int $offset): ?Aspect
    {
        if (!isset($this->collection[$offset])) {
            return null;
        }

        $removedItem = $this->collection[$offset];

        for ($i = $offset; $i < count($this->collection); $i++) {
            $this->collection[$i] = $this->collection[$i + 1];
        }

        unset($this->collection[--$this->current]);
        return $removedItem;
    }

    /**
     * Count how many items a collection has
     *
     * @return int
     */
    public function count()
    {
        return count($this->collection);
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function current()
    {
        return $this->collection[$this->position];
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        ++$this->position;
    }

    public function valid()
    {
        return isset($this->collection[$this->position]);
    }
}
