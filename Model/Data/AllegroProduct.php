<?php

namespace Macopedia\Allegro\Model\Data;

use Composer\Util\Url;
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
    const PARAMETERS_JSON = 'parameters_json';
    const CATEGORY = 'category';

    /**
     * @param array $data
     * @return void
     */
    public function setRawData($data): void
    {
        if (isset($data['id'])) {
            $this->setId($data['id']);
        }
        if (isset($data['name'])) {
            $this->setName($data['name']);
        }
        if (isset($data['category'])) {
            $this->setCategory($data['category']['id']);
        }
        if (isset($data['images'])) {
            $image = $data['images'][0];
            $this->setImage($image['url']);
        }
        if (isset($data['parameters'])) {
            $parameters = $this->getParametersFromRaw($data['parameters']);
            $this->setParameters($parameters);
            $this->setParametersJson($this->getParametersForJson($data['parameters']));
        }
    }

    private function getParametersForJson($parametersData)
    {
        $parameters = [];

        foreach ($parametersData as $parameterData) {
            $parameters[$parameterData['id']] = $parameterData['valuesIds'] ?? $parameterData['values'];
        }

        return json_encode($parameters);
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

    /**
     * @param string $category
     * @return void
     */
    public function setCategory(string $category): void
    {
        $this->setData(self::CATEGORY, $category);
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->getData(self::CATEGORY) ?? '';
    }

    /**
     * @param string $parametersJson
     * @return void
     */
    public function setParametersJson(string $parametersJson): void
    {
        $this->setData(self::PARAMETERS_JSON, $parametersJson);
    }

    /**
     * @return string
     */
    public function getParametersJson(): string
    {
        return $this->getData(self::PARAMETERS_JSON) ?? '';
    }
}