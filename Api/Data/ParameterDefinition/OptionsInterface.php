<?php

namespace Macopedia\Allegro\Api\Data\ParameterDefinition;

interface OptionsInterface
{
    const VARIANTS_ALLOWED = 'variantsAllowed';
    const VARIANTS_EQUAL = 'variantsEqual';
    const AMBIGUOUS_VALUE_ID = 'ambiguousValueId';
    const DEPENDS_ON_PARAMETER_ID = 'dependsOnParameterId';
    const DESCRIBES_PRODUCT = 'describesProduct';
    const CUSTOM_VALUES_ENABLED = 'customValuesEnabled';

    /**
     * @param bool $value
     * @return self
     */
    public function setVariantsAllowed(bool $value): self;

    /**
     * @param bool $value
     * @return self
     */
    public function setVariantsEqual(bool $value): self;

    /**
     * @param string|null $valueId
     * @return self
     */
    public function setAmbiguousValueId(?string $valueId): self;

    /**
     * @param string|null $valueId
     * @return self
     */
    public function setDependsOnParameterId(?string $valueId): self;

    /**
     * @param bool $value
     * @return self
     */
    public function setDescribesProduct(bool $value): self;

    /**
     * @param bool $value
     * @return self
     */
    public function setCustomValuesEnabled(bool $value): self;

    /**
     * @return bool
     */
    public function getVariantsAllowed(): bool;

    /**
     * @return bool
     */
    public function getVariantsEqual(): bool;

    /**
     * @return string|null
     */
    public function getAmbiguousValueId(): string|null;

    /**
     * @return string|null
     */
    public function getDependsOnParameterId(): string|null;

    /**
     * @return bool
     */
    public function getDescribesProduct(): bool;

    /**
     * @return bool
     */
    public function getCustomValuesEnabled(): bool;
}