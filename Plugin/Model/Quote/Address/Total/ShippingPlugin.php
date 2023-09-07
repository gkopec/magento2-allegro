<?php

namespace Macopedia\Allegro\Plugin\Model\Quote\Address\Total;

use Magento\Quote\Model\Quote\Address\Total\Shipping;
use Magento\Quote\Model\Quote;
use Magento\Quote\Api\Data\ShippingAssignmentInterface;
use Magento\Quote\Model\Quote\Address\Total;

class ShippingPlugin
{
    public function afterCollect(
        Shipping                    $subject,
        Shipping                    $result,
        Quote                       $quote,
        ShippingAssignmentInterface $shippingAssignment,
        Total                       $total
    )
    {
        if($quote->getOrderFrom() !== 'Allegro'){
            return $result;
        }

        $address = $shippingAssignment->getShipping()->getAddress();
        $address->setShippingDescription($quote->getExtShippingInfo());
        $total->setShippingDescription($quote->getExtShippingInfo());

        return $result;
    }
}