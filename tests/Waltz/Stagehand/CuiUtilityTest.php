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

use Waltz\Stagehand\CuiUtility;

class CuiUtilityTest extends \PHPUnit_Framework_TestCase
{
    public function test_drawByLine_No_tags ( ) {
        $cuiUtility = new CuiUtility();
        $text = 'Hello World!';
        $this->expectOutputString($text . "\033[1B\033[12D");
        $cuiUtility->drawByLine($text);
    }

    public function test_drawByLine_With_text_color_tags ( ) {
        $cuiUtility = new CuiUtility();
        $text = '<tc:green>OK</tc>';
        $expected = "\033[32mOK\033[39m\033[1B\033[2D";
        $this->expectOutputString($expected);
        $cuiUtility->drawByLine($text);
    }

    public function test_drawByLine_With_background_color_tags ( ) {
        $cuiUtility = new CuiUtility();
        $text = '<bc:cyan>Cyan</bc>';
        $expected = "\033[46mCyan\033[49m\033[1B\033[4D";
        $this->expectOutputString($expected);
        $cuiUtility->drawByLine($text);
    }

    public function test_drawByLine_Multiple_tags ( ) {
        $cuiUtility = new CuiUtility();
        $text = '<tc:green>OK</tc>Normal<bc:cyan>Cyan</bc>';
        $expected = "\033[32mOK\033[39mNormal\033[46mCyan\033[49m\033[1B\033[12D";
        $this->expectOutputString($expected);
        $cuiUtility->drawByLine($text);
    }

    public function test_drawByBlock_No_tags ( ) {
        $cuiUtility = new CuiUtility();
        $text = array('First Line', 'Second Line', 'Third Line');
        $expected = '';
        $expected.= "\n\n\n\033[3A";
        $expected.= "First Line";
        $expected.= "\033[1B\033[10D";
        $expected.= "Second Line";
        $expected.= "\033[1B\033[11D";
        $expected.= "Third Line";
        $expected.= "\033[1B\033[10D";
        $expected.= "\033[3A\033[11C";
        $expected.= "\n\n\n";
        $this->expectOutputString($expected);
        $cuiUtility->setCanvas(count($text))
            ->drawByBlock($text)
            ->finishDrawingByBlock();
    }

    public function test_drawByBlock_Some_blocks ( ) {
        $cuiUtility = new CuiUtility();
        $block1 = array('block1', 'block1');
        $block2 = array('block2', 'block2');
        $expected = '';
        $expected.= "\n\n\033[2A";
        $expected.= "block1";
        $expected.= "\033[1B\033[6D";
        $expected.= "block1";
        $expected.= "\033[1B\033[6D";
        $expected.= "\033[2A\033[6C";
        $expected.= "block2";
        $expected.= "\033[1B\033[6D";
        $expected.= "block2";
        $expected.= "\033[1B\033[6D";
        $expected.= "\033[2A\033[6C";
        $this->expectOutputString($expected);
        $cuiUtility->setCanvas(count($block1))
            ->drawByBlock($block1)
            ->drawByBlock($block2);
    }

    public function test_drawByBlock_With_text_color_tags ( ) {
        $cuiUtility = new CuiUtility();
        $text = array('<tc:red>red</tc>', '<tc:green>green</tc>', '<tc:blue>blue</tc>');
        $expected = '';
        $expected.= "\n\n\n\033[3A";
        $expected.= "\033[31mred\033[39m";
        $expected.= "\033[1B\033[3D";
        $expected.= "\033[32mgreen\033[39m";
        $expected.= "\033[1B\033[5D";
        $expected.= "\033[34mblue\033[39m";
        $expected.= "\033[1B\033[4D";
        $expected.= "\033[3A\033[5C";
        $this->expectOutputString($expected);
        $cuiUtility->setCanvas(count($text))->drawByBlock($text);
    }
}
