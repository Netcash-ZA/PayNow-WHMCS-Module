<?php

// Include the important WHMCS functions.
require("../../../init.php");
$whmcs->load_function("functions");
$whmcs->load_function("gateway");
$whmcs->load_function("invoice");

// Get the gateway data from WHMCS
$GATEWAY = getGatewayVariables("paynow");

// Check if the gateway is enabled, else exit.
if (!$GATEWAY['type']) {
        exit("Module Not Activated");
}

// Log the RAW data received from Sage Paynow
logModuleCall($GATEWAY['name'], 'Callback: Sage Paynow', '', print_r($_REQUEST, 1), '', '');

// Get the parameters
$TransactionAccepted = $whmcs->get_req_var("TransactionAccepted");
$CardHolderIpAddr = $whmcs->get_req_var("CardHolderIpAddr");
$RequestTrace = $whmcs->get_req_var("RequestTrace");
$Reference = $whmcs->get_req_var("Reference");
$Extra1 = $whmcs->get_req_var("Extra1");
$Extra2 = $whmcs->get_req_var("Extra2");
$Extra3 = $whmcs->get_req_var("Extra3");
$Amount = $whmcs->get_req_var("Amount");
$Reason = $whmcs->get_req_var("Reason");
$Fee = 0; // To be used if the Sage Paynow API starts to return a fee for each transaction.

// Verify the callback using the Sage Paynow API.
$RequestTraceURL = 'https://gateway.sagepay.co.za/transactionstatus';
$RequestTraceQuery = 'RequestTrace='.urlencode($RequestTrace);

// Check that we did receive Request Trace, otherwise assume some error.
// This is to prevent some injections attacks against the callback.
if (!empty($RequestTrace)) {
	// Get the response from Sage Paynow.
	$SageResponse = curlCall($RequestTraceURL, $RequestTraceQuery);

	// Decode the JSON response provided by Sage Paynow.
	$SageData = json_decode($SageResponse);

	// Check that we received valid data from Sage Paynow.
	if (!is_object($SageData)) {
		logTransaction($GATEWAY['name'], $SageResponse, "ERROR: JSON Decode Error");
		exit;
	}

	// InvoiceID forms part of the Reference.
	$Matches = array();
	if (!preg_match('/^(\d+)-(\d+)$/', $Reference, $Matches)) {
		logModuleCall($GATEWAY['name'], 'Get InvoiceID', $Reference, 'Failed', '', '');
		exit("Invalid Reference Received.");
	}
	$InvoiceID = $Matches[1];

	// Check if the payment succeeded.
	if (($TransactionAccepted == 'true') && ($SageData->TransactionAccepted == true)) {
		// Payment Successful.
		// Verify invoice ID.
		$InvoiceID = checkCbInvoiceID($InvoiceID, $GATEWAY['name']);
		// Check if we have received this notification before.
		// checkCbTransID($RequestTrace); // Replaced by the functions below. 
		$CheckResult = select_query("tblaccounts", "COUNT(*)", array("transid" => $RequestTrace));
		$CheckData = mysql_fetch_array($CheckResult);
		// If data is returned, then show the PAID invoice.
		if ($CheckData[0]) {
			// Redirect to the paid invoice.
			header("Location: ".$CONFIG['SystemURL']."/viewinvoice.php?id=$InvoiceID&paymentsuccess=true");
			exit;
		}
		// Add the payment to the invoice in WHMCS.
		addInvoicePayment($InvoiceID, $RequestTrace, $Amount, $Fee, $GATEWAY['name'], false, getTodaysDate());
		// Log the transaction for auditing purposes.
		logTransaction($GATEWAY['name'], $_REQUEST, "Successful");
		// Redirect to the paid invoice.
		header("Location: ".$CONFIG['SystemURL']."/viewinvoice.php?id=$InvoiceID&paymentsuccess=true");
		exit;
	} else if (($TransactionAccepted == 'false') && ($SageData->TransactionAccepted == false)) {
		// PaymentFailed
		// Log the transaction for auditing purposes.
		logTransaction($GATEWAY['name'], $_REQUEST, "Unsuccessful");
		// Redirect to the unpaid invoice.
		header("Location: ".$CONFIG['SystemURL']."/viewinvoice.php?id=$InvoiceID&paymentfailed=true&reason=".urlencode($Reason));
		exit;
	}
}
// Log the transaction for auditing purposes.
logTransaction($GATEWAY['name'], $_REQUEST, "Error");
header("Location: ".$CONFIG['SystemURL']."/clientarea.php");
exit;
?>