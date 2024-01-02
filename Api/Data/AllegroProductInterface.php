<?php

namespace Macopedia\Allegro\Api\Data;


interface AllegroProductInterface
{
    /**
     * @param array $data
     * @return void
     */
    public function setRawData($data): void;

    /**
     * @param string $name
     * @return void
     */
    public function setName(string $name): void;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $id
     * @return void
     */
    public function setId(string $id): void;

    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @param string $image
     * @return void
     */
    public function setImage(string $image): void;

    /**
     * @return string
     */
    public function getImage(): string;

    /**
     * @param \Macopedia\Allegro\Api\Data\AllegroProduct\ParameterInterface[] $parameters
     * @return void
     */
    public function setParameters(array $parameters): void;

    /**
     * @return \Macopedia\Allegro\Api\Data\AllegroProduct\ParameterInterface[]
     */
    public function getParameters(): array;
}