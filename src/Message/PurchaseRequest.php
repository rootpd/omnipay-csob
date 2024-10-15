<?php

namespace Omnipay\Csob\Message;

use Omnipay\Csob\Core\Message\AbstractRequest;
use OndraKoupil\Csob\Payment;

class PurchaseRequest extends AbstractRequest
{
    public function getTestMode()
    {
        return $this->getParameter('testMode');
    }

    public function setTestMode($value)
    {
        return $this->setParameter('testMode', $value);
    }

    public function getRedirectUrl()
    {
        return $this->getParameter('redirectUrl');
    }

    public function setRedirectUrl($value)
    {
        return $this->setParameter('redirectUrl', $value);
    }

    public function getCart()
    {
        return $this->getParameter('cart');
    }

    public function setCart($value)
    {
        return $this->setParameter('cart', $value);
    }

    public function getOneClickPayment()
    {
        return $this->getParameter('oneClickPayment');
    }

    public function setOneClickPayment($value)
    {
        return $this->setParameter('oneClickPayment', $value);
    }

    public function setCurrency($value)
    {
        return $this->setParameter('currency', $value);
    }

    public function setLanguage($value)
    {
        return $this->setParameter('language', $value);
    }

    public function setReturnMethod($value)
    {
        return $this->setParameter('returnMethod', $value);
    }

    public function getData()
    {
        $this->validate('returnUrl', 'transactionId', 'cart');
        return parent::getData();
    }

    public function sendData($data)
    {
        $payment = new Payment($this->getParameter("transactionId"));
        foreach ($this->getCart() as $item) {
            $payment->addCartItem($item['name'], $item['quantity'], intval(round($item['price'] * 100)));
        }
        $payment->setOneClickPayment($this->getOneClickPayment());
        $payment->currency = $this->getParameter('currency');
        $payment->language = $this->getParameter('language');
        $payment->returnMethod = $this->getParameter('returnMethod');

        $client = $this->getClient();
        $data = $client->paymentInit($payment);
        $this->setRedirectUrl($client->getPaymentProcessUrl($payment));

        return $this->response = new PurchaseResponse($this, $data);
    }
}
