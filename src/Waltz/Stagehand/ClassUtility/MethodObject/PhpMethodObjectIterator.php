<?php
/**
 * This file is part of the Waltz.Stagehand package
 *
 * (c) Tomoki Kobayashi <tom@stellaqua.com>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */
namespace Waltz\Stagehand\ClassUtility\MethodObject;

/**
 * PhpMethodObjectIterator
 *
 * @package Waltz.Stagehand
 */
class PhpMethodObjectIterator implements \Iterator
{
    /**
     * Reflection class instance
     *
     * @var ReflectionClass
     */
    private $_reflectionClass;

    /**
     * Reflection method instances
     *
     * @var array
     */
    private $_reflectionMethods;

    /**
     * Constructor
     *
     * @param ReflectionClass $reflectionClass
     * @param bool $withParentClassMethods
     */
    public function __construct ( \ReflectionClass $reflectionClass, $withParentClassMethods = false ) {
        $this->_reflectionClass = $reflectionClass;
        $className = $reflectionClass->getName();
        $reflectionMethods = $reflectionClass->getMethods();
        $this->_reflectionMethods = array();
        foreach ( $reflectionMethods as $reflectionMethod ) {
            $classReflection = $reflectionMethod->getDeclaringClass();
            if ( $withParentClassMethods === true
                 || ( $withParentClassMethods === false && $classReflection->getName() === $className ) ) {
                $this->_reflectionMethods[] = $reflectionMethod;
            }
        }
    }

    public function rewind ( ) {
        reset($this->_reflectionMethods);
    }

    public function key ( ) {
        return key($this->_reflectionMethods);
    }

    public function current ( ) {
        $className = $this->_reflectionClass->getName();
        $reflectionMethod = current($this->_reflectionMethods);
        $methodName = $reflectionMethod->getName();
        $methodObject = new PhpMethodObject($className, $methodName);
        return $methodObject;
    }

    public function next ( ) {
        next($this->_reflectionMethods);
    }

    public function valid ( ) {
        return !is_null($this->key());
    }
}
