# Spartoo API

Implementation of the [Spartoo](https://spartoo.com) API.  
This API allows you to :
- Import products
- Quickly update stock
- Quickly update stock in batch
- Export online catalog
- Check product status
- Export orders
- Update orders
- Export delivery slips
- Export returns
- Update returns

## Installation

It is recommended to use [composer](https://getcomposer.org/) to install the package :

```
$ composer require debuss-a/spartoo 
```

**PHP 7.2 or newer is required.**

## Usage

First of all you need your Merchant ID for webservices to use the API.  
It is available on [your seller account](https://www.spartoo.fr/mp/informations.php), then you can instantiate the app :

```php
require_once __DIR__.'/vendor/autoload.php';

$app = new Spartoo\App('EF40F969744AF620');
```

_Every method of Spartoo\App return an instance of `SimpleXMLElement` containing the response from Spartoo._

### Create products

```php
require_once __DIR__.'/vendor/autoload.php';

use Spartoo\App;
use Spartoo\Factory;

$app = new App('EF40F969744AF620');

$products = [
    Factory::getProduct('98', 'ALL STAR HI', 'Converse', 64.99)
        ->setProductSex('M')
        ->setProductQuantity(5)
        ->setColorId(8)
        ->setProductStyle(10059)
        ->setProductDescription(
            'Mythique parmi les mythiques, la Chuck Taylor All Star de Converse est une incontournable. Ici en version montante avec une tige en toile et un imprimé uni classique, elle se la joue intemporelle et indémodable !'
        )
        ->setProductColor('Rouge')
        ->setSizeList([
            Factory::getSize('38', 4, '98_38', '123456789011'),
            Factory::getSize('39', 1, '98_39', '123456789012')
        ])
        ->setProductComposition(1)
        ->setPhotos([
            'https://imgext.spartoo.com/photos/98/98/98_350_A.jpg',
            'https://imgext.spartoo.com/photos/98/98/98_350_B.jpg',
            'https://imgext.spartoo.com/photos/98/98/98_350_C.jpg',
            'https://imgext.spartoo.com/photos/98/98/98_350_D.jpg',
            'https://imgext.spartoo.com/photos/98/98/98_350_E.jpg',
            'https://imgext.spartoo.com/photos/98/98/98_350_F.jpg',
            'https://imgext.spartoo.com/photos/98/98/98_350_G.jpg',
            'https://imgext.spartoo.com/photos/98/98/98_350_H.jpg'
        ])
        ->setDiscount(Factory::getDiscount(
            time(),
            time() + 60 * 60 * 24 * 31,
            null,
            20,
            false
        )),
    // Other products ...
];

$app->importProducts($products);
```

### Create multi country products

```php
require_once __DIR__.'/vendor/autoload.php';

use Spartoo\App;
use Spartoo\Factory;

$app = new App('EF40F969744AF620');

$products = [
    Factory::getProductMultiCountry([
            Factory::getLanguage(
                'FR',
                'ALL STAR HI',
                'Mythique parmi les mythiques, la Chuck Taylor All Star de Converse est une incontournable. Ici en version montante avec une tige en toile et un imprimé uni classique, elle se la joue intemporelle et indémodable !',
                'Rouge',
                64.99
            ),
            Factory::getLanguage(
                'ES',
                'ALL STAR HI',
                'Mítico entre los míticos, el Chuck Taylor All Star of Converse es un must have. Aquí, en una versión ascendente con un tallo de lienzo y una impresión lisa clásica, ¡es intemporal y atemporal!',
                'Rojo',
                64.99
            ),
        ], 'Converse')
        ->setReferencePartenaire('98')
        ->setProductSex('M')
        ->setProductQuantity(5)
        ->setColorId(8)
        ->setProductStyle(10059)
        ->setSizeList([
            Factory::getSize('38', 4, '98_38', '123456789011'),
            Factory::getSize('39', 1, '98_39', '123456789012')
        ])
        ->setProductComposition(1)
        ->setPhotos([
            'https://imgext.spartoo.com/photos/98/98/98_350_A.jpg',
            'https://imgext.spartoo.com/photos/98/98/98_350_B.jpg',
            'https://imgext.spartoo.com/photos/98/98/98_350_C.jpg',
            'https://imgext.spartoo.com/photos/98/98/98_350_D.jpg',
            'https://imgext.spartoo.com/photos/98/98/98_350_E.jpg',
            'https://imgext.spartoo.com/photos/98/98/98_350_F.jpg',
            'https://imgext.spartoo.com/photos/98/98/98_350_G.jpg',
            'https://imgext.spartoo.com/photos/98/98/98_350_H.jpg'
        ]),
    // Other multi country products ...
];

$app->importProducts($products);
``` 

### Quickly update a product

```php
$partner_reference = 'demo_01';
$product_size_reference = 'demo_01_01';
$quantity = 42;

$app->majStock($partner_reference, $product_size_reference, $quantity);
```

### Quickly update products in batch

```php
$products = [
    Factory::getProduct('98', 'ALL STAR HI', 'Converse', 64.99)
            ->setSizeList([
                Factory::getSize('38', 4, '98_38'),
                Factory::getSize('39', 1, '98_39')
            ]),
    Factory::getProduct('99', 'Continental', 'Adidas', 90.99)
            ->setSizeList([
                Factory::getSize('40', 12, '99_40'),
                Factory::getSize('41', 3, '99_41')
            ]),
    // Other products ...
];

$app->majStockBatch($products);
```

### Export products in catalog

```php
$products = $app->exportProducts();
```

### Check products status

```php
$products = [
    Factory::getProduct('98', 'ALL STAR HI', 'Converse', 64.99)
            ->setSizeList([
                Factory::getSize('38', 4, '98_38'),
                Factory::getSize('39', 1, '98_39')
            ]),
    Factory::getProduct('99', 'Continental', 'Adidas', 90.99)
            ->setSizeList([
                Factory::getSize('40', 12, '99_40'),
                Factory::getSize('41', 3, '99_41')
            ]),
    // Other products ...
];

$results = $app->checkStatusProducts($products);
```

### Export orders list

```php
$orders = $app->exportOrders(new DateTime('2020-03-01'));
```

### Export delivery slip

```php
$product = Factory::getProduct('98', 'ALL STAR HI', 'Converse', 64.99)
    ->setProductQuantity(1);

$delivery_slip = $app->exportBL('my_order_id', $product);
```

### Export returns

```php
$returns = $app->exportReturns(new DateTime('2020-03-01'));
```

### Update a return

```php
$app->majReturns('return_id', 3, 'https://example.com/my/return/label.pdf');
```

### Provisionning

You can get provisionning data from the `Provionning` class, default language is french but you can set an other one or switch to another one.

```php
require_once __DIR__ . '/vendor/autoload.php';

use Spartoo\Provisionning;

var_dump(
    Provisionning::getInstance()->getLanguages(),
    Provisionning::getInstance()->getProductsSex(),
    Provisionning::getInstance()->getColors(),
    Provisionning::getInstance()->switchLanguage('IT')->getColors(),
    Provisionning::getInstance()->switchLanguage('ES')->getColors(),
    Provisionning::getInstance()->switchLanguage('FR')->getCompositions(),
    Provisionning::getInstance()->getCategories(),
    Provisionning::getInstance()->getSelections(),
    Provisionning::getInstance()->getExtraInfos(),
    Provisionning::getInstance()->getOrdersStatus(),
    Provisionning::getInstance()->getReturnsStatus(),
    Provisionning::getInstance()->getSizes(),
    Provisionning::getInstance()->getCurrencies(),
    Provisionning::getInstance()->getInvoiceTypes(),
    Provisionning::getInstance()->getProductStyles()
);
``` 

## License

The package is licensed under the MIT license. See [License File](https://github.com/debuss/spartoo/blob/master/LICENSE.md) for more information.
