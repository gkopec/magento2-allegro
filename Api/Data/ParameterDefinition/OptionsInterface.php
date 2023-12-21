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

    public function setVariantsAllowed(bool $value): self;
    public function setVariantsEqual(bool $value): self;
    public function setAmbiguousValueId(?string $valueId): self;
    public function setDependsOnParameterId(?string $valueId): self;
    public function setDescribesProduct(bool $value): self;
    public function setCustomValuesEnabled(bool $value): self;

    public function getVariantsAllowed(): bool;
    public function getVariantsEqual(): bool;
    public function getAmbiguousValueId(): string|null;
    public function getDependsOnParameterId(): string|null;
    public function getDescribesProduct(): bool;
    public function getCustomValuesEnabled(): bool;
}