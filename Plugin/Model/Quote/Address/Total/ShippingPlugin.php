<?php

namespace Macopedia\Allegro\Plugin\Model\Quote\Address\Total;

use Macopedia\Allegro\Model\Api\ClientException;
use Macopedia\Allegro\Model\Api\ClientResponseException;
use Magento\Quote\Model\Quote\Address\Total\Shipping;
use Magento\Quote\Model\Quote;
use Magento\Quote\Api\Data\ShippingAssignmentInterface;
use Magento\Quote\Model\Quote\Address\Total;
use Macopedia\Allegro\Api\DeliveryMethodRepositoryInterface;

class ShippingPlugin
{
    public function __construct(
        private DeliveryMethodRepositoryInterface $deliveryMethodRepository
    )
    {}
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
        if($methodName = $this->getMethodName($quote->getExtShippingInfo())) {
            $address->setShippingDescription($methodName);
            $total->setShippingDescription($methodName);
        }

        return $result;
    }

    private function getMethodName($id)
    {
        try {
            $deliveryMethod = $this->deliveryMethodRepository->getById($id);

            return $deliveryMethod->getName();
        }
        catch (\Exception $exception) {
            return false;
        }
    }
}