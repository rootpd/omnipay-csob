<?php

namespace Omnipay\Csob\Message;

use Omnipay\Csob\Core\Message\AbstractRequest;
use OndraKoupil\Csob\Extensions\CardNumberExtension;
use OndraKoupil\Csob\Payment;

class PaymentStatusRequest extends AbstractRequest
{
    public function getData()
    {
        $client = $this->getClient();

        $payId = $this->getParameter('payId');
        $payment = new Payment();
        $payment->setPayId($payId);

        $cardNumberExtension = new CardNumberExtension();

        $response = $client->paymentStatus($payment, false, [$cardNumberExtension]);
        if (!$response) {
            return [];
        }

        return [
            'payId' => $response['payId'],
            'status' => $response["paymentStatus"],
            'expiration' => $cardNumberExtension->getExpiration(),
        ];
    }

    public function sendData($data)
    {
        return $this->response = new PaymentStatusResponse($this, $data);
    }

    public function setPayId($value)
    {
        return $this->setParameter('payId', $value);
    }
}
