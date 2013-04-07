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

use Waltz\Stagehand\FileUtility;

/**
 * PhpClassFileObjectIterator
 *
 * @package Waltz.Stagehand
 */
class PhpClassFileObjectIterator implements \Iterator
{
    private $_filePathList;

    /**
     * Constructor
     *
     * @param string $targetPath
     */
    public function __construct ( $targetPath ) {
        $this->_filePathList = FileUtility::listFilePaths($targetPath);
    }

    public function rewind ( ) {
        reset($this->_filePathList);
    }

    public function key ( ) {
        return key($this->_filePathList);
    }

    public function current ( ) {
        $fileObject = new PhpClassFile(current($this->_filePathList));
        return $fileObject;
    }

    public function next ( ) {
        next($this->_filePathList);
    }

    public function valid ( ) {
        return !is_null($this->key());
    }
}
