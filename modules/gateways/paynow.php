<?php

// Ensure we are running in the WHMCS environment.
if (!defined("WHMCS")) {
	exit("This file cannot be accessed directly");
}
	
/*
 * Pay Now WHMCS Gateway Module
 */
function paynow_config() {
	$configarray = array (
			"FriendlyName" => array (
					"Type" => "System",
					"Value" => "Sage Pay Now"
			),
			"ServiceKey" => array (
					"FriendlyName" => "Service Key",
					"Type" => "text",
					"Size" => "40"
			),
			"EnableBudget" => array(
					"FriendlyName" => "Support Budget Period", 
					"Type" => "yesno", 
					"Description" => "Allow the client to purchase using their budget facility on the credit card."
			),
			"SendEmail" => array(
					"FriendlyName" => "Send Email", 
					"Type" => "yesno", 
					"Description" => "Let Sage Pay Now send an email to the client about the transaction."
			),
			"MyUsageNotes" => array(
					"FriendlyName" => "Usage", 
					"Type" => "", 
					"Description" => "You must enable the <b>Accept url</b> and the <b>Decline url</b> in your Sage Pay Now account by going to <b>Account Profile > Sage Connect > PayNow</b> and then entering the following url in the Accept url and Decline url fields: <b>".$CONFIG["SystemURL"]."/modules/gateways/callback/paynow.php</b>"
			)
	);
	return $configarray;
}

function paynow_link($params) {
	// Gateway Specific Variables
	$m1_PayNowServiceKey = $params['ServiceKey'];
	// Software vendor key is the hard coded for Pay Now Online web software requests
	$m2_SoftwareVendorKey = "24ade73c-98cf-47b3-99be-cc7b867b3080";

	// Invoice Variables
	$p2_UniqueRef = sprintf("%d-%d", $params['invoiceid'], date("U"));
	$p3_Description = $params['description'];
	$p4_Amount = sprintf("%.2f", $params['amount']);
	// Should SagePay allow the client to purchase on Budget.
	if ($params['EnableBudget'] == 'yes') {
		$Budget = "Y";
	} else {
		$Budget = "N";
	}

	// Client details
	$m4_Extra1 = $params['clientdetails']['userid'];
	$m5_Extra2 = $params['clientdetails']['firstname'].' '.$params['clientdetails']['lastname'];
	if ($params ['clientdetails'] ['companyname']) {
		$m5_Extra2 = $m5_Extra2.' - '.$params['clientdetails']['companyname'];
	}
	$m6_Extra3 = $params['clientdetails']['phonenumber'];

	if ($params ['SendEmail'] == 'on') {
		$m9_CardHolder = $params['clientdetails']['email'];
	}

	$m10_ReturnText = "GatewayReturned";

	// Gateway submit code
	// Refer to documentation
	$code = '<form action="https://paynow.sagepay.co.za/site/paynow.aspx" method="post">
				<input type="hidden" name="m1" value="' . $m1_PayNowServiceKey . '" />
				<input type="hidden" name="m2" value="' . $m2_SoftwareVendorKey . '" />
				<input type="hidden" name="p2" value="' . $p2_UniqueRef . '" />
				<input type="hidden" name="p3" value="' . $p3_Description . '" />
				<input type="hidden" name="p4" value="' . $p4_Amount . '" />
				<input type="hidden" name="Budget" value="' . $Budget . '" />
				<input type="hidden" name="m4" value="' . $m4_Extra1 . '" />
				<input type="hidden" name="m5" value="' . $m5_Extra2 . '" />
				<input type="hidden" name="m6" value="' . $m6_Extra3 . '" />
				<input type="hidden" name="m9" value="' . $m9_CardHolder . '" />
				<input type="hidden" name="m10" value="' . $m10_ReturnText . '" />
				<input type="submit" value="'.$params['langpaynow'].'" />
			</form>';
	return $code;
}