<?php

namespace Aop\Aspect\Stub;

use Exception;

class ClassThatThrowsExceptionStub
{
    public function throwException($message)
    {
        throw new Exception($message);
    }
}
