<?php

namespace AspectOrientedProgramming\Aspect\Stub;

use Exception;

class ClassThatThrowsExceptionStub
{
    public function throwException($message)
    {
        throw new Exception($message);
    }
}
