<?php

namespace Aop\Aspect\Stub;

/**
 * @Component
 */
class DependencyOne
{

    /**
     * @Autowired('dependencyOne')
     */
    private $dependencyTwo;

    /**
     * @Autowired('dependencyTwo')
     */
    private $dependencyThree;

    public function setDependencyTwo(DependencyTwo $dependencyTwo)
    {
        $this->dependencyTwo = $dependencyTwo;
    }

    public function setDependencyThree(DependencyThree $dependencyThree)
    {
        $this->dependencyThree = $dependencyThree;
    }
}
