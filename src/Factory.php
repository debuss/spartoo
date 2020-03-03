<?php
/**
 * Spartoo API
 *
 * @author debuss-a <zizilex@gmail.com>
 * @copyright 2020 debuss-a
 * @license https://github.com/debuss/spartoo/blob/master/LICENSE.md MIT License
 */

namespace Spartoo;

use Spartoo\Object\Discount;
use Spartoo\Object\Info;
use Spartoo\Object\Language;
use Spartoo\Object\Product;
use Spartoo\Object\ProductMultiCountry;
use Spartoo\Object\Size;

/**
 * Class Factory
 *
 * @package Spartoo
 */
class Factory
{

    /**
     * @param string $reference
     * @param string $name
     * @param string $manufacturer
     * @param float $price
     * @return Product
     */
    public static function getProduct(string $reference, string $name, string $manufacturer, float $price)
    {
        return (new Product())
            ->setReferencePartenaire($reference)
            ->setProductName($name)
            ->setManufacturersName($manufacturer)
            ->setProductPrice($price);
    }

    /**
     * @param Language[] $language
     * @param string $manufacturer
     * @return mixed
     */
    public static function getProductMultiCountry(array $language, string $manufacturer)
    {
        return (new ProductMultiCountry())
            ->setManufacturersName($manufacturer)
            ->setLanguages($language);
    }

    /**
     * @param string $code
     * @param string $name
     * @param string|null $description
     * @param string|null $color
     * @param float $price
     * @param Discount|null $discount
     * @return Language
     * @throws Exception\InvalidArgumentException
     */
    public static function getLanguage(string $code, string $name, ?string $description, ?string $color, float $price, ?Discount $discount = null)
    {
        return new Language($code, $name, $description, $color, $price, $discount);
    }

    /**
     * @param string $name
     * @param int $quantity
     * @param string $reference
     * @param string|null $ean
     * @return Size
     * @throws Exception\InvalidArgumentException
     * @throws Exception\XMLFileException
     */
    public static function getSize(string $name, int $quantity, string $reference, ?string $ean = null)
    {
        return new Size($name, $quantity, $reference, $ean);
    }

    /**
     * @param int $startdate
     * @param int $stopdate
     * @param float|null $price
     * @param int|null $rate
     * @param bool $sales
     * @return Discount
     */
    public static function getDiscount(int $startdate, int $stopdate, ?float $price, ?int $rate, bool $sales = false)
    {
        return new Discount($startdate, $stopdate, $price, $rate, $sales);
    }

    /**
     * @param int $id
     * @param float $value
     * @return Info
     */
    public static function getInfo(int $id, float $value)
    {
        return new Info($id, $value);
    }
}
