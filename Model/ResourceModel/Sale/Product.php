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
}