<?php

namespace Omnipay\CSOB;

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
    
    public function getName()
    {
        return 'CSOB CZ';
    }

    public function getDefaultParameters()
    {
        return [
            'merchantId' => '',
            'merchantName' => '',
            'bankPublicKeyFilePath' => '',
            'privateKeyFilePath' => '',

            'closePayment' => false,
            'oneClickPayment' => false,
        ];
    }

    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    public function getMerchantName()
    {
        return $this->getParameter('merchantName');
    }

    public function setMerchantName($value)
    {
        return $this->setParameter('merchantName', $value);
    }

    public function getBankPublicKeyFilePath()
    {
        return $this->getParameter('bankPublicKeyFilePath');
    }

    public function setBankPublicKeyFilePath($value)
    {
        return $this->setParameter('bankPublicKeyFilePath', $value);
    }

    public function getPrivateKeyFilePath()
    {
        return $this->getParameter('privateKeyFilePath');
    }

    public function setPrivateKeyFilePath($value)
    {
        return $this->setParameter('privateKeyFilePath', $value);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest(\Omnipay\Csob\Message\PurchaseRequest::class, $parameters);
    }

    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest(\Omnipay\Csob\Message\CompletePurchaseRequest::class, $parameters);
    }

    public function oneClickPayment(array $parameters = array())
    {
        return $this->createRequest(\Omnipay\Csob\Message\OneClickPaymentRequest::class, $parameters);
    }

    public function getClosePayment()
    {
        return $this->getParameter('closePayment');
    }

    public function setClosePayment($value)
    {
        return $this->setParameter('closePayment', $value);
    }

    public function getOneClickPayment()
    {
        return $this->getParameter('oneClickPayment');
    }

    public function setOneClickPayment($value)
    {
        return $this->setParameter('oneClickPayment', $value);
    }
}
