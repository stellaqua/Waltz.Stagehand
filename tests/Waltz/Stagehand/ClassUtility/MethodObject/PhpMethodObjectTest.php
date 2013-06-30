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

use Waltz\Stagehand\ClassUtility\MethodObject\PhpMethodObject;

/**
 * PhpMethodObjectTest
 *
 * @uses PHPUnit_Framework_TestCase
 * @package Waltz.Stagehand
 */
class PhpMethodObjectTest extends \PHPUnit_Framework_TestCase
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
        $this->_dataDir = __DIR__ . '/data/PhpMethodObjectTest';
    }

    /**
     * test_getReflectionMethod
     */
    public function test_getReflectionMethod ( ) {
        $targetPath = $this->_dataDir . '/OneMethod.php';
        $methodObject = new PhpMethodObject('OneMethod', 'firstMethod', __NAMESPACE__, $targetPath);
        $this->assertInstanceOf('ReflectionMethod', $methodObject->getReflectionMethod());
    }

    /**
     * test_getDocComment
     */
    public function test_getDocComment ( ) {
        $targetPath = $this->_dataDir . '/WithDocComment.php';
        $methodObject = new PhpMethodObject('WithDocComment', 'withDocComment', __NAMESPACE__, $targetPath);
        $this->assertInstanceOf('ReflectionMethod', $methodObject->getReflectionMethod());
        $expected = "withDocComment\n";
        $expected.= "\n";
        $expected.= "@params string \$string\n";
        $expected.= "@return string Return value";
        $this->assertSame($expected, $methodObject->getDocComment());
    }

    /**
     * test_getDocComment_With_Comment_Mark
     */
    public function test_getDocComment_With_Comment_Mark ( ) {
        $targetPath = $this->_dataDir . '/WithDocComment.php';
        $methodObject = new PhpMethodObject('WithDocComment', 'withDocComment', __NAMESPACE__, $targetPath);
        $this->assertInstanceOf('ReflectionMethod', $methodObject->getReflectionMethod());
        $expected = "/**\n";
        $expected.= " * withDocComment\n";
        $expected.= " *\n";
        $expected.= " * @params string \$string\n";
        $expected.= " * @return string Return value\n";
        $expected.= " */";
        $this->assertSame($expected, $methodObject->getDocComment($withCommentMark = true));
    }

    /**
     * test_getName
     */
    public function test_getName (  )
    {
        $targetPath = $this->_dataDir . '/OneMethod.php';
        $methodObject = new PhpMethodObject('OneMethod', 'firstMethod', __NAMESPACE__, $targetPath);
        $this->assertInstanceOf('ReflectionMethod', $methodObject->getReflectionMethod());
        $this->assertSame('firstMethod', $methodObject->getName());
    }
}
