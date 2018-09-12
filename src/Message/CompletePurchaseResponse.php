<?php

namespace Omnipay\Csob\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\CSOB\Gateway;

class CompletePurchaseResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        return $this->getStatus() == Gateway::STATUS_CONFIRMED // if closePayment was false
            || $this->getStatus() == Gateway::STATUS_WAITING_FOR_SETTLEMENT // if closePayment was true
        ;
    }

    public function isCancelled()
    {
        return $this->getStatus() == Gateway::STATUS_CANCELLED;
    }

    public function getStatus()
    {
        if (isset($this->data['status'])) {
            return $this->data['status'];
        }
        return null;
    }
}
