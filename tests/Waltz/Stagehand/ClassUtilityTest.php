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

use Waltz\Stagehand\ClassUtility;

/**
 * ClassUtilityTest
 *
 * @uses PHPUnit_Framework_TestCase
 * @package Waltz.Stagehand
 */
class ClassUtilityTest extends \PHPUnit_Framework_TestCase
{
    public function test_splitClassName (  )
    {
        $expected = array('Name\Space', 'FirstClass');
        $this->assertSame($expected, ClassUtility::splitClassName('Name\Space\FirstClass'));
        $this->assertSame(array('', 'FirstClass'), ClassUtility::splitClassName('FirstClass'));
    }
}
