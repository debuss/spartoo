<?php
/**
 * Spartoo API
 *
 * @author debuss-a <zizilex@gmail.com>
 * @copyright 2020 debuss-a
 * @license https://github.com/debuss/spartoo/blob/master/LICENSE.md MIT License
 */

namespace Spartoo\Object;

use DOMDocument;
use DOMElement;
use Spartoo\Exception\InvalidArgumentException;
use Spartoo\Provisionning;

/**
 * Class ProductMultiCountry
 *
 * @package Spartoo
 */
class ProductMultiCountry extends Product
{

    /** @var Language[] */
    protected $languages;

    /**
     * @return Language[]
     */
    public function getLanguages(): array
    {
        return $this->languages;
    }

    /**
     * @param Language[] $languages
     * @return ProductMultiCountry
     * @throws InvalidArgumentException
     * @throws \Spartoo\Exception\XMLFileException
     */
    public function setLanguages(array $languages): ProductMultiCountry
    {
        foreach ($languages as $language) {
            if (!$language instanceof Language) {
                throw InvalidArgumentException::inconsistentRecordDataType('languages', Language::class);
            }

            if (!in_array($language->getCode(), Provisionning::getInstance()->getLanguages())) {
                throw InvalidArgumentException::notSupportedCountryCode($language->getCode());
            }
        }

        $this->languages = $languages;
        return $this;
    }

    /**
     * @param DOMDocument $document
     * @return DOMElement
     */
    public function toXML(DOMDocument $document)
    {
        $this->product_name = null;
        $this->product_description = null;
        $this->product_color = null;
        $this->product_price = null;
        $this->discount = null;

        return parent::toXML($document);
    }
}
