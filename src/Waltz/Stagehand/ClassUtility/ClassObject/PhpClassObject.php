<?php
/**
 * This file is part of the Waltz.Stagehand package
 *
 * (c) Tomoki Kobayashi <tom@stellaqua.com>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */
namespace Waltz\Stagehand\ClassUtility\ClassObject;

use Waltz\Stagehand\ClassUtility\CommentObject\PhpDocCommentObject;
use Waltz\Stagehand\ClassUtility\MethodObject\PhpMethodObjectIterator;

/**
 * PhpClassObject
 *
 * @package Waltz.Stagehand
 */
class PhpClassObject
{
    /**
     * Reflection class instance
     *
     * @var ReflectionClass
     */
    private $_reflectionClass;

    /**
     * Constructor
     *
     * @param string $className
     * @param string $namespace
     * @param string $filePath
     */
    public function __construct ( $className, $namespace = '', $filePath = '' ) {
        if ( realpath($filePath) !== false ) {
            require_once $filePath;
        }
        if ( $namespace !== '' ) {
            $className = "$namespace\\$className";
        }
        $this->_reflectionClass = new \ReflectionClass($className);
    }

    /**
     * Get reflection class instance
     *
     * @return ReflectionClass
     */
    public function getReflectionClass ( ) {
        return $this->_reflectionClass;
    }

    /**
     * Get DocComment of class
     *
     * @param bool $withCommentMark
     * @return string DocComment
     */
    public function getDocComment ( $withCommentMark = false ) {
        $docComment = $this->_reflectionClass->getDocComment();
        if ( $withCommentMark === false ) {
            $docComment = PhpDocCommentObject::stripCommentMarks($docComment);
        }
        return $docComment;
    }

    /**
     * List PhpMethodObject instances
     *
     * @return PhpMethodObjectIterator
     */
    public function listPhpMethodObjects ( ) {
        $methodObjectIterator = new PhpMethodObjectIterator($this->_reflectionClass);
        return $methodObjectIterator;
    }
}
