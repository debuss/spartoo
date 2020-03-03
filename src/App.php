<?php
/**
 * Spartoo API
 *
 * @author debuss-a <zizilex@gmail.com>
 * @copyright 2020 debuss-a
 * @license https://github.com/debuss/spartoo/blob/master/LICENSE.md MIT License
 */

namespace Spartoo;

use DateTime;
use DOMDocument;
use Exception;
use SimpleXMLElement;
use Spartoo\Exception\APIException;
use Spartoo\Exception\InvalidArgumentException;
use Spartoo\Interfaces\XMLTransformerInterface;
use Spartoo\Object\Product;

/**
 * Class App
 *
 * @package Spartoo
 */
class App
{

    /** @var string */
    protected $partner;

    /**
     * App constructor.
     * @param string $partner
     */
    public function __construct(string $partner)
    {
        $this->partner = $partner;
    }

    /**
     * @return DOMDocument
     */
    protected function getDocument()
    {
        $document = new DOMDocument();
        $document->preserveWhiteSpace = true;
        $document->formatOutput = true;
        $document->encoding = 'UTF-8';
        $document->version = '1.0';

        return $document;
    }

    /**
     * @param XMLTransformerInterface[] $products
     * @param bool $force_description
     * @param bool $force_overwrite
     * @return SimpleXMLElement
     * @throws Exception
     */
    public function importProducts(array $products, ?bool $force_description = null, ?bool $force_overwrite = null)
    {
        $document = $this->getDocument();

        $root = $document->appendChild($document->createElement('root'));
        $products_list = $root->appendChild($document->createElement('products'));

        foreach ($products as $product) {
            $products_list->appendChild($product->toXML($document));
        }

        return $this->post(
            'https://sws.spartoo.com/mp/xml_import_products.php',
            array_filter([
                'partenaire' => $this->partner,
                'xml' => $document->saveXML(),
                'force_description' => (int)$force_description,
                'force_overwrite' => (int)$force_overwrite
            ])
        );
    }

    /**
     * @param string $reference_partenaire
     * @param string $products_size_reference
     * @param int $products_quantity
     * @return SimpleXMLElement
     * @throws Exception
     */
    public function majStock(string $reference_partenaire, string $products_size_reference, int $products_quantity)
    {
        return $this->post(
            'https://sws.spartoo.com/mp/xml_maj_stock.php',
            [
                'partenaire' => $this->partner,
                'reference_partenaire' => $reference_partenaire,
                'products_size_reference' => $products_size_reference,
                'products_quantity' => $products_quantity
            ]
        );
    }

    /**
     * @param Product[] $products
     * @return SimpleXMLElement
     * @throws Exception
     */
    public function majStockBatch(array $products)
    {
        $document = $this->getDocument();

        $catalogue = $document->appendChild($document->createElement('catalogue'));

        foreach ($products as $product) {
            $record = $catalogue->appendChild($document->createElement('product'));
            $record->appendChild($document->createElement('reference_partenaire', $product->getReferencePartenaire()));

            if (!count($product->getSizeList())) {
                $record->appendChild($document->createElement('product_quantity', $product->getProductQuantity()));
            }

            $size_list = $document->createElement('size_list');
            foreach ($product->getSizeList() as $size) {
                $size->setSizeName(null);
                $size->setEan(null);

                $size_list->appendChild($size->toXML($document));
            }
            $record->appendChild($size_list);
        }

        return $this->post(
            'https://sws.spartoo.com/mp/xml_maj_stock_batch.php',
            array_filter([
                'partenaire' => $this->partner,
                'xml' => $document->saveXML()
            ])
        );
    }

    /**
     * @param string|null $reference_partenaire
     * @return SimpleXMLElement
     * @throws Exception
     */
    public function exportProducts(?string $reference_partenaire = null)
    {
        return $this->post(
            'https://sws.spartoo.com/mp/xml_export_products.php',
            array_filter([
                'partenaire' => $this->partner,
                'reference_partenaire' => $reference_partenaire
            ])
        );
    }

    /**
     * @param Product[] $products
     * @return SimpleXMLElement
     * @throws Exception
     */
    public function checkStatusProducts(array $products)
    {
        $document = $this->getDocument();

        $root = $document->appendChild($document->createElement('root'));
        $list = $root->appendChild($document->createElement('products'));

        foreach ($products as $product) {
            if (!count($product->getSizeList())) {
                $record = $root->appendChild($document->createElement('product'));
                $record->appendChild($document->createElement('reference_partenaire', $product->getReferencePartenaire()));

                $list->appendChild($record);
            } else {
                foreach ($product->getSizeList() as $size) {
                    $size->setSizeName(null);
                    $size->setEan(null);

                    $record = $root->appendChild($document->createElement('product'));
                    $record->appendChild($document->createElement('reference_partenaire', $product->getReferencePartenaire()));
                    $record->appendChild($document->createElement('products_size_reference', $size->getSizeReference()));

                    $list->appendChild($record);
                }
            }
        }

        return $this->post(
            'https://sws.spartoo.com/mp/xml_check_status_products.php',
            array_filter([
                'partenaire' => $this->partner,
                'xml' => $document->saveXML()
            ])
        );
    }

    /**
     * @param DateTime|null $date
     * @param string|null $oID
     * @param int|null $status
     * @return SimpleXMLElement
     * @throws Exception
     */
    public function exportOrders(?DateTime $date = null, ?string $oID = null, ?int $status = null)
    {
        if (!$date && !$oID) {
            throw InvalidArgumentException::missingArgument(['date (DateTime)', 'oID (string)']);
        }

        return $this->post(
            'https://sws.spartoo.com/mp/xml_export_orders.php',
            array_filter([
                'partenaire' => $this->partner,
                'date' => $date ? $date->format('Y-m-d:H:i:s') : null,
                'oID' => $oID,
                'statut' => $status
            ])
        );
    }

    /**
     * @param string $oID
     * @param int $status
     * @param string|null $tracking_number
     * @return SimpleXMLElement
     * @throws Exception
     */
    public function majOrders(string $oID, int $status, ?string $tracking_number = null)
    {
        return $this->post(
            'https://sws.spartoo.com/mp/xml_maj_orders.php',
            array_filter([
                'partenaire' => $this->partner,
                'oID' => $oID,
                'statut' => $status,
                'tracking_number' => $tracking_number
            ])
        );
    }

    /**
     * @param string $order_id
     * @param Product $product
     * @return SimpleXMLElement
     * @throws Exception
     */
    public function exportBL(string $order_id, Product $product)
    {
        $document = $this->getDocument();

        $root = $document->appendChild($document->createElement('root'));
        $root->appendChild($document->createElement('order_id', $order_id));

        $products = $root->appendChild($document->createElement('products'));

        $record = $products->appendChild($document->createElement('product'));
        $record->appendChild($document->createElement('reference_partenaire', $product->getReferencePartenaire()));
        $record->appendChild($document->createElement('product_quantity', $product->getProductQuantity()));

        return $this->post(
            'http://sws.spartoo.com/mp/xml_export_bl.php',
            [
                'partenaire' => $this->partner,
                'xml' => $document->saveXML()
            ]
        );
    }

    /**
     * @param DateTime|null $date
     * @param string|null $oID
     * @param string|null $rID
     * @param int|null $status
     * @return SimpleXMLElement
     * @throws Exception
     */
    public function exportReturns(?DateTime $date = null, ?string $oID = null, ?string $rID = null, ?int $status = null)
    {
        if (!$date && !$oID && !$rID) {
            throw InvalidArgumentException::missingArgument(['oID (string)', 'rID (string)']);
        }

        return $this->post(
            'https://sws.spartoo.com/mp/xml_export_returns.php',
            array_filter([
                'partenaire' => $this->partner,
                'date' => $date ? $date->format('U') : null,
                'oID' => $oID,
                'rID' => $rID,
                'statut' => $status
            ])
        );
    }

    /**
     * @param string $rID
     * @param int|null $status
     * @param string|null $label_link
     * @param null $label_file
     * @return SimpleXMLElement
     * @throws Exception
     */
    public function majReturns(string $rID, ?int $status = null, ?string $label_link = null, $label_file = null)
    {
        return $this->post(
            'https://sws.spartoo.com/mp/xml_maj_returns.php',
            array_filter([
                'partenaire' => $this->partner,
                'rID' => $rID,
                'statut' => $status,
                'label_link' => $label_link,
                'label_file' => $label_file
            ])
        );
    }

    /**
     * @param string $url
     * @param array $params
     * @return SimpleXMLElement
     * @throws Exception
     */
    protected function post($url, $params)
    {
        $curl = curl_init($url);

        curl_setopt(
            $curl,
            CURLOPT_USERAGENT,
            'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1'
        );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);

        $result = curl_exec($curl);

        curl_close($curl);

        $xml = simplexml_load_string($result);
        if (!$xml instanceof SimpleXMLElement) {
            throw APIException::noXMLResponse($url);
        }

        return $xml;
    }
}
