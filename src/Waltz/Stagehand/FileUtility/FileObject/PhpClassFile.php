<?php
/**
 * This file is part of the Waltz.Stagehand package
 *
 * (c) Tomoki Kobayashi <tom@stellaqua.com>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */
namespace Waltz\Stagehand\FileUtility\FileObject;

use Waltz\Stagehand\FileUtility\FileObject\AbstractFileObject;

/**
 * PhpClassFile
 *
 * @uses AbstractFileObject
 * @package Waltz.Stagehand
 */
class PhpClassFile extends AbstractFileObject
{
    /**
     * Get namespace defined in target file
     *
     * @return string defined namespace
     */
    public function getNamespace ( ) {
        $pattern = '/namespace +([^ ;]+).*\r?\n/ui';
        if ( preg_match($pattern, $this->_content, $matches) !== 1 ) {
            return '';
        }
        return $matches[1];
    }

    /**
     * Get class names defined in target file
     *
     * @param bool $withNamespace
     * @return array defined class names
     */
    public function getClassNames ( $withNamespace = true ) {
        $tokens = new \PHP_Token_Stream($this->_content);
        $classes = $tokens->getClasses();
        $classNames = array();
        foreach ( $classes as $className => $class ) {
            $namespace = $class['package']['namespace'];
            if ( $withNamespace === true && $namespace !== '' ) {
                $className = $namespace . '\\' . $className;
            }
            $classNames[] = $className;
        }
        return $classNames;
    }
}
