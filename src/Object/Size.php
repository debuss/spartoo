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
 * Class Size
 *
 * @package Spartoo
 */
class Size implements XMLTransformerInterface
{

    /** @var string */
    protected $size_name;

    /** @var int */
    protected $size_quantity;

    /** @var string */
    protected $size_reference;

    /** @var string */
    protected $ean;

    /**
     * Size constructor.
     * @param string $size_name
     * @param int $size_quantity
     * @param string $size_reference
     * @param null|string $ean
     * @throws InvalidArgumentException
     * @throws \Spartoo\Exception\XMLFileException
     */
    public function __construct(string $size_name, int $size_quantity, string $size_reference, ?string $ean = null)
    {
        $this->setSizeName($size_name);

        $this->size_quantity = $size_quantity;
        $this->size_reference = $size_reference;
        $this->ean = $ean;
    }

    /**
     * @return string
     */
    public function getSizeName(): string
    {
        return $this->size_name;
    }

    /**
     * @param string $size_name
     * @return Size
     * @throws InvalidArgumentException
     * @throws \Spartoo\Exception\XMLFileException
     */
    public function setSizeName(?string $size_name): Size
    {
        if ($size_name && !in_array($size_name, array_column(Provisionning::getInstance()->getSizes(), 'size_name'))) {
            throw InvalidArgumentException::notSupportedSize($size_name);
        }

        $this->size_name = $size_name;
        return $this;
    }

    /**
     * @return int
     */
    public function getSizeQuantity(): int
    {
        return $this->size_quantity;
    }

    /**
     * @param int $size_quantity
     * @return Size
     */
    public function setSizeQuantity(int $size_quantity): Size
    {
        $this->size_quantity = $size_quantity;
        return $this;
    }

    /**
     * @return string
     */
    public function getSizeReference(): string
    {
        return $this->size_reference;
    }

    /**
     * @param string $size_reference
     * @return Size
     */
    public function setSizeReference(string $size_reference): Size
    {
        $this->size_reference = $size_reference;
        return $this;
    }

    /**
     * @return string
     */
    public function getEan(): string
    {
        return $this->ean;
    }

    /**
     * @param string $ean
     * @return Size
     */
    public function setEan(?string $ean): Size
    {
        $this->ean = $ean;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toXML(DOMDocument $document)
    {
        $size = $document->createElement('size');

        foreach (array_filter(get_object_vars($this)) as $property => $value) {
            $size->appendChild($document->createElement($property, $value));
        }

        return $size;
    }
}
