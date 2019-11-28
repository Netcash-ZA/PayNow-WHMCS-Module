<?php

# Required File Includes
include("../../../init.php");
include("../../../includes/functions.php");
include("../../../includes/gatewayfunctions.php");
include("../../../includes/invoicefunctions.php");

# Set to true to enable logging
define('PN_DEBUG', false);

/**
 * pnlog
 *
 * Log function for logging output.
 *
 * @param $msg String Message to log
 * @param $close Boolean Whether to close the log file or not
 */
function pnLog( $msg = '', $close = false ) {
    static $fh = 0;
    global $module;

    // Only log if debugging is enabled
    if( PN_DEBUG ) {
        if( $close ) {
            fclose( $fh );
        } else {
            // If file doesn't exist, create it
            if( !$fh ) {
                $pathinfo = pathinfo( __FILE__ );
                $fh = fopen( $pathinfo['dirname'] .'/paynow.log', 'a+' );
            }

            // If file was successfully created
            if( $fh ) {
                $line = date( 'Y-m-d H:i:s' ) .' : '. $msg ."\n";

                fwrite( $fh, $line );
            }
        }
    }
}

pnLog( 'Callback Received: '. print_r( $_POST, true ) );

$gatewaymodule = "paynow"; # Enter your gateway module name here replacing template

$GATEWAY = getGatewayVariables($gatewaymodule);
if (!$GATEWAY["type"]) die("Module Not Activated"); # Checks gateway module is active before accepting callback

pnLog( 'GATEWAY: '. print_r( $GATEWAY, true ) );

# Get Returned Variables - Adjust for Post Variable Names from your Gateway's Documentation
$status = $_POST["TransactionAccepted"];

// Reference is sent as p2
$matches = array();
preg_match('/(\d{1,8})-/', $_POST["Reference"], $matches);

$invoiceid = $matches[1];
$transid = $_POST["Reference"];
$amount = $_POST["Amount"];
$fee = "";
$adminuser = $GATEWAY['whmcs_admin_username'];

$invoiceid = checkCbInvoiceID($invoiceid,$GATEWAY["name"]); # Checks invoice ID is a valid invoice number or ends processing

pnLog( 'Invoice Id: '. print_r( $invoiceid, true ));
pnLog( 'Status: '. print_r( $status, true ) . ' - ' .  gettype($status) );

if ($status=="true") {
    # Successful
    pnLog( 'Transaction Successful' );

    checkCbTransID($transid); # Checks transaction number isn't already in the database and ends processing if it does
    pnLog( 'checkCbTransID Called' );

    // addInvoicePayment($invoiceid, $transid, $amount, $fee, $gatewaymodule); # Apply Payment to Invoice: invoiceid, transactionid, amount paid, fees, modulename
    $command = "addinvoicepayment";
    $values = array();
    $values["invoiceid"] = $invoiceid;
    $values["transid"] = $transid;
    $values["amount"] = $amount;
    $values["fee"] = $fee;
    $values["gateway"] = $gatewaymodule;
    $values["date"] = date('Y-m-d H:i:s');
    $results = localAPI($command,$values,$adminuser);

    pnLog( 'addinvoicepayment Result: '. print_r( $results, true ) );

    logTransaction($GATEWAY["name"],$_POST,"Successful"); # Save to Gateway Log: name, data array, status

    echo "<p>Payment was successful.</p>";
    echo "<p>You will be redirected to the client area in 5 seconds. <a href='../../../clientarea.php'>Click here</a> to return immediately.</p>";
    ?>

    <script type="text/javascript">
        setTimeout(function () {
           window.location.href = "../../../clientarea.php";
        }, 5000);
    </script>
    <?php
    pnLog( 'Returning to clientarea.' );
} else {
    # Unsuccessful
    pnLog( 'Transaction Unsuccessful' );
    logTransaction($GATEWAY["name"],$_POST,"Unsuccessful"); # Save to Gateway Log: name, data array, status
    echo "<p>Payment was declined. Reason: " . $_POST['Reason'] . "</p>";
    echo "<p><a href='../../../cart.php'>Click here</a> to return to the cart.</p>";
}

pnLog( 'Completed' );
pnLog( '', true );
