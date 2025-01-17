<?php


namespace Macopedia\Allegro\Model\Data;

use Macopedia\Allegro\Api\Data\ParameterInterface;
use Magento\Framework\DataObject;

abstract class Parameter extends DataObject implements ParameterInterface
{

    const ID_FIELD_NAME = 'id';
    const DESCRIBES_PRODUCT = 'describes_product';

    /**
     * @param int $id
     * @return void
     */
    public function setId(int $id)
    {
        $this->setData(self::ID_FIELD_NAME, $id);
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->getData(self::ID_FIELD_NAME);
    }

    /**
     * @param array $rawData
     */
    public function setRawData(array $rawData)
    {
        if (isset($rawData['id'])) {
            $this->setId($rawData['id']);
        }
    }

    /**
     * @param string[] $values
     * @return string[]
     */
    protected function stripEmptyValues(array $values): array
    {
        $result = [];
        foreach ($values as $value) {
            if ($value === null || $value === '') {
                continue;
            }
            $result[] = $value;
        }
        return $result;
    }


    /**
     * @param bool $value
     * @return void
     */
    public function setDescribesProduct(bool $value): void
    {
        $this->setData(self::DESCRIBES_PRODUCT, $value);
    }

    /**
     * @return bool
     */
    public function getDescribesProduct(): bool
    {
        return $this->getData(self::DESCRIBES_PRODUCT);
    }

}
