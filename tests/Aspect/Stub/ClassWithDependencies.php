<?php

namespace Aop\Aspect\Stub;

/**
 * @Component
 */
class ClassThatHasDependencies
{

    /**
     * @Autowired('dependencyOne')
     */
    private $dependency;

    public function setDependency(DependencyOne $dependency)
    {
        $this->dependency = $dependency;
    }

    public function getDependency(): ?DependencyOne
    {
        return $this->dependency;
    }
}
