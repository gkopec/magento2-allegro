<?php
/**
 *
 */
namespace Macopedia\Allegro\Api\Data\AllegroProduct;
/**
 *
 */
interface ParameterInterface
{
    /**
     * @param string $value
     * @return void
     */
    public function setValue(string $value): void;

    /**
     * @return string
     */
    public function getValue(): string;

    /**
     * @param string $label
     * @return void
     */
    public function setLabel(string $label): void;

    /**
     * @return string
     */
    public function getLabel(): string;
}