<?php

namespace Omnipay\Csob;

use OndraKoupil\Csob\Payment;

class Client extends \OndraKoupil\Csob\Client
{
    function getPaymentCheckoutUrl(Payment $payment, int $oneClickPaymentCheckbox, ?bool $displayOmnibox, ?string $returnCheckoutUrl) {
        $payId = $this->getPayId($payment);

        $payload = [
            "merchantId" => $this->config->merchantId,
            "payId" => $payId,
            "dttm" => $this->getDTTM(),
            "oneclickPaymentCheckbox" => $oneClickPaymentCheckbox,
        ];

        if ($displayOmnibox !== null) {
            $payload["displayOmnibox"] = $displayOmnibox ? "true" : "false";
        }
        if ($returnCheckoutUrl !== null) {
            $payload["returnCheckoutUrl"] = $returnCheckoutUrl;
        }

        $payload["signature"] = $this->signRequest($payload);

        $url = $this->sendRequest(
            "payment/checkout",
            $payload,
            "GET",
            array(),
            array("merchantId", "payId", "dttm", "oneclickPaymentCheckbox", "displayOmnibox", "returnCheckoutUrl", "signature"),
            true
        );

        $this->writeToLog("URL for processing payment ".$payId.": $url");

        return $url;
    }
}