<?php

namespace Macopedia\Allegro\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Macopedia\Allegro\Api\Data\OfferInterface;

class Publication implements OptionSourceInterface
{
    public function toOptionArray()
    {
        return [
            [
                'label' => __('Offer'),
                'value' => OfferInterface::PUBLICATION_STATUS_ACTIVE
            ],
            [
                'label' => __('Draft'),
                'value'  => OfferInterface::PUBLICATION_STATUS_INACTIVE
            ]
        ];
    }
}