<?php

namespace Aop\Aspect;

use Countable;
use Iterator;
use Go\Aop\Aspect;

interface AspectCollectionInterface extends Countable, Iterator
{
    public function add(Aspect $aspect);

    public function get(int $offset): ?Aspect;

    public function remove(int $offset): ?Aspect;
}
