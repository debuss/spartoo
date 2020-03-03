<?php
/**
 * Spartoo API
 *
 * @author debuss-a <zizilex@gmail.com>
 * @copyright 2020 debuss-a
 * @license https://github.com/debuss/spartoo/blob/master/LICENSE.md MIT License
 */

namespace Spartoo;

use Generator;
use SimpleXMLElement;
use Spartoo\Exception\XMLFileException;

/**
 * Class Provisionning
 *
 * @package Spartoo
 */
class Provisionning
{

    /** @var SimpleXMLElement */
    protected $xml;

    /** @var self */
    protected static $instance;

    /**
     * Provisionning constructor.
     *
     * @param string $lang
     * @throws XMLFileException
     */
    private function __construct(string $lang)
    {
        $path = dirname(__FILE__).'/XML/'.$lang.'_xml_provisionning.zip';
        if (!file_exists($path)) {
            throw XMLFileException::wrongLanguage($lang);
        }

        $this->xml = simplexml_load_file('zip://'.$path.'#'.$lang.'_xml_provisionning.xml');
        if (!$this->xml) {
            throw XMLFileException::unableToReadProvisionningFile($path);
        }
    }

    /**
     * @param string $lang
     * @return Provisionning
     * @throws XMLFileException
     */
    public static function getInstance(string $lang = 'FR')
    {
        if (!self::$instance) {
            self::$instance = new self(strtolower($lang));
        }

        return self::$instance;
    }

    /**
     * @param string $lang
     * @return Provisionning
     * @throws XMLFileException
     */
    public function switchLanguage(string $lang)
    {
        self::$instance = new self(strtolower($lang));

        return self::$instance;
    }

    /**
     * @return SimpleXMLElement
     */
    public function getXML()
    {
        return $this->xml;
    }

    /**
     * @return array[]
     */
    public function getProductsSex()
    {
        $products_sex = [];

        foreach ($this->xml->products_sex->product_sex as $product_sex) {
            $products_sex[] = (array)$product_sex;
        }

        return $products_sex;
    }

    /**
     * @return array[]
     */
    public function getColors()
    {
        $colors = [];

        foreach ($this->xml->colors->color as $color) {
            $colors[] = [
                'code' => (string)$color->code,
                'name' => (string)$color->name,
            ];
        }

        return $colors;
    }

    /**
     * @return array[]
     */
    public function getCompositions()
    {
        $compositions = [];

        foreach ($this->xml->compositions->composition as $composition) {
            $compositions[] = (array)$composition;
        }

        return $compositions;
    }

    /**
     * @return array[]
     */
    public function getCategories()
    {
        $categories = [];

        foreach ($this->xml->categories->categorie as $category) {
            $categories[] = [
                'code' => (string)$category->code,
                'name' => (string)$category->name,
                'product_type' => (string)$category->product_type,
                'product_type_name' => (string)$category->product_type_name,
                'macro_category' => (string)$category->macro_category,
                'genders' => (array)$category->genders->gender
            ];
        }

        return $categories;
    }

    /**
     * @return array[]
     */
    public function getSelections()
    {
        $selections = [];

        foreach ($this->xml->selections->selection as $selection) {
            $selections[] = (array)$selection;
        }

        return $selections;
    }

    /**
     * @return array[]
     */
    public function getExtraInfos()
    {
        $infos = [];

        foreach ($this->xml->extra_info->info as $info) {
            $infos[] = (array)$info;
        }

        return $infos;
    }

    /**
     * @return array[]
     */
    public function getOrdersStatus()
    {
        $statuses = [];

        foreach ($this->xml->orders_status->status as $status) {
            $statuses[] = (array)$status;
        }

        return $statuses;
    }

    /**
     * @return array[]
     */
    public function getReturnsStatus()
    {
        $statuses = [];

        foreach ($this->xml->returns_status->status as $status) {
            $statuses[] = (array)$status;
        }

        return $statuses;
    }

    /**
     * @return array[]
     */
    public function getSizes()
    {
        $sizes = [];

        foreach ($this->xml->sizes->size as $size) {
            $sizes[] = array_filter([
                'size_name' => (string)$size->size_name,
                'products_type_id' => (string)$size->products_type_id,
                'products_type_name' => (string)$size->products_type_name,
                'restrictions' => $size->restrictions->count() ? (array)$size->restrictions->products_style : null
            ]);
        }

        return $sizes;
    }

    /**
     * @return Generator
     */
    public function getSizesGenerator()
    {
        foreach ($this->xml->sizes->size as $size) {
            yield $size;
        }
    }

    /**
     * @return string[]
     */
    public function getProductStyles()
    {
        $product_styles = [];

        foreach ($this->getSizesGenerator() as $size) {
            if (isset($size->restrictions) && $size->restrictions->count()) {
                foreach ($size->restrictions->products_style as $product_style) {
                    if (!in_array((string)$product_style, $product_styles)) {
                        $product_styles[] = (string)$product_style;
                    }
                }
            }
        }

        return $product_styles;
    }

    /**
     * @return string[]
     */
    public function getLanguages()
    {
        $languages = [];

        foreach ($this->xml->languages->language as $language) {
            $languages[] = (string)$language->code;
        }

        return $languages;
    }

    /**
     * @return string[]
     */
    public function getCurrencies()
    {
        $currencies = [];

        foreach ($this->xml->currencies->currency as $currency) {
            $currencies[] = [
                'name' => (string)$currency->name,
                'code' => (string)$currency->code
            ];
        }

        return $currencies;
    }

    /**
     * @return string[]
     */
    public function getInvoiceTypes()
    {
        $types = [];

        foreach ($this->xml->invoice_types->lib as $type) {
            $types[] = [
                'lib_id' => (string)$type->lib_id,
                'lib_name' => (string)$type->lib_name
            ];
        }

        return $types;
    }
}
