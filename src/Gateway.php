<?php

namespace Omnipay\Csob;

use Omnipay\Common\AbstractGateway;

class Gateway extends AbstractGateway
{
    const STATUS_INITIATED = 1;
    const STATUS_IN_PROGRESS = 2;
    const STATUS_CANCELLED = 3;
    const STATUS_CONFIRMED = 4;
    const STATUS_REVERSED = 5;
    const STATUS_DENIED = 6;
    const STATUS_WAITING_FOR_SETTLEMENT = 7;
    const STATUS_SETTLED = 8;
    const STATUS_REFUND_PROCESSING = 9;
    const STATUS_RETURNED = 10;

    const ONECLICK_PAYMENT_CHECKBOX_HIDDEN_UNCHECKED = 0;
    const ONECLICK_PAYMENT_CHECKBOX_DISPLAYED_UNCHECKED = 1;
    const ONECLICK_PAYMENT_CHECKBOX_DISPLAYED_CHECKED = 2;
    const ONECLICK_PAYMENT_CHECKBOX_HIDDEN_CHECKED = 3;

    public function getName()
    {
        return 'CSOB CZ';
    }

    public function getDefaultParameters()
    {
        return [
            'closePayment' => false,
            'oneClickPayment' => false,
        ];
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest(\Omnipay\Csob\Message\PurchaseRequest::class, $parameters);
    }

    public function checkout(array $parameters = array())
    {
        return $this->createRequest(\Omnipay\Csob\Message\CheckoutRequest::class, $parameters);
    }

    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest(\Omnipay\Csob\Message\CompletePurchaseRequest::class, $parameters);
    }

    public function oneClickPayment(array $parameters = array())
    {
        return $this->createRequest(\Omnipay\Csob\Message\OneClickPaymentRequest::class, $parameters);
    }

    public function paymentStatus(array $parameters = array())
    {
        return $this->createRequest(\Omnipay\Csob\Message\PaymentStatusRequest::class, $parameters);
    }

    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    public function setShopName($value)
    {
        return $this->setParameter('shopName', $value);
    }

    public function setBankPublicKeyFilePath($value)
    {
        return $this->setParameter('bankPublicKeyFilePath', $value);
    }

    public function setPrivateKeyFilePath($value)
    {
        return $this->setParameter('privateKeyFilePath', $value);
    }

    public function setClosePayment($value)
    {
        return $this->setParameter('closePayment', $value);
    }

    public function setOneClickPayment($value)
    {
        return $this->setParameter('oneClickPayment', $value);
    }

    public function setOneClickPaymentCheckbox($value)
    {
        return $this->setParameter('oneClickPaymentCheckbox', $value);
    }

    public function setDisplayOmnibox($value)
    {
        return $this->setParameter('displayOmnibox', $value);
    }

    public function setReturnCheckoutUrl($value)
    {
        return $this->setParameter('returnCheckoutUrl', $value);
    }

    public function setCurrency($value)
    {
        return $this->setParameter('currency', $value);
    }

    public function setLanguage($value)
    {
        return $this->setParameter('language', $value);
    }

    public function setTraceLog($value)
    {
        return $this->setParameter('traceLog', $value);
    }
}
