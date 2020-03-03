<?php
/**
 * Spartoo API
 *
 * @author debuss-a <zizilex@gmail.com>
 * @copyright 2020 debuss-a
 * @license https://github.com/debuss/spartoo/blob/master/LICENSE.md MIT License
 */

namespace Spartoo\Exception;

use Exception;

/**
 * Class InvalidArgumentException
 *
 * @package Spartoo\Exception
 */
class InvalidArgumentException extends Exception
{

    /**
     * @param string $node_name
     * @param string $data_type
     * @return static
     */
    public static function inconsistentRecordDataType(string $node_name, string $data_type)
    {
        return new static(sprintf(
            'Each element of %s must be of type %s.',
            $node_name,
            $data_type
        ));
    }

    /**
     * @param string[] $parameters
     * @return static
     */
    public static function missingArgument(array $parameters)
    {
        return new static(sprintf(
            'At least one of this parameters must be provided: %s.',
            implode(', ', $parameters)
        ));
    }

    /**
     * @param string $iso
     * @return static
     */
    public static function notSupportedCountryCode(string $iso)
    {
        return new static(sprintf(
            'The country %s is not supported by Spartoo.',
            $iso
        ));
    }

    /**
     * @param string $sex
     * @return static
     */
    public static function notSupportedProductSex(string $sex)
    {
        return new static(sprintf(
            'The product_sex %s is not supported by Spartoo.',
            $sex
        ));
    }

    /**
     * @param int $color_id
     * @return static
     */
    public static function notSupportedColorId(int $color_id)
    {
        return new static(sprintf(
            'The color_id %s is not supported by Spartoo.',
            $color_id
        ));
    }

    /**
     * @param int $product_style
     * @return static
     */
    public static function notSupportedProductStyle(int $product_style)
    {
        return new static(sprintf(
            'The product_style %s is not supported by Spartoo.',
            $product_style
        ));
    }

    /**
     * @param int $product_composition
     * @return static
     */
    public static function notSupportedComposition(int $product_composition)
    {
        return new static(sprintf(
            'The product_composition %s is not supported by Spartoo.',
            $product_composition
        ));
    }

    /**
     * @param int $selection
     * @return static
     */
    public static function notSupportedSelection(int $selection)
    {
        return new static(sprintf(
            'The selection %s is not supported by Spartoo.',
            $selection
        ));
    }

    /**
     * @param string $size
     * @return static
     */
    public static function notSupportedSize(string $size)
    {
        return new static(sprintf(
            'The size %s is not supported by Spartoo.',
            $size
        ));
    }
}
