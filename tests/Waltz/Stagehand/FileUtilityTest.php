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
 * SimpleTest
 *
 * @uses PHPUnit_Framework_TestCase
 * @package Waltz.Stagehand
 */
class FileUtilityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * test_listFilePath_One_file
     */
    public function test_listFilePath_One_file ( ) {
        $targetPath = __DIR__ . '/data/one_file';
        $targetFilePathList = array(
                                    "$targetPath/file1",
                                   );
        $this->assertSame($targetFilePathList, FileUtility::listFilePath($targetPath));
    }

    /**
     * test_listFilePath_Files_in_one_directory
     */
    public function test_listFilePath_Files_in_one_directory ( ) {
        $targetPath = __DIR__ . '/data/files_in_one_directory';
        $targetFilePathList = array(
                                    "$targetPath/file1",
                                    "$targetPath/file2",
                                    "$targetPath/file3",
                                   );
        $this->assertSame($targetFilePathList, FileUtility::listFilePath($targetPath));
    }

    /**
     * test_listFilePath_List_recursively
     */
    public function test_listFilePath_List_recursively ( ) {
        $targetPath = __DIR__ . '/data/list_recursively';
        $targetFilePathList = array(
                                    "$targetPath/dir1/dir2/file4",
                                    "$targetPath/dir1/file2",
                                    "$targetPath/dir1/file3",
                                    "$targetPath/file1",
                                   );
        $this->assertSame($targetFilePathList, FileUtility::listFilePath($targetPath));
    }
}
