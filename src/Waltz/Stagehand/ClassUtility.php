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

/**
 * ClassUtility
 *
 * @package Waltz.Stagehand
 */
class ClassUtility
{
    /**
     * Split class name
     *
     * @param string $className Class name with namespace
     * @return string Namespace
     */
    public static function splitClassName ( $className )
    {
        $chunk = explode('\\', $className);
        $className = array_pop($chunk);
        $namespace = implode('\\', $chunk);
        $result = array($namespace, $className);
        return $result;
    }
}
