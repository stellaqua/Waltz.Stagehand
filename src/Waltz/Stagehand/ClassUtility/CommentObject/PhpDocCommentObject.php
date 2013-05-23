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

/**
 * PhpDocCommentObject
 *
 * @package Waltz.Stagehand
 */
class PhpDocCommentObject
{
    /**
     * Strip comment marks
     *
     * @param string $docComment
     * @return string DocComment stripped comment marks
     */
    public static function stripCommentMarks ( $docComment ) {
        $regexp = array(
                        '|^\s*/\*\*|um' => '',
                        '|^\s*\*/|um' => '',
                        '|^\s*\*[ ]*|um' => '',
                       );
        $patterns = array_keys($regexp);
        $replacements = array_values($regexp);
        $docComment = preg_replace($patterns, $replacements, $docComment);
        $docComment = trim($docComment);
        return $docComment;
    }

    /**
     * Trim spaces and tabs on the left
     *
     * @param string $docComment
     * @return string Trimmed DocComment
     */
    public static function ltrim ( $docComment ) {
        $regexp = array(
                        '|^[\s\t]*(/\*\*)|um' => '\\1',
                        '|^[\s\t]*([ ]\*/)|um' => '\\1',
                        '|^[\s\t]*([ ]\*[ ]*)|um' => '\\1',
                       );
        $patterns = array_keys($regexp);
        $replacements = array_values($regexp);
        $docComment = preg_replace($patterns, $replacements, $docComment);
        $docComment = trim($docComment);
        return $docComment;
    }
}
