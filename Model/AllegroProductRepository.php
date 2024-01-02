<?php

namespace Macopedia\Allegro\Model;

use Macopedia\Allegro\Api\AllegroProductRepositoryInterface;
use Macopedia\Allegro\Api\Data\AllegroProductInterface;
use Macopedia\Allegro\Model\Data\AllegroProductFactory;
use Macopedia\Allegro\Model\Api\ClientException;
use Macopedia\Allegro\Model\Data\Offer;
use Macopedia\Allegro\Model\ResourceModel\Sale\Product;

class AllegroProductRepository implements AllegroProductRepositoryInterface
{

    /**
     * @param Product $resourceProduct
     * @param AllegroProductFactory $allegroProductFactory
     */
    public function __construct(
        private Product $resourceProduct,
        private AllegroProductFactory $allegroProductFactory
    ){}

    const GTIN_MODE = 'GTIN';

    /**
     * @param $gtin string
     * @return AllegroProductInterface[]
     * @throws ClientException
     */
    public function searchByGtin(string $gtin)
    {
        $params = [
            'phrase' => $gtin,
            'language' => Offer::DEFAULT_LANGUAGE,
            'mode' => self::GTIN_MODE
        ];

        $data = $this->resourceProduct->search($params);

        $result = [];
        foreach ($data as $productData) {
            /** @var AllegroProductInterface $product */
            $product = $this->allegroProductFactory->create();
            $product->setRawData($productData);
            $result[] = $product;
        }

        return $result;
    }
}