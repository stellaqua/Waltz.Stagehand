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

/**
 * FileUtility
 *
 * @package Waltz.Stagehand
 */
class FileUtility
{
    /**
     * listFilePath
     *
     * @param string $targetPath
     * @return array file path list
     */
    public static function listFilePath ( $targetPath ) {
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
                $fileList = array_merge($fileList, self::listFilePath($realPath));
            } else {
                $fileList[] = $realPath;
            }
        }
        closedir($dh);
        sort($fileList);

        return $fileList;
    }
}
