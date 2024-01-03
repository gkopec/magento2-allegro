<?php

namespace Macopedia\Allegro\Api;

use Macopedia\Allegro\Api\Data\AllegroProductInterface;
use Macopedia\Allegro\Model\Api\ClientException;

interface AllegroProductRepositoryInterface
{
    /**
     * @param $gtin string
     * @return AllegroProductInterface[]
     * @throws ClientException
     */
    public function searchByGtin(string $gtin);

    /**
     * @param string $id
     * @return array|mixed
     */
    public function getById(string $id);
}