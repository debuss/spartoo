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
 * Class XMLFileException
 *
 * @package Spartoo\Exception
 */
class XMLFileException extends Exception
{

    /**
     * @param string $path
     * @return static
     */
    public static function unableToReadProvisionningFile(string $path)
    {
        return new static(sprintf(
            'Unable to read the provisionning file [%s].',
            $path
        ));
    }

    /**
     * @param string $lang
     * @return static
     */
    public static function wrongLanguage(string $lang)
    {
        return new static(sprintf(
            'No provisionning file found for the language %s. Please use one of the following: %s.',
            $lang,
            implode(', ', ['AT', 'BE', 'CZ', 'DE', 'DK', 'EN', 'ES', 'FI', 'FR', 'GR', 'IT', 'NL', 'PL', 'PT', 'SE'])
        ));
    }
}