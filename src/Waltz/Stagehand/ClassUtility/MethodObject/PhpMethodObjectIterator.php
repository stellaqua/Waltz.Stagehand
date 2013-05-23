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
     */
    public function __construct ( \ReflectionClass $reflectionClass ) {
        $this->_reflectionClass = $reflectionClass;
        $this->_reflectionMethods = $reflectionClass->getMethods();
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
