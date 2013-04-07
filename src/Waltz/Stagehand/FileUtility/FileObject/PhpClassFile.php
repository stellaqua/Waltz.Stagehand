<?php
/**
 * This file is part of the Waltz.Stagehand package
 *
 * (c) Tomoki Kobayashi <tom@stellaqua.com>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */
namespace Waltz\Stagehand\FileUtility\FileObject;

use Waltz\Stagehand\FileUtility\FileObject\AbstractFileObject;

class PhpClassFile extends AbstractFileObject
{
    /**
     * Get class names defined in target file
     *
     * @return array defined class names
     */
    public function getClassNames ( ) {
        $pattern = '/class +([^ {\r\n]+).*\r?\n/ui';
        if ( preg_match_all($pattern, $this->_content, $matches) === false ) {
            return array();
        }
        return $matches[1];
    }
}
