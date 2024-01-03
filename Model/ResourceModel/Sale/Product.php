<?php

namespace Macopedia\Allegro\Model\ResourceModel\Sale;

use Macopedia\Allegro\Model\ResourceModel\AbstractResource;

class Product extends AbstractResource
{
    public function search(array $params)
    {
        $query = http_build_query($params);
        $response = $this->requestGet('/sale/products?'. $query);

        return $response['products'] ?? [];
    }

    public function get(string $id)
    {
        $response = $this->requestGet('/sale/products/'. $id);

        return $response['products'] ?? [];
    }
}