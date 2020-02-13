<?php

namespace Omnipay\Csob\Message;

use Omnipay\Csob\Core\Message\AbstractRequest;
use OndraKoupil\Csob\Payment;

class OneClickPaymentRequest extends AbstractRequest
{
    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    public function getTestMode()
    {
        return $this->getParameter('testMode');
    }

    public function setTestMode($value)
    {
        return $this->setParameter('testMode', $value);
    }

    public function getPayId()
    {
        return $this->getParameter('payId');
    }

    public function setPayId($value)
    {
        return $this->setParameter('payId', $value);
    }

    public function getCart()
    {
        return $this->getParameter('cart');
    }

    public function setCart($value)
    {
        return $this->setParameter('cart', $value);
    }

    public function getData()
    {
        $this->validate('transactionId', 'payId');
        return [];
    }

    public function sendData($data)
    {
        $payment = new Payment($this->getParameter("transactionId"));
        foreach ($this->getCart() as $item) {
            $payment->addCartItem($item['name'], $item['quantity'], intval(round($item['price'] * 100)));
        }

        $client = $this->getClient();
        $client->paymentOneClickInit($this->getPayId(), $payment, [], $this->getClientIp());
        $client->paymentOneClickStart($payment);

        $repeatedRun = false;
        do {
            $data = $client->paymentStatus($payment, false);
            if ($repeatedRun) {
                sleep(2);
            }
            $repeatedRun = true;
        } while ($data['paymentStatus'] == 2);

        return $this->response = new OneClickPaymentResponse($this, $data);
    }
}
