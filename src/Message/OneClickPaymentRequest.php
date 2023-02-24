<?php

namespace Omnipay\Csob\Message;

use Omnipay\Csob\Core\Message\AbstractRequest;
use OndraKoupil\Csob\Metadata\Account;
use OndraKoupil\Csob\Metadata\Customer;
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

    public function getName()
    {
        return $this->getParameter('name');
    }

    public function setName($value)
    {
        return $this->setParameter('name', $value);
    }

    public function getEmail()
    {
        return $this->getParameter('email');
    }

    public function setEmail($value)
    {
        return $this->setParameter('email', $value);
    }

    public function getCreatedAt()
    {
        return $this->getParameter('createdAt');
    }

    public function setCreatedAt($value)
    {
        return $this->setParameter('createdAt', $value);
    }

    public function getChangedAt()
    {
        return $this->getParameter('changedAt');
    }

    public function setChangedAt($value)
    {
        return $this->setParameter('changedAt', $value);
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

        $customer = new Customer();
        $account = new Account();

        if ($name = $this->getName()) {
            $customer->name = $name;
        }
        if ($email = $this->getEmail()) {
            $customer->email = $email;
        }
        if ($createdAt = $this->getCreatedAt()) {
            $account->setCreatedAt($createdAt);
        }
        if ($changedAt = $this->getChangedAt()) {
            $account->setChangedAt($changedAt);
        }

        $customer->setAccount($account);
        $payment->setCustomer($customer);

        $client = $this->getClient();
        $client->paymentOneClickInit($this->getPayId(), $payment, [], $this->getClientIp());
        $client->paymentOneClickProcess($payment);

        $repeatedRun = false;
        do {
            $data = $client->paymentStatus($payment, false);
            if ($repeatedRun) {
                sleep(2);
            }
            $repeatedRun = true;
        } while ($data['paymentStatus'] == 2);

        if ($data['paymentStatus'] === 4 && $client->getConfig()->closePayment) {
            $client->paymentClose($payment);
        }

        return $this->response = new OneClickPaymentResponse($this, $data);
    }
}
