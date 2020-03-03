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
use Spartoo\Exception\InvalidArgumentException;
use Spartoo\Interfaces\XMLTransformerInterface;
use Spartoo\Provisionning;

/**
 * Class Langue
 *
 * @package Spartoo
 */
class Language implements XMLTransformerInterface
{

    /** @var string */
    protected $code;

    /** @var string */
    protected $product_name;

    /** @var string */
    protected $product_description;

    /** @var string */
    protected $product_color;

    /** @var float */
    protected $product_price;

    /** @var Discount */
    protected $discount;

    /**
     * Language constructor.
     * @param string $code
     * @param string $product_name
     * @param string $product_description
     * @param string $product_color
     * @param float $product_price
     * @param Discount $discount
     * @throws InvalidArgumentException
     */
    public function __construct(string $code, string $product_name, ?string $product_description, ?string $product_color, float $product_price, ?Discount $discount = null)
    {
        $this->setCode($code);

        $this->product_name = $product_name;
        $this->product_description = $product_description;
        $this->product_color = $product_color;
        $this->product_price = $product_price;
        $this->discount = $discount;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return Language
     * @throws InvalidArgumentException
     * @throws \Spartoo\Exception\XMLFileException
     */
    public function setCode(string $code): Language
    {

        if (!in_array($code, Provisionning::getInstance()->getLanguages())) {
            throw InvalidArgumentException::notSupportedCountryCode($code);
        }

        $this->code = $code;
        return $this;
    }

    /**
     * @return string
     */
    public function getProductName(): string
    {
        return $this->product_name;
    }

    /**
     * @param string $product_name
     * @return Language
     */
    public function setProductName(string $product_name): Language
    {
        $this->product_name = $product_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getProductDescription(): string
    {
        return $this->product_description;
    }

    /**
     * @param string $product_description
     * @return Language
     */
    public function setProductDescription(string $product_description): Language
    {
        $this->product_description = $product_description;
        return $this;
    }

    /**
     * @return string
     */
    public function getProductColor(): string
    {
        return $this->product_color;
    }

    /**
     * @param string $product_color
     * @return Language
     */
    public function setProductColor(string $product_color): Language
    {
        $this->product_color = $product_color;
        return $this;
    }

    /**
     * @return float
     */
    public function getProductPrice(): float
    {
        return $this->product_price;
    }

    /**
     * @param float $product_price
     * @return Language
     */
    public function setProductPrice(float $product_price): Language
    {
        $this->product_price = $product_price;
        return $this;
    }

    /**
     * @return Discount
     */
    public function getDiscount(): Discount
    {
        return $this->discount;
    }

    /**
     * @param Discount $discount
     * @return Language
     */
    public function setDiscount(Discount $discount): Language
    {
        $this->discount = $discount;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toXML(DOMDocument $document)
    {
        $language = $document->createElement('language');

        foreach (array_filter(get_object_vars($this)) as $property => $value) {
            if ($property == 'discount') {
                $language->appendChild($this->getDiscount()->toXML($document));
                continue;
            }

            $language->appendChild($document->createElement($property, $value));
        }

        return $language;
    }
}
