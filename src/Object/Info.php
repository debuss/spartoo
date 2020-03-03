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
 * Class Info
 *
 * @package Spartoo
 */
class Info implements XMLTransformerInterface
{

    /** @var int */
    protected $id;

    /** @var float */
    protected $value;

    /**
     * Info constructor.
     * @param int $id
     * @param float $value
     */
    public function __construct(int $id, float $value)
    {
        $this->id = $id;
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Info
     */
    public function setId(int $id): Info
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @param float $value
     * @return Info
     */
    public function setValue(float $value): Info
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toXML(DOMDocument $document)
    {
        $info = $document->createElement('info');

        foreach (array_filter(get_object_vars($this)) as $property => $value) {
            $info->appendChild($document->createElement($property, $value));
        }

        return $info;
    }
}
