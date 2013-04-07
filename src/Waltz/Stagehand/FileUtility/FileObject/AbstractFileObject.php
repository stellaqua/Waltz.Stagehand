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

/**
 * AbstractFileObject
 *
 * @package Waltz.Stagehand
 */
abstract class AbstractFileObject
{
    /**
     * File path
     *
     * @var string
     */
    protected $_filePath = '';

    /**
     * File content
     *
     * @var string
     */
    protected $_content = '';

    /**
     * Constructor
     *
     * @param string $filePath
     */
    public function __construct ( $filePath ) {
        $this->_filePath = $filePath;
        if ( realpath($filePath) !== false ) {
            $this->_content = file_get_contents($filePath);
        }
    }

    /**
     * getFileName
     *
     * @return string File name
     */
    public function getFileName ( ) {
        return basename($this->_filePath);
    }
}
