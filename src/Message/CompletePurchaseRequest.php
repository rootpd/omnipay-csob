<?php

namespace Omnipay\Csob\Message;

use Omnipay\Csob\Core\Message\AbstractRequest;

class CompletePurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        $client = $this->getClient();
        $response = $client->receiveReturningCustomer();

        return [
            'payId' => $response['payId'],
            'status' => $response["paymentStatus"],
        ];
    }

    public function sendData($data)
    {
        return $this->response = new CompletePurchaseResponse($this, $data);
    }
}
