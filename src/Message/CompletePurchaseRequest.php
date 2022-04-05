<?php

namespace Omnipay\Csob\Message;

use Omnipay\Csob\Core\Message\AbstractRequest;
use OndraKoupil\Csob\Extensions\CardNumberExtension;
use OndraKoupil\Csob\Payment;

class CompletePurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        $client = $this->getClient();

        // online confirmation
        $response = $client->receiveReturningCustomer();

        // offline confirmation
        if (!$response && $this->getParameter('payId')) {
            $payment = new Payment();
            $payment->setPayId($this->getParameter('payId'));
            $cardNumberExtension = new CardNumberExtension();
            $response = $client->paymentStatus($payment, false, [$cardNumberExtension]);
        }

        return [
            'payId' => $response['payId'],
            'status' => $response["paymentStatus"],
            'expiration' => isset($cardNumberExtension) ? $cardNumberExtension->getExpiration() : null,
        ];
    }

    public function sendData($data)
    {
        return $this->response = new CompletePurchaseResponse($this, $data);
    }

    public function setPayId($value)
    {
        return $this->setParameter('payId', $value);
    }
}
