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

use Waltz\Stagehand\ClassUtility\CommentObject\PhpDocCommentObject;

/**
 * PhpMethodObject
 *
 * @package Waltz.Stagehand
 */
class PhpMethodObject
{
    /**
     * Reflection method instance
     *
     * @var ReflectionMethod
     */
    private $_reflectionMethod;

    /**
     * Constructor
     *
     * @param string $className
     * @param string $methodName
     * @param string $namespace
     * @param string $filePath
     */
    public function __construct ( $className, $methodName, $namespace = '', $filePath = '' ) {
        if ( $filePath !== '' && realpath($filePath) !== false ) {
            require_once $filePath;
        }
        if ( $namespace !== '' ) {
            $className = "$namespace\\$className";
        }
        $this->_reflectionMethod = new \ReflectionMethod($className, $methodName);
    }

    /**
     * Get reflection method instance
     *
     * @return ReflectionMethod
     */
    public function getReflectionMethod ( ) {
        return $this->_reflectionMethod;
    }

    /**
     * Get DocComment of method
     *
     * @param bool $withCommentMark
     * @return string DocComment
     */
    public function getDocComment ( $withCommentMark = false ) {
        $docComment = $this->_reflectionMethod->getDocComment();
        if ( $withCommentMark === true ) {
            $docComment = PhpDocCommentObject::ltrim($docComment);
        } else {
            $docComment = PhpDocCommentObject::stripCommentMarks($docComment);
        }
        return $docComment;
    }
}
