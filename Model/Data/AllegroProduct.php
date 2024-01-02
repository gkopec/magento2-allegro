<?php

namespace Macopedia\Allegro\Model\Data;

use Macopedia\Allegro\Api\Data\AllegroProduct\ParameterInterfaceFactory;
use Magento\Framework\DataObject;
use Macopedia\Allegro\Api\Data\AllegroProductInterface;

/**
 *
 */
class AllegroProduct extends DataObject implements AllegroProductInterface
{
    public function __construct(
        private ParameterInterfaceFactory $parameterFactory,
        array $data = []
    )
    {

        parent::__construct($data);
    }

    /**
     *
     */
    const ID = 'id';
    /**
     *
     */
    const NAME = 'name';
    /**
     *
     */
    const IMAGE = 'image';
    /**
     *
     */
    const PARAMETERS = 'parameters';

    /**
     * @param array $data
     * @return void
     */
    public function setRawData($data): void
    {
        if (isset($data['id'])) {
            $this->setData(self::ID, $data['id']);
        }
        if (isset($data['name'])) {
            $this->setName($data['name']);
        }
        if (isset($data['images'])) {
            $image = $data['images'][0];
            $this->setData(self::IMAGE, $image['url']);
        }
        if (isset($data['parameters'])) {
            $parameters = $this->getParametersFromRaw($data['parameters']);
            $this->setParameters($parameters);
        }

    }

    /**
     * @param array $parametersData
     * @return ParameterInterface[]
     */
    private function getParametersFromRaw($parametersData): array
    {
        $parameters = [];

        foreach ($parametersData as $parameterData) {
            /** @var ParameterInterface $parameter */
            $parameter = $this->parameterFactory->create([
                'data' => [
                    'label' => $parameterData['name'],
                    'value' => join(', ', $parameterData['valuesLabels'])
                ]
            ]);
            $parameters[] = $parameter;
        }

        return $parameters;
    }

    /**
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->setData(self::NAME, $name);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->getData(self::NAME) ?? '';
    }

    /**
     * @param string $id
     * @return void
     */
    public function setId(string $id): void
    {
        $this->setData(self::ID, $id);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->getData(self::ID) ?? '';
    }

    /**
     * @param string $image
     * @return void
     */
    public function setImage(string $image): void
    {
        $this->setData(self::IMAGE, $image);
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->getData(self::IMAGE) ?? '';
    }

    /**
     * @param \Macopedia\Allegro\Api\Data\AllegroProduct\ParameterInterface[] $parameters
     * @return void
     */
    public function setParameters(array $parameters): void
    {
        $this->setData(self::PARAMETERS, $parameters);
    }

    /**
     * @return \Macopedia\Allegro\Api\Data\AllegroProduct\ParameterInterface[]
     */
    public function getParameters(): array
    {
        return $this->getData(self::PARAMETERS) ?? [];
    }
}