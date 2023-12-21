<?php

namespace Macopedia\Allegro\Model\Data\ParameterDefinition;

use Macopedia\Allegro\Api\Data\ParameterDefinition\OptionsInterface;
use Magento\Framework\DataObject;

class Options extends DataObject implements OptionsInterface
{

    public function setVariantsAllowed(bool $value): OptionsInterface
    {
        $this->setData(self::VARIANTS_ALLOWED, $value);
        
        return $this;
    }

    public function setVariantsEqual(bool $value): OptionsInterface
    {
        $this->setData(self::VARIANTS_EQUAL, $value);

        return $this;
    }

    public function setAmbiguousValueId(?string $valueId): OptionsInterface
    {
        $this->setData(self::AMBIGUOUS_VALUE_ID, $valueId);

        return $this;
    }

    public function setDependsOnParameterId(?string $valueId): OptionsInterface
    {
        $this->setData(self::DEPENDS_ON_PARAMETER_ID, $valueId);

        return $this;
    }

    public function setDescribesProduct(bool $value): OptionsInterface
    {
        $this->setData(self::DESCRIBES_PRODUCT, $value);

        return $this;
    }

    public function setCustomValuesEnabled(bool $value): OptionsInterface
    {
        $this->setData(self::CUSTOM_VALUES_ENABLED, $value);

        return $this;
    }

    public function getVariantsAllowed(): bool
    {
        return $this->getData(self::VARIANTS_ALLOWED);
    }

    public function getVariantsEqual(): bool
    {
        return $this->getData(self::VARIANTS_EQUAL);
    }

    public function getAmbiguousValueId(): string|null
    {
        return $this->getData(self::AMBIGUOUS_VALUE_ID);
    }

    public function getDependsOnParameterId(): string|null
    {
        return $this->getData(self::DEPENDS_ON_PARAMETER_ID);
    }

    public function getDescribesProduct(): bool
    {
        return $this->getData(self::DESCRIBES_PRODUCT);
    }

    public function getCustomValuesEnabled(): bool
    {
        return $this->getData(self::CUSTOM_VALUES_ENABLED);
    }

    public function setRawData(array $rawData)
    {
        if (isset($rawData['variantsAllowed'])) {
            $this->setVariantsAllowed($rawData['variantsAllowed']);
        }
        if (isset($rawData['variantsEqual'])) {
            $this->setVariantsEqual($rawData['variantsEqual']);
        }
        if (isset($rawData['ambiguousValueId'])) {
            $this->setAmbiguousValueId($rawData['ambiguousValueId']);
        }
        if (isset($rawData['dependsOnParameterId'])) {
            $this->setDependsOnParameterId($rawData['dependsOnParameterId']);
        }
        if (isset($rawData['describesProduct'])) {
            $this->setDescribesProduct($rawData['describesProduct']);
        }
        if (isset($rawData['customValuesEnabled'])) {
            $this->setCustomValuesEnabled($rawData['customValuesEnabled']);
        }
    }
}