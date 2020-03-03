<?php
/**
 * Spartoo API
 *
 * @author debuss-a <zizilex@gmail.com>
 * @copyright 2020 debuss-a
 * @license https://github.com/debuss/spartoo/blob/master/LICENSE.md MIT License
 */

namespace Spartoo\Exception;

use Exception;

/**
 * Class APIException
 *
 * @package Spartoo\Exception
 */
class APIException extends Exception
{

    /**
     * @return static
     */
    public static function noXMLResponse(string $url)
    {
        return new static(sprintf(
            'Unable to get XML response from Spartoo API (%s).',
            $url
        ));
    }
}
