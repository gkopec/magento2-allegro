<?php
/**
 *
 */

namespace Macopedia\Allegro\Model\Data\AllegroProduct;

use Macopedia\Allegro\Api\Data\AllegroProduct\ParameterInterface;
use Magento\Framework\DataObject;
/**
 *
 */
class Parameter extends DataObject implements ParameterInterface
{
    const VALUE = 'value';
    const LABEL = 'label';

    /**
     * @param string $value
     * @return void
     */
    public function setValue(string $value): void
    {
        $this->setData(self::VALUE, $value);
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->getData(self::VALUE) ?? '';
    }
    /**
     * @param string $label
     * @return void
     */
    public function setLabel(string $label): void
    {
        $this->setData(self::LABEL, $label);
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->getData(self::LABEL) ?? '';
    }
}
