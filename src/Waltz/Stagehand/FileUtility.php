<?php
/**
 * This file is part of the Waltz.Stagehand package
 *
 * (c) Tomoki Kobayashi <tom@stellaqua.com>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */
namespace Waltz\Stagehand;

use Waltz\Stagehand\FileUtility\FileObject\PhpClassFileObjectIterator;
use Waltz\Stagehand\FileUtility\FileObject\PhpClassFile;

/**
 * FileUtility
 *
 * @package Waltz.Stagehand
 */
class FileUtility
{
    /**
     * listFilePaths
     *
     * @param string $targetPath
     * @return array File path list
     */
    public static function listFilePaths ( $targetPath ) {
        if ( is_file($targetPath) === true ) {
            return array($targetPath);
        }

        if ( !is_dir($targetPath) || !($dh = opendir($targetPath)) ) {
            return array();
        }

        $fileList = array();
        while ( ($fileName = readdir($dh)) !== false ) {
            if ( $fileName === '.' || $fileName === '..' ) {
                continue;
            }

            $realPath = realpath($targetPath) . '/' . $fileName;

            if ( is_dir($realPath) === true ) {
                $fileList = array_merge($fileList, self::listFilePaths($realPath));
            } else {
                $fileList[] = $realPath;
            }
        }
        closedir($dh);
        sort($fileList);

        return $fileList;
    }

    /**
     * listPhpClassFileObjects
     *
     * @param string $targetPath
     * @return PhpClassFileObjectIterator
     */
    public static function listPhpClassFileObjects ( $targetPath ) {
        $fileObjectIterator = new PhpClassFileObjectIterator($targetPath);
        return $fileObjectIterator;
    }

    /**
     * getPhpClassFileObject
     *
     * @param stringd $targetPath
     * @return PhpClassFile
     */
    public static function getPhpClassFileObject ( $targetPath )
    {
        $fileObject = new PhpClassFile($targetPath);
        return $fileObject;
    }
}
