<?php
require_once("includes/paypalConfig.php");
require_once("billingPlan.php");

$id = $plan->getId();

use PayPal\Api\Agreement;
use PayPal\Api\Payer;
use PayPal\Api\Plan;



$agreement = new Agreement();
$agreement->setName('Subscription to Hamsflix')
    ->setDescription('USD 9.99 setup fee and then recurring payments of 9.99 to Hamsflix')
    ->setStartDate(gmdate("Y-m-d\TH:i:s\Z", strtotime("+1 month")));
// Add Plan ID
// Please note that the plan Id should be only set in this case.
$plan = new Plan();
$plan->setId($id);
$agreement->setPlan($plan);

// Add Payer
$payer = new Payer();
$payer->setPaymentMethod('paypal');
$agreement->setPayer($payer);

// ### Create Agreement
try {

    $agreement = $agreement->create($apiContext);

    $approvalUrl = $agreement->getApprovalLink();
    echo $agreement->getState();
    header("Location: $approvalUrl");
} catch (PayPal\Exception\PayPalConnectionException $ex) {
    echo $ex->getCode();
    echo $ex->getData();
    die($ex);

}catch(Exception $ex){
    die($ex);
}



?>