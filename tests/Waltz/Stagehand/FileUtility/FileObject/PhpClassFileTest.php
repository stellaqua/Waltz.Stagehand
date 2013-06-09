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

use Waltz\Stagehand\FileUtility\FileObject\PhpClassFile;

/**
 * PhpClassFileTest
 *
 * @uses PHPUnit_Framework_TestCase
 * @package Waltz.Stagehand
 */
class PhpClassFileTest extends \PHPUnit_Framework_TestCase
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
        $this->_dataDir = __DIR__ . '/data/PhpClassFileTest';
    }

    /**
     * test_getFileName
     */
    public function test_getFileName ( ) {
        $targetPath = $this->_dataDir . '/OneClass.php';
        $fileObject = new PhpClassFile($targetPath);
        $this->assertSame('OneClass.php', $fileObject->getFileName());
    }

    /**
     * test_getClassNames_Simple_class_definition
     */
    public function test_getClassNames_Simple_class_definition ( ) {
        $targetPath = $this->_dataDir . '/OneClass.php';
        $fileObject = new PhpClassFile($targetPath);
        $this->assertSame(array('FirstClass'), $fileObject->getClassNames());
    }

    /**
     * test_getClassNames_Some_classes
     */
    public function test_getClassNames_Some_classes ( ) {
        $targetPath = $this->_dataDir . '/SomeClasses.php';
        $fileObject = new PhpClassFile($targetPath);
        $expected = array('FirstClass', 'SecondClass');
        $this->assertSame($expected, $fileObject->getClassNames());
    }

    /**
     * test_getClasNames_With_attributes
     */
    public function test_getClasNames_With_attributes ( ) {
        $targetPath = $this->_dataDir . '/WithAttributes.php';
        $fileObject = new PhpClassFile($targetPath);
        $expected = array(
                          'Dummy\FirstClass',
                          'Dummy\SecondClass',
                          'Dummy\ThirdClass',
                         );
        $this->assertSame($expected, $fileObject->getClassNames());
    }

    /**
     * test_getNamespace
     */
    public function test_getNamespace ( ) {
        $targetPath = $this->_dataDir . '/WithNamespace.php';
        $fileObject = new PhpClassFile($targetPath);
        $this->assertSame('Test\Name\Space', $fileObject->getNamespace());
    }

    /**
     * test_getClassNames_With_namespace
     */
    public function test_getClassNames_With_namespace ( ) {
        $targetPath = $this->_dataDir . '/WithNamespace.php';
        $fileObject = new PhpClassFile($targetPath);
        $expected = array('Test\Name\Space\FirstClass');
        $this->assertSame($expected, $fileObject->getClassNames());
    }

    /**
     * test_getClssNames_Without_namespace
     */
    public function test_getClssNames_Without_namespace ( ) {
        $targetPath = $this->_dataDir . '/WithNamespace.php';
        $fileObject = new PhpClassFile($targetPath);
        $expected = array('FirstClass');
        $this->assertSame($expected, $fileObject->getClassNames(false));
    }

    /**
     * test_getClassNames_Class_defined_in_comment
     */
    public function test_getClassNames_Class_defined_in_comment ( ) {
        $targetPath = $this->_dataDir . '/ClassInComment.php';
        $fileObject = new PhpClassFile($targetPath);
        $expected = array('Test\Name\Space\FirstClass');
        $this->assertSame($expected, $fileObject->getClassNames());
    }
}
