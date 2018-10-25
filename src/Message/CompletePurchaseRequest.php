<?php

namespace Omnipay\Csob\Message;

use Omnipay\Csob\Core\Message\AbstractRequest;
use OndraKoupil\Csob\Exception;
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
            $response = $client->paymentStatus($payment, false);
        }

        return [
            'payId' => $response['payId'],
            'status' => $response["paymentStatus"],
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
