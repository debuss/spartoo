<?php
/**
 * Spartoo API
 *
 * @author debuss-a <zizilex@gmail.com>
 * @copyright 2020 debuss-a
 * @license https://github.com/debuss/spartoo/blob/master/LICENSE.md MIT License
 */

namespace Spartoo\Interfaces;

use DOMDocument;
use DOMElement;

/**
 * Interfaces WebServiceInterface
 *
 * @package Spartoo
 */
interface XMLTransformerInterface
{

    /**
     * @param DOMDocument $document
     * @return DOMElement
     */
    public function toXML(DOMDocument $document);
}
