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
use Spartoo\Interfaces\XMLTransformerInterface;

/**
 * Class Discount
 *
 * @package Spartoo
 */
class Discount implements XMLTransformerInterface
{

    /** @var int */
    protected $startdate;

    /** @var int */
    protected $stopdate;

    /** @var float */
    protected $price_discount;

    /** @var int */
    protected $rate;

    /** @var bool */
    protected $sales;

    /**
     * Discount constructor.
     * @param int $startdate
     * @param int $stopdate
     * @param float $price_discount
     * @param int $rate
     * @param bool $sales
     */
    public function __construct(int $startdate, int $stopdate, ?float $price_discount = null, ?int $rate = null, bool $sales = false)
    {
        $this->startdate = $startdate;
        $this->stopdate = $stopdate;
        $this->price_discount = $price_discount;
        $this->rate = $rate;
        $this->sales = $sales;
    }

    /**
     * @return int
     */
    public function getStartdate(): int
    {
        return $this->startdate;
    }

    /**
     * @param int $startdate
     * @return Discount
     */
    public function setStartdate(int $startdate): Discount
    {
        $this->startdate = $startdate;
        return $this;
    }

    /**
     * @return int
     */
    public function getStopdate(): int
    {
        return $this->stopdate;
    }

    /**
     * @param int $stopdate
     * @return Discount
     */
    public function setStopdate(int $stopdate): Discount
    {
        $this->stopdate = $stopdate;
        return $this;
    }

    /**
     * @return float
     */
    public function getPriceDiscount(): float
    {
        return $this->price_discount;
    }

    /**
     * @param float $price_discount
     * @return Discount
     */
    public function setPriceDiscount(float $price_discount): Discount
    {
        $this->price_discount = $price_discount;
        return $this;
    }

    /**
     * @return int
     */
    public function getRate(): int
    {
        return $this->rate;
    }

    /**
     * @param int $rate
     * @return Discount
     */
    public function setRate(int $rate): Discount
    {
        $this->rate = $rate;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSales(): bool
    {
        return $this->sales;
    }

    /**
     * @param bool $sales
     * @return Discount
     */
    public function setSales(bool $sales): Discount
    {
        $this->sales = $sales;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toXML(DOMDocument $document)
    {
        $discount = $document->createElement('discount');

        foreach (array_filter(get_object_vars($this)) as $property => $value) {
            $discount->appendChild($document->createElement($property, $value));
        }

        return $discount;
    }
}
