<?php
/*
 * Pay Now WHMCS Gateway Module
 */
function paynow_config() {
	$configarray = array (
		"FriendlyName" => array (
			"Type" => "System",
			"Value" => "Sage Pay Now"
		),
		"account_number" => array (
			"FriendlyName" => "Account Number",
			"Type" => "text",
			"Size" => "40"
		),
		"service_key" => array (
			"FriendlyName" => "Service Key",
			"Type" => "text",
			"Size" => "40"
		),
		"whmcs_admin_username" => array (
			"FriendlyName" => "WHMCS Admin User Name",
			"Type" => "text",
			"Size" => "20",
			"Description" => "Need an admin user name to use the local API, usually it's just 'admin'.",
		),
		"sendemailconfirm" => array (
			"FriendlyName" => "Send email",
			"Type" => "yesno",
			"Description" => "An email confirmation will be sent from the Pay Now gateway to the client after each transaction."
		)
	);
	return $configarray;
}
function paynow_link($params) {

	// Gateway Specific Variables
	$m1_PayNowServiceKey = $params ['service_key'];
	// Software vendor key is the hard coded for Pay Now Online web software requests
	$m2_SoftwareVendorKey = "24ade73c-98cf-47b3-99be-cc7b867b3080";

	// Invoice Variables
	$p2_UniqueRef = sprintf("%d-%d", $params ['invoiceid'], date("U"));
	$p3_Description = $params ['description'];
	$p4_Amount = $params ['amount'];
	$Budget = "N";

	// Client details
	$m4_Extra1 = $params ['clientdetails'] ['userid'];
	$m5_Extra2 = $params ['clientdetails'] ['firstname'] . ' ' . $params ['clientdetails'] ['firstname'];
	if ($params ['clientdetails'] ['companyname']) {
		$m5_Extra2 = $m5_Extra2 . $params ['clientdetails'] ['companyname'];
	}
	$m6_Extra3 = $params ['clientdetails'] ['phonenumber'];

	if ($params ['sendemailconfirm'] == 'on') {
		$m9_CardHolder = $params ['clientdetails'] ['email'];
	}

	$m10_ReturnText = "GatewayReturned";

	// $invoiceid = $params ['invoiceid'];
	$description = $params ["description"];
	$amount = $params ['amount'];
	$currency = $params ['currency'];

	$customerName = "{$params['clientdetails']['firstname']} {$params['clientdetails']['lastname']}";
	$orderID = $invoiceid;
	$customerID = $params ['clientdetails']['userid'];
	$sageGUID = "d783602-0f3c-4a19-9649-e2972cbb9eb6";

	// Gateway submit code
	// Refer to documentation
	$code = '<form action="https://paynow.sagepay.co.za/site/paynow.aspx" method="post">
				<input type="hidden" name="m1" value="' . $m1_PayNowServiceKey . '" />
				<input type="hidden" name="m2" value="' . $m2_SoftwareVendorKey . '" />
				<input type="hidden" name="p2" value="' . $p2_UniqueRef . '" />

				<input type="hidden" name="p3" value="' . "{$customerName} | {$orderID}" . '" />
				<input type="hidden" name="p4" value="' . $p4_Amount . '" />

				<input type="hidden" name="Budget" value="' . $Budget . '" />

				<input type="hidden" name="m3" value="' . $sageGUID . '" />

				<input type="hidden" name="m4" value="' . $customerID . '" />
				<input type="hidden" name="m5" value="' . $m5_Extra2 . '" />
				<input type="hidden" name="m6" value="' . $m6_Extra3 . '" />

				<input type="hidden" name="m9" value="' . $m9_CardHolder . '" />
				<input type="hidden" name="m10" value="' . $m10_ReturnText . '" />

				<input type="submit" value="Pay" />
</form>';

	return $code;
}
