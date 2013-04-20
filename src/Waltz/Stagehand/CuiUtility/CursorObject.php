<?php
/**
 * This file is part of the Waltz.Stagehand package
 *
 * (c) Tomoki Kobayashi <tom@stellaqua.com>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */
namespace Waltz\Stagehand\CuiUtility;

/**
 * CursorObject
 *
 * @package Waltz.Stagehand
 */
class CursorObject
{
    /**
     * Home position
     *
     * @var array
     */
    private $_homePosition;

    /**
     * Current position
     *
     * @var array
     */
    private $_currentPosition;

    /**
     * Ancor position
     *
     * @var array
     */
    private $_ancorPosition;

    /**
     * Constructor
     *
     * @param array $homePosition
     */
    public function __construct ( array $homePosition = array(0, 0) ) {
        $this->_homePosition = $homePosition;
        $this->_currentPosition = $this->_homePosition;
    }

    /**
     * Move up current position
     *
     * @param int $count Move count
     * @return CursorObject Self instance
     */
    public function up ( $count = 0 ) {
        $this->_currentPosition = array(
                                        $this->_currentPosition[0],
                                        $this->_currentPosition[1] - $count,
                                       );
        return $this;
    }

    /**
     * Move down current position
     *
     * @param int $count Move count
     * @return CursorObject Self instance
     */
    public function down ( $count = 0 ) {
        $this->_currentPosition = array(
                                        $this->_currentPosition[0],
                                        $this->_currentPosition[1] + $count,
                                       );
        return $this;
    }

    /**
     * Move left current position
     *
     * @param int $count Move count
     * @return CursorObject Self instance
     */
    public function left ( $count = 0 ) {
        $this->_currentPosition = array(
                                        $this->_currentPosition[0] - $count,
                                        $this->_currentPosition[1],
                                       );
        return $this;
    }

    /**
     * Move right current position
     *
     * @param int $count Move count
     * @return CursorObject Self instance
     */
    public function right ( $count = 0 ) {
        $this->_currentPosition = array(
                                        $this->_currentPosition[0] + $count,
                                        $this->_currentPosition[1],
                                       );
        return $this;
    }

    /**
     * Move current position
     *
     * @param int $dx Horizontal displacement
     * @param int $dy Vertical displacement
     * @return CursorObject Self instance
     */
    public function move ( $dx, $dy ) {
        if ( $dx < 0 ) {
            $this->left(abs($dx));
        } else {
            $this->right(abs($dx));
        }
        if ( $dy < 0 ) {
            $this->up(abs($dy));
        } else {
            $this->down(abs($dy));
        }
        return $this;
    }

    /**
     * Move home position
     *
     * @return CursorObject Self instance
     */
    public function moveHome ( ) {
        $this->_currentPosition = $this->_homePosition;
        return $this;
    }

    /**
     * Insert line feeds
     *
     * @param int $width
     * @return CursorObject Self instance
     */
    public function insertLineFeeds ( $width = 0, $count = 1 ) {
        $this->setAncor()->move(-$width, $count);
        return $this;
    }

    /**
     * Set ancor position
     *
     * @param array $position (x, y)
     * @return CursorObject Self instance
     */
    public function setAncor ( $position = null ) {
        if ( is_null($position) === true ) {
            $position = $this->_currentPosition;
        }
        $this->_ancorPosition = $position;
        return $this;
    }

    /**
     * Get escape sequences by path
     *
     * @param int $dx Horizontal displacement
     * @param int $dy Vertical displacement
     * @return string Escape sequences
     */
    public function getEscapeSequencesByPath ( $dx = null, $dy = null ) {
        if ( is_null($dx) === true ) {
            $dx = $this->_currentPosition[0] - $this->_ancorPosition[0];
        }
        if ( is_null($dy) === true ) {
            $dy = $this->_currentPosition[1] - $this->_ancorPosition[1];
        }
        return self::getMovingEscapeSequences($dx, $dy);
    }

    /**
     * Get moving escape sequences
     *
     * @param int $dx
     * @param int $dy
     * @return string Moving escape sequences
     */
    public static function getMovingEscapeSequences ( $dx, $dy ) {
        $escapeSequences = '';
        if ( $dy < 0 ) {
            $escapeSequences .= self::getUpEscapeSequence(abs($dy));
        } else if ( $dy > 0 ) {
            $escapeSequences .= self::getDownEscapeSequence(abs($dy));
        }
        if ( $dx < 0 ) {
            $escapeSequences .= self::getLeftEscapeSequence(abs($dx));
        } else if ( $dx > 0 ) {
            $escapeSequences .= self::getRightEscapeSequece(abs($dx));
        }
        return $escapeSequences;
    }

    /**
     * Get up escape sequence
     *
     * @param int $count Repeat count
     * @return string Up escape sequence
     */
    public static function getUpEscapeSequence ( $count = 0 ) {
        if ( $count > 0 ) {
            return sprintf("\033[%dA", $count);
        }
        return '';
    }

    /**
     * Get down escape sequence
     *
     * @param int $count Repeat count
     * @return string Down escape sequence
     */
    public static function getDownEscapeSequence ( $count = 0 ) {
        if ( $count > 0 ) {
            return sprintf("\033[%dB", $count);
        }
        return '';
    }

    /**
     * Get left escape sequence
     *
     * @param int $count Repeat count
     * @return string Left escape sequence
     */
    public static function getLeftEscapeSequence ( $count = 0 ) {
        if ( $count > 0 ) {
            return sprintf("\033[%dD", $count);
        }
        return '';
    }

    /**
     * Get right escape sequence
     *
     * @param int $count Repeat count
     * @return string Right escape sequence
     */
    public static function getRightEscapeSequece ( $count = 0 ) {
        if ( $count > 0 ) {
            return sprintf("\033[%dC", $count);
        }
        return '';
    }
}

