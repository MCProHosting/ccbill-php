<?php

// Required File Includes. Because WHMCS says so.
include("../../../dbconnect.php");
include("../../../includes/functions.php");
include("../../../includes/gatewayfunctions.php");
include("../../../includes/invoicefunctions.php");

$name = 'ccbill';
$gateway = getGatewayVariables($name);
if (!$gateway['type']) {
    die('Module Not Activated');
}

// Extract and verify the invoice ID
$invoice = array_key_exists('invoiceId', $_POST) ? $_POST['invoiceId'] : '';
checkCbInvoiceID($invoiceid,$gateway["name"]);

$digest = md5($_POST['subscription_id'] . '1' . $gateway['salt']);

// If the hash verifies as successful, add the payment
if ($digest === $_POST['formDigest']) {
    addInvoicePayment(
        // Invoice ID
        $invoice,
        // Transaction ID, or close enough...
        $_POST['subscription_id'],
        // Amount the payment was for. This gateway is only for one-time
        // dynamic pricings, so the initialPrice is the total.
        $_POST['initialPrice'],
        // Calculate the transaction fee
        $_POST['initialPrice'] - $_POST['accountingAmount'],
        // Add the module name
        $name
    );

	logTransaction($name, $_POST, 'Successful');
}
// Otherwise log an error
else {
    logTransaction($name, $_POST, 'Unsuccessful');
}

?>
