<?php
/**
 * This file is part of the Waltz.Stagehand package
 *
 * (c) Tomoki Kobayashi <tom@stellaqua.com>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */
namespace Waltz\Stagehand\ClassUtility\CommentObject;

use Waltz\Stagehand\ClassUtility\CommentObject\PhpDocCommentObject;

/**
 * PhpDocCommentObjectTest
 *
 * @uses PHPUnit_Framework_TestCase
 * @package Waltz.Stagehand
 */
class PhpDocCommentObjectTest extends \PHPUnit_Framework_TestCase
{
    /**
     * test_stripCommentMarks
     */
    public function test_stripCommentMarks ( ) {
        $docComment = "/**\n";
        $docComment.= " * TestComment\n";
        $docComment.= " *\n";
        $docComment.= " * @params string \$string\n";
        $docComment.= " * @return string\n";
        $docComment.= " */";
        $expected = "TestComment\n";
        $expected.= "\n";
        $expected.= "@params string \$string\n";
        $expected.= "@return string";
        $this->assertSame($expected, PhpDocCommentObject::stripCommentMarks($docComment));
    }

    /**
     * test_ltrim
     */
    public function test_ltrim ( ) {
        $docComment = "\t/**\n";
        $docComment.= "\t * TestComment\n";
        $docComment.= "\t *\n";
        $docComment.= "\t * @params string \$string\n";
        $docComment.= "\t * @return string Return value\n";
        $docComment.= "\t */";
        $expected = "/**\n";
        $expected.= " * TestComment\n";
        $expected.= " *\n";
        $expected.= " * @params string \$string\n";
        $expected.= " * @return string Return value\n";
        $expected.= " */";
        $this->assertSame($expected, PhpDocCommentObject::ltrim($docComment));
    }
}
