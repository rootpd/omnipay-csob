<?php

namespace Omnipay\Csob\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\CSOB\Gateway;

class OneClickPaymentResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        return $this->getStatus() === Gateway::STATUS_CONFIRMED // if closePayment was false
            || $this->getStatus() === Gateway::STATUS_WAITING_FOR_SETTLEMENT // if closePayment was true
        ;
    }

    public function getStatus()
    {
        if (isset($this->data['paymentStatus'])) {
            return $this->data['paymentStatus'];
        }
        return null;
    }
}
