<?php

include('App.php');

class Paypal {

    var $apiUrl = "https://svcs.sandbox.paypal.com/AdaptivePayments/";
    var $paypalUrl = "https://sandbox.paypal.com/webscr?cmd=_ap-payment&paykey=";

    function __construct() {
        $this->headers = array(
            "X-PAYPAL-SECURITY-USERID: " . API_USERNAME,
            "X-PAYPAL-SECURITY-PASSWORD: " . API_PASSWORD,
            "X-PAYPAL-SECURITY-SIGNATURE: " . API_SIGNATURE,
            "X-PAYPAL-REQUEST-DATA-FORMAT: JSON",
            "X-PAYPAL-RESPONSE-DATA-FORMAT: JSON",
            "X-PAYPAL-APPLICATION-ID: " . APPLICATION_ID
        );
    }

    function getPaymentOptions($payKey) {
        $packet = array(
            "requestEnvelope" => array(
                "errorLanguage" => "en_US",
                "detailLevel" => "ReturnAll"
            ),
            "payKey" => $payKey
        );

        return $this->_paypalSend($packet, "GetPaymentOptions");
    }

    function _paypalSend($data, $call) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl . $call);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

        return json_decode(curl_exec($ch), TRUE);
    }

    function splitPay() {
        $createPacket = array(
            "actionType" => "PAY",
            "currencyCode" => "USD",
            "receiverList" => array(
                "receiver" => array(
                    array(
                        "amount" => "1.00",
                        "email" => ADMIN_PAYPAL_ID
                    ),
                    array(
                        "amount" => "2.00",
                        "email" => PAYPAL_ID
                    )
                )
            ),
            "returnUrl" => "http://local.dev/store",
            "cancelUrl" => "http://local.dev/store",
            "requestEnvelope" => array(
                "errorLanguage" => "en_US",
                "detailLevel" => "ReturnAll"
            )
        );
        $response = $this->_paypalSend($createPacket, "Pay");
        $paykey = $response['payKey'];
        $detailsPacket = array(
            "requestEnvelope" => array(
                "errorLanguage" => "en_US",
                "detailLevel" => "ReturnAll"
            ),
            "payKey" => $paykey,
            "receiverOptions" => array(
                array(
                    "receiver" => array("email" => ADMIN_PAYPAL_ID),
                    "invoiceData" => array(
                        "item" => array(
                            array(
                                "name" => "product1",
                                "price" => "1.00",
                                "identifier" => "p1"
                            )
                        )
                    )
                ),
                array(
                    "receiver" => array("email" => PAYPAL_ID),
                    "invoiceData" => array(
                        "item" => array(
                            array(
                                "name" => "product1",
                                "price" => "2.00",
                                "identifier" => "p1"
                            )
                        )
                    )
                )
            )
        );

        $response = $this->_paypalSend($detailsPacket, "SetPaymentOptions");
        $dets = $this->getPaymentOptions($paykey);
        header("Location: " . $this->paypalUrl . $paykey);
    }

}

?>