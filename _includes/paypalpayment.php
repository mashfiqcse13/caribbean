<?php

require_once 'AdaptivePayments.php';

class Paypalpayment {

    public function doPaymant() {
        //session_start();
        try {


            /* The servername and serverport tells PayPal where the buyer
              should be directed back to after authorizing payment.
              In this case, its the local webserver that is running this script
              Using the servername and serverport, the return URL is the first
              portion of the URL that buyers will return to after authorizing payment */

            $serverName = $_SERVER['SERVER_NAME'];
            $serverPort = $_SERVER['SERVER_PORT'];
            $url = dirname('http://' . $serverName . ':' . $serverPort . $_SERVER['REQUEST_URI']);


            /* The returnURL is the location where buyers return when a
              payment has been succesfully authorized.
              The cancelURL is the location buyers are sent to when they hit the
              cancel button during authorization of payment during the PayPal flow */

            $returnURL = SITE_URL . "paypalpayment/PaymentDetails";
            $cancelURL = "$url/SetPayChained.php";
            $currencyCode = $_REQUEST['currencyCode'];
            $memo = $_REQUEST["memo"];
            $feesPayer = $_REQUEST["feesPayer"];
            $email = $_REQUEST["email"];
            $requested = '';
            $receiverEmail = '';
            $amount = '';
            $primary = '';
            $count = count($_POST['receiveremail']);

            /* Make the call to PayPal to get the Pay token
              If the API call succeded, then redirect the buyer to PayPal
              to begin to authorize payment.  If an error occured, show the
              resulting errors
             */
            $payRequest = new PayRequest();
            $payRequest->actionType = "PAY";
            $payRequest->cancelUrl = $cancelURL;
            $payRequest->returnUrl = $returnURL;
            $payRequest->clientDetails = new ClientDetailsType();
            $payRequest->clientDetails->applicationId = APPLICATION_ID;
            $payRequest->clientDetails->deviceId = DEVICE_ID;
            $payRequest->clientDetails->ipAddress = "127.0.0.1";
            $payRequest->currencyCode = $currencyCode;
            //$payRequest->senderEmail = $email;
            $payRequest->requestEnvelope = new RequestEnvelope();
            $payRequest->requestEnvelope->errorLanguage = "en_US";

            $receiver1 = new receiver();
            $receiver1->email = $_POST['receiveremail'][0];
            $receiver1->amount = $_REQUEST['amount'][0];
            $receiver1->primary = $_REQUEST['primary'][0];

            $receiver2 = new receiver();
            $receiver2->email = $_POST['receiveremail'][1];
            $receiver2->amount = $_REQUEST['amount'][1];
            $receiver2->primary = $_REQUEST['primary'][1];

            $payRequest->receiverList = array($receiver1, $receiver2);

            $payRequest->feesPayer = $feesPayer;
            $payRequest->memo = $memo;


            /* Make the call to PayPal to get the Pay token
              If the API call succeded, then redirect the buyer to PayPal
              to begin to authorize payment.  If an error occured, show the
              resulting errors
             */
            $ap = new AdaptivePayments();
            $response = $ap->Pay($payRequest);

            if (strtoupper($ap->isSuccess) == 'FAILURE') {

                $_SESSION['FAULTMSG'] = $ap->getLastError();
                $location = SITE_URL . "paypalpayment/APIError";
                header("Location: $location");
            } else {

                $_SESSION['payKey'] = $response->payKey;


                if ($response->paymentExecStatus == "COMPLETED") {

                    $location = SITE_URL . "paypalpayment/PaymentDetails";
                    header("Location: $location");
                } else {
                    $token = $response->payKey;
                    $payPalURL = PAYPAL_REDIRECT_URL . '_ap-payment&paykey=' . $token;
                    header("Location: " . $payPalURL);
                }
            }
        } catch (Exception $ex) {

            $fault = new FaultMessage();
            $errorData = new ErrorData();
            $errorData->errorId = $ex->getFile();
            $errorData->message = $ex->getMessage();
            $fault->error = $errorData;
            $_SESSION['FAULTMSG'] = $fault;
            $location = SITE_URL . "paypalpayment/APIError";
            header("Location: $location");
        }
    }

    public function paychanid() {
        //session_start();


        $merchant_id = $this->session->userdata("event_merchant_id");

        $total_price = $this->session->userdata("total_price");

        $result["price"]["merchant_price"] = "";
        $result["price"]["bottlefalsh_price"] = "";
        $this->load->model("common_model");
        $result["merchant_details"] = $this->common_model->getdata($merchant_id);
        $result["merchant_data"]["company_email"] = $result["merchant_details"]["comp_email"];
        $result["price"]["bottlefalsh_price"] = ($total_price * $result["merchant_details"]["split_payment"]) / 100;

        $result["price"]["merchant_price"] = ($total_price * $result["merchant_details"]["split_payment"]) / 100;
        $result["price"]["total_price"] = $total_price;
        // $result["admin_paypal_id"]=$this->config->item("ADMIN_PAYPAL_ID");
        $result["admin_paypal_id"] = $this->common_model->view_details("", "site_setting", "paypal_id");
        $this->load->view("SetPayChained", $result);
    }

    public function PaymentDetails() {
        $order_status = 0;
        $this->load->library('AdaptivePayments');
        @session_start();
        if (isset($_GET['cs'])) {
            $_SESSION['payKey'] = '';
        }
        try {
            if (isset($_REQUEST["payKey"])) {
                $payKey = $_REQUEST["payKey"];
            }
            if (empty($payKey)) {
                $payKey = $_SESSION['payKey'];
            }

            $pdRequest = new PaymentDetailsRequest();
            $pdRequest->payKey = $payKey;
            $rEnvelope = new RequestEnvelope();
            $rEnvelope->errorLanguage = "en_US";
            $pdRequest->requestEnvelope = $rEnvelope;

            $ap = new AdaptivePayments();
            $response = $ap->PaymentDetails($pdRequest);

            /*
              Display the API response back to the browser.
              If the response from PayPal was a success, display the response parameters'
              If the response was an error, display the errors received using APIError.php.

             */



            if (strtoupper($ap->isSuccess) == 'FAILURE') {
                $_SESSION['FAULTMSG'] = $ap->getLastError();
                $location = SITE_URL . "paypalpayment/APIError";
                header("Location: $location");
            }
        } catch (Exception $ex) {

            $fault = new FaultMessage();
            $errorData = new ErrorData();
            $errorData->errorId = $ex->getFile();
            $errorData->message = $ex->getMessage();
            $fault->error = $errorData;
            $_SESSION['FAULTMSG'] = $fault;
            $location = "APIError.php";
            header("Location: $location");
        }
        $data["response"] = $response;
        $this->load->library('form_validation');
        $order_id = $this->session->userdata("order_id");

        $this->load->model('customer_model');

//$order_id = $this->customer_model->max_order_id();
        $order_data = array();
        $order_status = $this->customer_model->order_update($order_id);
        $order_data = $this->customer_model->order_details($order_id);
        if ($order_data->status == 1) {

            $transaction_id = $response->paymentInfoList->paymentInfo[0]->transactionId; //transaction id//
            $status = $response->status; // payment status//
            //echo $transaction_id." ".$status;
            $order_status = $this->customer_model->is_unic_order_id($order_id);
            $new_order_id = "";
            if ($order_status == 0) {
                $result["ticket_entry"] = $this->customer_model->create_ticket();
                $insert_data = $this->customer_model->insert_payment($order_id, $transaction_id, $status);


                $data = array(
                    "event_id" => "",
                    "event_merchant_id" => "",
                    "quantity" => "",
                    "total_price" => "",
                    "base_price" => "",
                    "options" => ""
                );
                $this->session->set_userdata($data);


                $new_order_id = $this->customer_model->view_ticket_details(" where transaction_id='" . $transaction_id . "' ", "payment", "order_id");


                $customer_content = $this->customer_model->getData();

                $this->load->library('form_validation');
                $ticket_id = $this->customer_model->view_ticket_details(" where order_id='" . $new_order_id . "' ", "ticket", "id");
                $result["ticket_entry"] = $ticket_id;
                $_SESSION["ticket_id"] = $ticket_id;
                $result["ticket_details"] = array();

                $result["ticket_details"] = $this->customer_model->ticket_details($ticket_id);

                $user_email_body = "<br/><b><span style='font-size:20px'>Congratulations on your purchase from BotteFlash!  Your payment has successfully been processed.</span></b>";

                $ticket_id = $this->customer_model->view_ticket_details(" where id='" . $new_order_id . "' ", "ticket", "id");

                $result["ticket_details"] = $this->customer_model->ticket_details($_SESSION["ticket_id"]);

                $merchant_name = $this->customer_model->view_ticket_details(" where id='" . $result["ticket_details"]["merchant_id"] . "' ", "merchant", "username");

                foreach ($result["ticket_details"]["options"] as $row) {
                    if (sizeof($result["ticket_details"]["options"]) > 0 and $row["name"] != "") {
                        $user_email_body .="<p><label style='width: 209px;display: inline-block;text-align: right' >" . $row["name"] . ": </label>";
                        $user_email_body .="<label>$" . number_format($row["amount"], 2) . "</label></p>";
                    }
                }
                $user_email_body .="<p><hr/></p>";


                // $this -> form_validation -> sendMail($customer_content["email"], "", "Bottleflash ticket # ".$result["ticket_details"]["ticket_no"], $user_email_body);
                //////////////  MERCHANT EMAIL //////////////////

                $split_amount = $this->customer_model->view_ticket_details(" where id='" . $result["ticket_details"]["merchant_id"] . "' ", "merchant", "split_payment");
                $merchant_amount = ($result["ticket_details"]["total_price"] * $split_amount) / 100;
                $bottleflash_amount = $result["ticket_details"]["total_price"] - $merchant_amount;


                $merchant_email_body = "<b><span style='font-size:20px'>Congratulations, your event has sold on BottleFlash!  Please see event details below:</span></b>";


                // $order_details=$this->customer_model->order_option_details($new_order_id);
                /* foreach($order_details as $row)
                  {
                  if($row["name"]=="base price")
                  {
                  $merchant_email_body .="<br/><br/><b> Base Ticket Price : </b>$".$row["amount"];
                  }
                  else {
                  $merchant_email_body .="<br/><br/><b> ".$row["name"]." : </b>$".$row["amount"];
                  }

                  }

                  $merchant_email_body .="<br/><br/><b>Total Amount : </b>$".$result["ticket_details"]["total_amount"]."<br/>";

                  $merchant_email=$this->customer_model->view_ticket_details(" where id='".$result["ticket_details"]["merchant_id"]."' ","merchant","company_email");

                  $this -> form_validation -> sendMail($merchant_email, "", "Bottleflash ticket sale", $merchant_email_body);

                  //////////////  ADMIN MAIL ////////////////

                  $admin_email_body="<b> A new payment for Botleflash event </b>";

                  $customer_name=$this->customer_model->view_ticket_details(" where id='".$result["ticket_details"]["customer_id"]."' ","customer","username");

                  $merchant_name=$this->customer_model->view_ticket_details(" where id='".$result["ticket_details"]["merchant_id"]."' ","merchant","username");

                  $this -> form_validation -> sendMail($this->config->item("ADMIN_EMAIL"), "", "Bottleflash ticket sale", $admin_email_body);

                  $this->session->set_userdata($result); */
            }
            $result["ticket_entry"] = $_SESSION["ticket_id"];
            $this->load->view('customer/payment_success', $result);
        } else {
            redirect('customer/payment_fail');
        }


        //redirect("customer/order_success");
        //$this->load->view('PaymentDetails',$data);
    }

    public function APIError() {
        $this->load->view('APIError');
        //redirect("customer/payment_fail");
    }

}
