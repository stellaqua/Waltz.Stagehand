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

/**
 * PhpClassObjectTest
 *
 * @uses PHPUnit_Framework_TestCase
 * @package Waltz.Stagehand
 */
class PhpClassObjectTest extends \PHPUnit_Framework_TestCase
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
        $this->_dataDir = __DIR__ . '/data/PhpClassObjectTest';
    }

    /**
     * test_getReflectionClass
     */
    public function test_getReflectionClass ( ) {
        $targetPath = $this->_dataDir . '/OneClass.php';
        $classObject = new PhpClassObject('OneClass', __NAMESPACE__, $targetPath);
        $this->assertInstanceOf('ReflectionClass', $classObject->getReflectionClass());
    }

    /**
     * test_getDocComment
     */
    public function test_getDocComment ( ) {
        $targetPath = $this->_dataDir . '/WithDocComment.php';
        $classObject = new PhpClassObject('WithDocComment', __NAMESPACE__, $targetPath);
        $this->assertInstanceOf('ReflectionClass', $classObject->getReflectionClass());
        $expected = "WithDocComment\n\n@package Waltz";
        $this->assertSame($expected, $classObject->getDocComment());
    }

    /**
     * test_getDocComment_With_Comment_Mark
     */
    public function test_getDocComment_With_Comment_Mark ( ) {
        $targetPath = $this->_dataDir . '/WithDocComment.php';
        $classObject = new PhpClassObject('WithDocComment', __NAMESPACE__, $targetPath);
        $this->assertInstanceOf('ReflectionClass', $classObject->getReflectionClass());
        $expected = "/**\n * WithDocComment\n *\n * @package Waltz\n */";
        $this->assertSame($expected, $classObject->getDocComment($withCommentMark = true));
    }

    /**
     * test_listPhpMethodObjects
     */
    public function test_listPhpMethodObjects ( ) {
        $targetPath = $this->_dataDir . '/SomeMethods.php';
        $classObject = new PhpClassObject('SomeMethods', __NAMESPACE__, $targetPath);
        $this->assertInstanceOf('ReflectionClass', $classObject->getReflectionClass());
        $methodObjects = $classObject->listPhpMethodObjects();
        foreach ( $methodObjects as $methodObject ) {
            $this->assertInstanceOf('Waltz\Stagehand\ClassUtility\MethodObject\PhpMethodObject', $methodObject);
        }
    }

    /**
     * test_listPhpMethodObjects_For_Child_Class
     */
    public function test_listPhpMethodObjects_For_Child_Class ( ) {
        $targetPath = $this->_dataDir . '/ChildClass.php';
        $classObject = new PhpClassObject('ChildClass', __NAMESPACE__, $targetPath);
        $this->assertInstanceOf('ReflectionClass', $classObject->getReflectionClass());
        $methodObjects = $classObject->listPhpMethodObjects();
        $this->assertCount(1, $methodObjects);
        foreach ( $methodObjects as $methodObject ) {
            $this->assertInstanceOf('Waltz\Stagehand\ClassUtility\MethodObject\PhpMethodObject', $methodObject);
            $methodReflection = $methodObject->getReflectionMethod();
            $classReflection = $methodReflection->getDeclaringClass();
            $this->assertSame('Waltz\Stagehand\ClassUtility\ClassObject\ChildClass', $classReflection->getName());
        }
    }

    /**
     * test_getName
     */
    public function test_getName (  )
    {
        $targetPath = $this->_dataDir . '/OneClass.php';
        $classObject = new PhpClassObject('OneClass', __NAMESPACE__, $targetPath);
        $this->assertInstanceOf('ReflectionClass', $classObject->getReflectionClass());
        $this->assertSame(__NAMESPACE__ . '\OneClass', $classObject->getName());
    }

    /**
     * test_getName_Without_Namespace
     */
    public function test_getName_Without_Namespace (  )
    {
        $targetPath = $this->_dataDir . '/OneClass.php';
        $classObject = new PhpClassObject('OneClass', __NAMESPACE__, $targetPath);
        $this->assertInstanceOf('ReflectionClass', $classObject->getReflectionClass());
        $this->assertSame('OneClass', $classObject->getName(true));
    }
}
