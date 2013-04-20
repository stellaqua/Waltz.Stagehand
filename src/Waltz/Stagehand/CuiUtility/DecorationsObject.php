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
 * DecorationsObject
 *
 * @package Waltz.Stagehand
 */
class DecorationsObject
{
    /**
     * Text color name
     *
     * @var string
     */
    private $_textColor = 'white';

    /**
     * Background color name
     *
     * @var string
     */
    private $_backgroundColor = 'black';

    /**
     * Which is bold
     *
     * @var bool
     */
    private $_isBold = false;

    /**
     * Which is underlined
     *
     * @var bool
     */
    private $_isUnderlined = false;

    /**
     * Constructor
     *
     * @param array $config
     */
    public function __construct ( array $config = array() ) {
        if ( isset($config['textColor']) === true ) {
            $this->setTextColor($config['textColor']);
        }
        if ( isset($config['backgroundColor']) === true ) {
            $this->setBackgroundColor($config['backgroundColor']);
        }
        if ( isset($config['isBold']) === true ) {
            $this->setIsBold($config['isBold']);
        }
        if ( isset($config['isUnderlined']) === true ) {
            $this->setIsUnserlined($config['isUnderlined']);
        }
    }

    /**
     * Get text color name
     *
     * @return string Text color name
     */
    public function getTextColor ( ) {
        return $this->_textColor;
    }

    /**
     * Get text color escape sequence
     *
     * @param string $color Color name
     * @return string text color escape sequence
     */
    public function getTextColorEscapeSequence ( $colorName = '' ) {
        if ( $this->_isDefinedColor($colorName) === true ) {
            $colors = self::getDefinedColors();
            list($textColor, $backgroundColor) = $colors[$colorName];
            return $textColor;
        }
        return '';
    }

    /**
     * Set text color name
     *
     * @param string $color Text color name
     */
    public function setTextColor ( $color ) {
        if ( $this->_isDefinedColor($color) === true ) {
            $this->_textColor = $color;
        }
    }

    /**
     * Get background color name
     *
     * @return string Background color name
     */
    public function getBackgroundColor ( ) {
        return $this->_backgroundColor;
    }

    /**
     * Get Background color escape sequence
     *
     * @param string $color Color name
     * @return string background color escape sequence
     */
    public function getBackgroundColorEscapeSequence ( $colorName = '' ) {
        if ( $this->_isDefinedColor($colorName) === true ) {
            $colors = self::getDefinedColors();
            list($textColor, $backgroundColor) = $colors[$colorName];
            return $backgroundColor;
        }
        return '';
    }

    /**
     * Set background color name
     *
     * @param string $color Background color name
     */
    public function setBackgroundColor ( $color ) {
        if ( $this->_isDefinedColor($color) === true ) {
            $this->_backgroundColor = $color;
        }
    }

    /**
     * Get is bold
     *
     * @return bool Which is bold
     */
    public function getIsBold ( ) {
        return $this->_isBold;
    }

    /**
     * Get bold escape sequence
     *
     * @return string Bold escape sequence
     */
    public function getBoldEscapeSequence ( ) {
        $styles = self::getDefinedStyles();
        return $styles['bold'];
    }

    /**
     * Set which is bold
     *
     * @param bool $isBold
     */
    public function setIsBold ( $isBold ) {
        if ( $isBold === true ) {
            $this->_isBold = true;
        } else {
            $this->_isBold = false;
        }
    }

    /**
     * Get is underlined
     *
     * @return bool Which is underlined
     */
    public function getIsUnderlined ( ) {
        return $this->_isUnderlined;
    }

    /**
     * Get underlined escape sequence
     *
     * @return string Underlined escape sequence
     */
    public function getUnderlinedEscapeSequence ( ) {
        $styles = self::getDefinedStyles();
        return $styles['underlined'];
    }

    /**
     * Set which is underlined
     *
     * @param bool $isUnderlined
     */
    public function setIsUnderlined ( $isUnderlined ) {
        if ( $isUnderlined === true ) {
            $this->_isUnderlined = true;
        } else {
            $this->_isUnderlined = false;
        }
    }

    /**
     * Get reset escape sequence
     *
     * @return string Reset escape sequence
     */
    public function getResetEscapeSequence ( ) {
        $styles = self::getDefinedStyles();
        return $styles['reset'];
    }

    /**
     * Which is defined color
     *
     * @param string $colorName Color name
     * @return bool Which is defined color
     */
    private function _isDefinedColor ( $colorName ) {
        $colors = self::getDefinedColors();
        $colorNames = array_keys($colors);
        return in_array($colorName, $colorNames);
    }

    /**
     * Get defined colors
     *
     * @return array Defined colors (Text color, Background color)
     */
    public static function getDefinedColors ( ) {
        return array(
                     'black'     => array("\033[30m", "\033[40m"),
                     'red'       => array("\033[31m", "\033[41m"),
                     'green'     => array("\033[32m", "\033[42m"),
                     'yellow'    => array("\033[33m", "\033[43m"),
                     'blue'      => array("\033[34m", "\033[44m"),
                     'magenta'   => array("\033[35m", "\033[45m"),
                     'purple'    => array("\033[35m", "\033[45m"),
                     'cyan'      => array("\033[36m", "\033[46m"),
                     'aqua'      => array("\033[36m", "\033[46m"),
                     'lightblue' => array("\033[36m", "\033[46m"),
                     'white'     => array("\033[37m", "\033[47m"),
                     'reset'     => array("\033[39m", "\033[49m"),
                    );
    }

    /**
     * Get defined styles
     *
     * @return array Defined styles
     */
    public static function getDefinedStyles ( ) {
        return array(
                     'reset'      => "\033[0m",
                     'bold'       => "\033[1m",
                     'underlined' => "\033[4m",
                    );
    }
}
