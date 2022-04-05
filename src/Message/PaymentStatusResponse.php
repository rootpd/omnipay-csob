<?php

namespace Omnipay\Csob\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\CSOB\Gateway;

class PaymentStatusResponse extends AbstractResponse
{
    public function isSuccessful(): bool
    {
        return $this->getStatus() == Gateway::STATUS_CONFIRMED // if closePayment was false
            || $this->getStatus() == Gateway::STATUS_WAITING_FOR_SETTLEMENT // if closePayment was true
            || $this->getStatus() == Gateway::STATUS_SETTLED // if closePayment was true
            ;
    }

    public function isCancelled(): bool
    {
        return $this->getStatus() == Gateway::STATUS_CANCELLED;
    }

    public function getStatus(): ?string
    {
        if (isset($this->data['status'])) {
            return $this->data['status'];
        }
        return null;
    }

    public function getExpiration(): ?string
    {
        if (isset($this->data['expiration'])) {
            return $this->data['expiration'];
        }
        return null;
    }
}
