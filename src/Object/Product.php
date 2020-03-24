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
use Spartoo\Exception\XMLFileException;
use Spartoo\Interfaces\XMLTransformerInterface;
use Spartoo\Provisionning;

/**
 * Class Product
 *
 * @package Spartoo
 */
class Product implements XMLTransformerInterface
{

    /** @var string */
    protected $reference_partenaire;

    /** @var string */
    protected $product_name;

    /** @var string */
    protected $manufacturers_name;

    /** @var string */
    protected $product_sex;

    /** @var float */
    protected $product_price;

    /** @var int */
    protected $product_quantity;

    /** @var int */
    protected $color_id;

    /** @var int */
    protected $product_style;

    /** @var string */
    protected $product_description;

    /** @var string */
    protected $product_color;

    /** @var float */
    protected $heel_height;

    /** @var Size[] */
    protected $size_list;

    /** @var int */
    protected $product_composition;

    /** @var int */
    protected $voering_composition;

    /** @var int */
    protected $first_composition;

    /** @var int */
    protected $zool_composition;

    /** @var array */
    protected $photos;

    /** @var Discount */
    protected $discount;

    /** @var Info[] */
    protected $extra_infos;

    /** @var array */
    protected $selections;

    /**
     * @return string
     */
    public function getReferencePartenaire(): string
    {
        return $this->reference_partenaire;
    }

    /**
     * @param string $reference_partenaire
     * @return Product
     */
    public function setReferencePartenaire(string $reference_partenaire): Product
    {
        $this->reference_partenaire = $reference_partenaire;
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
     * @return Product
     */
    public function setProductName(string $product_name): Product
    {
        $this->product_name = $product_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getManufacturersName(): string
    {
        return $this->manufacturers_name;
    }

    /**
     * @param string $manufacturers_name
     * @return Product
     */
    public function setManufacturersName(string $manufacturers_name): Product
    {
        $this->manufacturers_name = $manufacturers_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getProductSex(): string
    {
        return $this->product_sex;
    }

    /**
     * @param string $product_sex
     * @return Product
     * @throws XMLFileException
     */
    public function setProductSex(string $product_sex): Product
    {
        if (!in_array($product_sex, array_column(Provisionning::getInstance()->getProductsSex(), 'code'))) {
            InvalidArgumentException::notSupportedProductSex($product_sex);
        }

        $this->product_sex = $product_sex;
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
     * @return Product
     */
    public function setProductPrice(float $product_price): Product
    {
        $this->product_price = $product_price;
        return $this;
    }

    /**
     * @return int
     */
    public function getProductQuantity(): int
    {
        return $this->product_quantity;
    }

    /**
     * @param int $product_quantity
     * @return Product
     */
    public function setProductQuantity(int $product_quantity): Product
    {
        $this->product_quantity = $product_quantity;
        return $this;
    }

    /**
     * @return int
     */
    public function getColorId(): int
    {
        return $this->color_id;
    }

    /**
     * @param int $color_id
     * @return Product
     * @throws XMLFileException
     */
    public function setColorId(int $color_id): Product
    {
        if (!in_array($color_id, array_column(Provisionning::getInstance()->getColors(), 'code'))) {
            InvalidArgumentException::notSupportedColorId($color_id);
        }

        $this->color_id = $color_id;
        return $this;
    }

    /**
     * @return int
     */
    public function getProductStyle(): int
    {
        return $this->product_style;
    }

    /**
     * @param int $product_style
     * @return Product
     * @throws InvalidArgumentException
     * @throws XMLFileException
     */
    public function setProductStyle(int $product_style): Product
    {
        static $categories;
        if (!is_array($categories) || !count($categories)) {
            $categories = array_column(
                Provisionning::getInstance()->getCategories(),
                'code'
            );
        }

        if (!in_array($product_style, $categories)) {
            throw InvalidArgumentException::notSupportedProductStyle($product_style);
        }

        $this->product_style = $product_style;
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
     * @return Product
     */
    public function setProductDescription(string $product_description): Product
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
     * @return Product
     */
    public function setProductColor(string $product_color): Product
    {
        $this->product_color = $product_color;
        return $this;
    }

    /**
     * @return float
     */
    public function getHeelHeight(): float
    {
        return $this->heel_height;
    }

    /**
     * @param float $heel_height
     * @return Product
     */
    public function setHeelHeight(float $heel_height): Product
    {
        $this->heel_height = $heel_height;
        return $this;
    }

    /**
     * @return Size[]
     */
    public function getSizeList(): array
    {
        return $this->size_list ?: [];
    }

    /**
     * @param Size[] $size_list
     * @return Product
     * @throws InvalidArgumentException
     */
    public function setSizeList(array $size_list): Product
    {
        foreach ($size_list as $item) {
            if (!$item instanceof Size) {
                throw InvalidArgumentException::inconsistentRecordDataType('size_list', Size::class);
            }
        }

        $this->size_list = $size_list;
        return $this;
    }

    /**
     * @return int
     */
    public function getProductComposition(): int
    {
        return $this->product_composition;
    }

    /**
     * @param int $product_composition
     * @return Product
     * @throws InvalidArgumentException
     * @throws XMLFileException
     */
    public function setProductComposition(int $product_composition): Product
    {
        if (!in_array($product_composition, array_column(Provisionning::getInstance()->getCompositions(), 'code'))) {
            throw InvalidArgumentException::notSupportedComposition($product_composition);
        }

        $this->product_composition = $product_composition;
        return $this;
    }

    /**
     * @return int
     */
    public function getVoeringComposition(): int
    {
        return $this->voering_composition;
    }

    /**
     * @param int $voering_composition
     * @return Product
     * @throws InvalidArgumentException
     * @throws XMLFileException
     */
    public function setVoeringComposition(int $voering_composition): Product
    {
        if (!in_array($voering_composition, array_column(Provisionning::getInstance()->getCompositions(), 'code'))) {
            throw InvalidArgumentException::notSupportedComposition($voering_composition);
        }

        $this->voering_composition = $voering_composition;
        return $this;
    }

    /**
     * @return int
     */
    public function getFirstComposition(): int
    {
        return $this->first_composition;
    }

    /**
     * @param int $first_composition
     * @return Product
     * @throws InvalidArgumentException
     * @throws XMLFileException
     */
    public function setFirstComposition(int $first_composition): Product
    {
        if (!in_array($first_composition, array_column(Provisionning::getInstance()->getCompositions(), 'code'))) {
            throw InvalidArgumentException::notSupportedComposition($first_composition);
        }

        $this->first_composition = $first_composition;
        return $this;
    }

    /**
     * @return int
     */
    public function getZoolComposition(): int
    {
        return $this->zool_composition;
    }

    /**
     * @param int $zool_composition
     * @return Product
     * @throws InvalidArgumentException
     * @throws XMLFileException
     */
    public function setZoolComposition(int $zool_composition): Product
    {
        if (!in_array($zool_composition, array_column(Provisionning::getInstance()->getCompositions(), 'code'))) {
            throw InvalidArgumentException::notSupportedComposition($zool_composition);
        }

        $this->zool_composition = $zool_composition;
        return $this;
    }

    /**
     * @return array
     */
    public function getPhotos(): array
    {
        return $this->photos;
    }

    /**
     * @param array $photos
     * @return Product
     */
    public function setPhotos(array $photos): Product
    {
        $this->photos = $photos;
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
     * @return Product
     */
    public function setDiscount(Discount $discount): Product
    {
        $this->discount = $discount;
        return $this;
    }

    /**
     * @return Info[]
     */
    public function getExtraInfos(): array
    {
        return $this->extra_infos;
    }

    /**
     * @param Info[] $extra_infos
     * @return Product
     * @throws InvalidArgumentException
     */
    public function setExtraInfos(array $extra_infos): Product
    {
        foreach ($extra_infos as $item) {
            if (!$item instanceof Info) {
                throw InvalidArgumentException::inconsistentRecordDataType('extra_infos', Info::class);
            }
        }

        $this->extra_infos = $extra_infos;
        return $this;
    }

    /**
     * @return array
     */
    public function getSelections(): array
    {
        return $this->selections;
    }

    /**
     * @param array $selections
     * @return Product
     * @throws InvalidArgumentException
     * @throws XMLFileException
     */
    public function setSelections(array $selections): Product
    {
        foreach ($selections as $selection) {
            if (!in_array($selection, array_column(Provisionning::getInstance()->getSelections(), 'code'))) {
                throw InvalidArgumentException::notSupportedSelection($selection);
            }
        }

        $this->selections = $selections;
        return $this;
    }

    /**
     * @param DOMDocument $document
     * @return DOMElement
     */
    public function toXML(DOMDocument $document)
    {
        $product = $document->createElement('product');

        foreach (array_filter(get_object_vars($this)) as $property => $value) {
            $element = null;

            switch ($property) {
                case 'size_list':
                case 'extra_infos':
                case 'languages':
                    $element = $document->createElement($property);

                    foreach ($this->{$property} as $object) {
                        /** @var XMLTransformerInterface $object */
                        $element->appendChild($object->toXML($document));
                    }
                    break;

                case 'discount':
                    $element = $this->getDiscount()->toXML($document);
                    break;

                case 'photos':
                case 'selections':
                    $element = $document->createElement($property);

                    foreach (array_values($value) as $key => $photo) {
                        $key += 1;
                        if ($key >= 9) {
                            break;
                        }

                        $name = 'url'.$key;
                        if ($property == 'selections') {
                            $name = 'selection';
                        }

                        $element->appendChild($document->createElement($name, $photo));
                    }
                    break;

                case 'product_name':
                case 'manufacturers_name':
                case 'product_description':
                case 'product_color':
                    $element = $document->createElement($property, '');
                    $element->appendChild($document->createCDATASection($value));
                    break;

                default:
                    $element = $document->createElement($property, $value);
                    break;
            }

            $product->appendChild($element);
        }

        return $product;
    }
}
