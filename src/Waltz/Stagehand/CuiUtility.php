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

use Waltz\Stagehand\CuiUtility\CursorObject;
use Waltz\Stagehand\CuiUtility\DecorationsObject;

/**
 * CuiUtility
 *
 * @package Waltz.Stagehand
 */
class CuiUtility
{
    /**
     * Cursor object
     *
     * @var CursorObject
     */
    private $_cursor;

    /**
     * Decorations object
     *
     * @var DecorationsObject
     */
    private $_decorations;

    /**
     * Canvas size
     *
     * @var array (width, height)
     */
    private $_canvasSize = array(0, 0);

    /**
     * Constructor
     */
    public function __construct ( ) {
        $this->_cursor = new CursorObject(array(0, 0));
        $this->_decorations = new DecorationsObject();
    }

    /**
     * Set canvas
     *
     * @param int $lineCount Line count of canvas
     * @return CuiUtility Self instance
     */
    public function setCanvas ( $lineCount ) {
        echo str_repeat("\n", $lineCount);
        echo CursorObject::getMovingEscapeSequences(0, -$lineCount);
        $this->_canvasSize[1] = $lineCount;
        return $this;
    }

    /**
     * Draw by block
     *
     * @param array $text Drawing text with decoration tags
     * @return CuiUtility Self instance
     */
    public function drawByBlock ( array $text ) {
        $maxWidth = 0;
        foreach ( $text as $line ) {
            $this->drawByLine($line, true);
            $lineWidth = $this->_getActualLength($line);
            if ( $lineWidth > $maxWidth ) {
                $maxWidth = $lineWidth;
                $this->_canvasSize[0] = $lineWidth;
            }
        }
        echo $this->_cursor
            ->setAncor()
            ->move($maxWidth, -count($text))
            ->getEscapeSequencesByPath();
        return $this;
    }

    /**
     * Draw by line
     *
     * @param string $text Drawing text with decoration tags
     * @param bool $insertLineFeeds Which insert line feeds
     * @return CuiUtility Self instance
     */
    public function drawByLine ( $text, $insertLineFeeds = true ) {
        $convertedText = $this->_convertTagsToEscapeSequences($text);
        echo $convertedText;
        if ( $insertLineFeeds === true ) {
            $width = $this->_getActualLength($text);
            echo $this->_cursor
                ->insertLineFeeds($width)
                ->getEscapeSequencesByPath();
        }
        return $this;
    }

    /**
     * Finish drawing by block
     *
     * @return CuiUtility Self instance
     */
    public function finishDrawingByBlock ( ) {
        $canvasHeight = $this->_canvasSize[1];
        echo str_repeat("\n", $canvasHeight);
        $this->_cursor->moveHome()
            ->move(0, $canvasHeight);
        return $this;
    }

    /**
     * Convert tags to escape sequences
     *
     * @param string $text Text with decoration tags
     * @return string Converted text
     */
    private function _convertTagsToEscapeSequences ( $text ) {
        list($patterns, $replacements) = $this->_getConvertingDictionary();
        $convertedText = preg_replace($patterns, $replacements, $text);
        return $convertedText;
    }

    /**
     * Strip escape sequences
     *
     * @param string $text Original text
     * @return string Stripped text
     */
    private function _stripEscapeSequences ( $text ) {
        $pattern = '/\x1B\[([0-9]{1,2}(;[0-9]{1,2})?)?[m|K]/';
        $strippedText = preg_replace($pattern, '', $text);
        return $strippedText;
    }

    /**
     * Get actual length
     *
     * @param string $text Original text
     * @return int Actual length
     */
    private function _getActualLength ( $text ) {
        $convertedText = $this->_convertTagsToEscapeSequences($text);
        $strippedText = $this->_stripEscapeSequences($convertedText);
        $length = mb_strlen($strippedText, 'utf-8');
        return $length;
    }

    /**
     * Get converting dictionary
     *
     * @return array Converting dictionary
     */
    private function _getConvertingDictionary ( ) {
        $definedColors = DecorationsObject::getDefinedColors();
        foreach ( $definedColors as $colorName => $escapeSequences ) {
            list($textColorEscapeSequence, $backgroundColorEscapeSequence) = $escapeSequences;
            $patterns[] = "|<tc:$colorName>|";
            $replacements[] = $textColorEscapeSequence;
            $patterns[] = "|<bc:$colorName>|";
            $replacements[] = $backgroundColorEscapeSequence;
        }

        $resetEscapeSequences = $definedColors['reset'];
        $patterns[] = '|</tc>|';
        $replacements[] = $resetEscapeSequences[0];
        $patterns[] = '|</bc>|';
        $replacements[] = $resetEscapeSequences[1];

        $definedStyles = DecorationsObject::getDefinedStyles();
        $resetEscapeSequence = $definedStyles['reset'];
        foreach ( $definedStyles as $styleName => $escapeSequence ) {
            $patterns[] = "|<$styleName>|";
            $replacements[] = $escapeSequence;
            $patterns[] = "|</$styleName>|";
            $replacements[] = $escapeSequence;
        }

        $dictionary = array($patterns, $replacements);
        return $dictionary;
    }
}
