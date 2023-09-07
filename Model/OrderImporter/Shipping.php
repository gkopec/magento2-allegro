<?php

namespace Macopedia\Allegro\Model\OrderImporter;

use Macopedia\Allegro\Api\Data\CheckoutFormInterface;
use Macopedia\Allegro\Logger\Logger;
use Macopedia\Allegro\Model\Api\ClientException;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Shipping\Model\Config;
use Macopedia\Allegro\Model\DeliveryMethodRepository;

/**
 * Shipping model class
 */
class Shipping
{
    const DELIVERY_MAPPING_CONFIG_KEY = 'allegro/delivery/mapping';
    const DEFAULT_SHIPPING_METHOD_CONFIG_KEY = 'allegro/delivery/default_method';
    const DEFAULT_SHIPPING_METHOD = 'flatrate_flatrate';

    /** @var ScopeConfigInterface */
    private $scopeConfig;

    /** @var Logger */
    private $logger;

    /** @var Config */
    private $shippingConfig;

    /** @var array */
    private $shippingCodes = [];

    /**
     * @var DeliveryMethodRepository
     */
    private $deliveryMethodRepository;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param Logger $logger
     * @param Config $shippingConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        Logger $logger,
        Config $shippingConfig,
        DeliveryMethodRepository $deliveryMethodRepository
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->logger = $logger;
        $this->shippingConfig = $shippingConfig;
        $this->deliveryMethodRepository = $deliveryMethodRepository;
    }

    /**
     * @param CheckoutFormInterface $checkoutForm
     * @return string
     */
    public function getShippingMethodCode(CheckoutFormInterface $checkoutForm)
    {
        $methodName = $checkoutForm->getDelivery()->getMethod()->getId();

        if ($methodName == '') {
            return $this->getDefaultMethodCode();
        }

        if (!isset($this->shippingCodes[$methodName])) {
            $this->shippingCodes[$methodName] = $this->getMethodCode($methodName);
        }

        return $this->shippingCodes[$methodName];
    }

    /**
     * @param string $methodId
     * @return string
     */
    private function getMethodCode($methodId)
    {
        $deliveryMapping = $this->scopeConfig->getValue(self::DELIVERY_MAPPING_CONFIG_KEY);
        if (!$deliveryMapping) {
            return $this->getDefaultMethodCode();
        }
        $deliveryMapping = json_decode($deliveryMapping, true);
        $deliveryMapping = array_column($deliveryMapping, 'magento_code', 'allegro_code');

        if (!isset($deliveryMapping[$methodId])) {
            return $this->getDefaultMethodCode();
        }

        $methodCode = $deliveryMapping[$methodId];
        if (!$this->validateShippingMethod($methodCode)) {
            return $this->getDefaultMethodCode();
        }

        return $methodCode;
    }

    /**
     * @param string $code
     * @return bool
     */
    private function validateShippingMethod($code)
    {
        foreach ($this->shippingConfig->getActiveCarriers() as $carrierCode => $carrier) {
            foreach ($carrier->getAllowedMethods() as $methodCode => $methodTitle) {
                if ($carrierCode . '_' . $methodCode === $code) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @return string
     */
    private function getDefaultMethodCode()
    {
        $defaultMethodCode = $this->scopeConfig->getValue(self::DEFAULT_SHIPPING_METHOD_CONFIG_KEY);
        return $this->validateShippingMethod($defaultMethodCode) ? $defaultMethodCode : self::DEFAULT_SHIPPING_METHOD;
    }

    public function getShippingMethodName(CheckoutFormInterface $checkoutForm): string
    {
        $methodId = $checkoutForm->getDelivery()->getMethod()->getId();

        if ($methodId == '') {
            return '';
        }

        try{
            $deliveryMethod = $this->deliveryMethodRepository->getById($methodId);

            return $deliveryMethod->getName();
        } catch (ClientException $exception) {
            return '';
        }
    }
}
