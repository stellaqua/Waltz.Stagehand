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

use Waltz\Stagehand\FileUtility;
use Waltz\Stagehand\FileUtility\FileObject\PhpClassFileObjectIterator;

/**
 * FileUtilityTest
 *
 * @uses PHPUnit_Framework_TestCase
 * @package Waltz.Stagehand
 */
class FileUtilityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test data directory
     *
     * @var string
     */
    private $_dataDir = '';

    /**
     * setUp
     */
    protected function setUp ( ) {
        $this->_dataDir = __DIR__ . '/data/FileUtilityTest';
    }

    /**
     * test_listFilePaths_One_file
     */
    public function test_listFilePaths_One_file ( ) {
        $targetPath = $this->_dataDir . '/one_file';
        $expected = array(
                          "$targetPath/file1",
                         );
        $this->assertSame($expected, FileUtility::listFilePaths($targetPath));
    }

    /**
     * test_listFilePaths_Files_in_one_directory
     */
    public function test_listFilePaths_Files_in_one_directory ( ) {
        $targetPath = $this->_dataDir . '/files_in_one_directory';
        $expected = array(
                          "$targetPath/file1",
                          "$targetPath/file2",
                          "$targetPath/file3",
                         );
        $this->assertSame($expected, FileUtility::listFilePaths($targetPath));
    }

    /**
     * test_listFilePaths_List_recursively
     */
    public function test_listFilePaths_List_recursively ( ) {
        $targetPath = $this->_dataDir . '/list_recursively';
        $expected = array(
                          "$targetPath/dir1/dir2/file4",
                          "$targetPath/dir1/file2",
                          "$targetPath/dir1/file3",
                          "$targetPath/file1",
                         );
        $this->assertSame($expected, FileUtility::listFilePaths($targetPath));
    }

    /**
     * test_listPhpClassFileObjects_One_file
     */
    public function test_listPhpClassFileObjects_One_file ( ) {
        $targetDir = $this->_dataDir . '/one_file';
        $fileObjectIterator = FileUtility::listPhpClassFileObjects($targetDir);

        $namespace = __NAMESPACE__ . '\FileUtility\FileObject';
        $expectedClassName = $namespace . '\PhpClassFileObjectIterator';
        $this->assertInstanceOf($expectedClassName, $fileObjectIterator);
        $this->assertCount(1, $fileObjectIterator);

        $expectedClassName = $namespace . '\PhpClassFile';
        foreach ($fileObjectIterator as $fileObject) {
            $this->assertInstanceOf($expectedClassName, $fileObject);
        }
    }

    /**
     * test_getPhpClassFileObject_One_file
     */
    public function test_getPhpClassFileObject_One_file (  )
    {
        $targetPath = $this->_dataDir . '/one_file';
        $fileObject = FileUtility::getPhpClassFileObject($targetPath);
        $namespace = __NAMESPACE__ . '\FileUtility\FileObject';
        $expectedClassName = $namespace . '\PhpClassFile';
        $this->assertInstanceOf($expectedClassName, $fileObject);
    }
}
