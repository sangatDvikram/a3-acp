<?php

include '../inc/config.php';
include '../inc/secondary_functions.php';
/*
ipn.php - example code used for the tutorial:

PayPal IPN with PHP
How To Implement an Instant Payment Notification listener script in PHP
http://www.micahcarrick.com/paypal-ipn-with-php.html

(c) 2011 - Micah Carrick
*/

// tell PHP to log errors to ipn_errors.log in this directory
ini_set('log_errors', true);
ini_set('error_log', dirname(__FILE__).'/ipn_errors.log');

// intantiate the IPN listener
include('ipnlistener.php');
$listener = new IpnListener();

// tell the IPN listener to use the PayPal test sandbox
$listener->use_sandbox = false;

// try to process the IPN POST
try {
    $listener->requirePostMethod();
    $verified = $listener->processIpn();
} catch (Exception $e) {
    error_log($e->getMessage());
    exit(0);
}

if ($verified) {

    $errmsg = '';   // stores errors from fraud checks
    
    // 1. Make sure the payment status is "Completed" 
    if ($_POST['payment_status'] != 'Completed') { 
        // simply ignore any IPN that is not completed
        exit(0); 
    }

    // 2. Make sure seller email matches your primary account email.
    if ($_POST['receiver_email'] != getenv('PAYPAL_EMAIL')) {
        $errmsg .= "'receiver_email' does not match: ";
        $errmsg .= $_POST['receiver_email']."\n";
    }
    
    // 3. Make sure the amount(s) paid match
    if ($_POST['mc_gross'] != '9.99') {
        $errmsg .= "'mc_gross' does not match: ";
        $errmsg .= $_POST['mc_gross']."\n";
    }
    
    // 4. Make sure the currency code matches
    if ($_POST['mc_currency'] != 'USD') {
        $errmsg .= "'mc_currency' does not match: ";
        $errmsg .= $_POST['mc_currency']."\n";
    }

    // 5. Ensure the transaction is not a duplicate.
   /* mysql_connect('localhost', 'DB_USER', 'DB_PW') or exit(0);
    mysql_select_db('DB_NAME') or exit(0);

    $txn_id = mysql_real_escape_string($_POST['txn_id']);
    $sql = "SELECT COUNT(*) FROM orders WHERE txn_id = '$txn_id'";
    $r = mysql_query($sql);
    
    if (!$r) {
        error_log(mysql_error());
        exit(0);
    }
    
    $exists = mysql_result($r, 0);
    mysql_free_result($r);
    
    if ($exists) {
        $errmsg .= "'txn_id' has already been processed: ".$_POST['txn_id']."\n";
    }
    
    if (!empty($errmsg)) {
    
        // manually investigate errors from the fraud checking
        $body = "IPN failed fraud checks: \n$errmsg\n\n";
        $body .= $listener->getTextReport();
        mail(getenv('PAYPAL_ADMIN_EMAIL'), 'IPN Fraud Warning', $body);
        
    } else {
    
        // add this order to a table of completed orders
        $payer_email = mysql_real_escape_string($_POST['payer_email']);
        $mc_gross = mysql_real_escape_string($_POST['mc_gross']);
        $sql = "INSERT INTO orders VALUES 
                (NULL, '$txn_id', '$payer_email', $mc_gross)";
        
        if (!mysql_query($sql)) {
            error_log(mysql_error());
            exit(0);
        }
        
        // send user an email with a link to their digital download
        $to = filter_var($_POST['payer_email'], FILTER_SANITIZE_EMAIL);
        $subject = "Your digital download is ready";
        mail($to, "Thank you for your order", "Download URL: ...");
    }
    */
	 // assign posted variables to local variables
$receiver_email = $_POST['receiver_email'];
$payment_date = $_POST['payment_date'];
$payment_status = $_POST['payment_status'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$address_country = "";
$address_state ="";
$address_city ="";
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$mc_gross = $_POST['mc_gross'];
$mc_fee = $_POST['mc_fee'];
$txn_type = $_POST['txn_type'];
$txn_id = $_POST['txn_id'];
$notify_version = $_POST['notify_version'];
$payer_email = $_POST['payer_email'];
$mc_currency = $_POST['mc_currency'];
$custom_userid = $_POST['custom'];
$_SESSION['gross']=$mc_gross;
$query1 = "SELECT * FROM Transactions where txn_id='$txn_id' ";// Qury to select item to be viewed
$rs1 = odbc_exec($con2,$query1);
$num=odbc_num_rows($rs1);
if($num==0){
// Place the transaction into the database
$sql = odbc_exec($con2,"INSERT INTO Transactions (custom_userid, payer_email, first_name, last_name, payment_date, mc_gross,txn_id, receiver_email, payment_status, txn_type,  address_city, address_state,  address_country,notify_version,mc_currency, mc_fee,item_name,item_number) 
   VALUES('$custom_userid','$payer_email','$first_name','$last_name','$payment_date','$mc_gross','$txn_id','$receiver_email','$payment_status','$txn_type','$address_city','$address_state','$address_country','$notify_version','$mc_currency','$mc_fee','$item_name','$item_number')");
$username = $custom_userid;
$per=($mc_gross*60)/100;
$extra = round($per*0);
$coins = 0;
$net=$mc_gross-$mc_fee;
$pc=round($mc_gross*60);
$result = odbc_exec($con,"SELECT c_id,pcoins FROM account WHERE c_id = '$username'"); 
$num = odbc_num_rows($result);
$coins = odbc_result($result, "pcoins");
$ncoins = $coins + $pc + $extra;
$newcoins = $pc + $extra;
$query = odbc_exec($con,"UPDATE account SET pcoins = '$ncoins' WHERE c_id = '$username'");
$query2 = odbc_exec($con, "INSERT INTO coinlog(GMName,eshopper,coinsadded,extra,DateTime) VALUES('PayPal','$username','$pc','$extra', CONVERT(DATETIME, '$date', 102))");
if($query)
{ 
$msg[] = "$pc Premium Coins have been successfully added, Into account $username using paypal donation!!";
$log = "Hello,<br>You have successfully purchased ".$pc." Premium coins in id: ".$username." using paypal donation. <br>The paypal transaction ID is $txn_id <br> Total Premium coins added to your account is ".$newcoins."<br> Thus, You now have ".$ncoins." Premium Coins in your account.<br>You can use these Premium coins to shop at our awesome E-Shop.<br><a href=\"/beta/eshop\">Click Here</a> to go to our E-Shop. <br><br> - Eshop Admin Ultimate";
log_action($username,"N.A",$log,$con);
$subject = "A3 Ultimate : ".$newcoins." Premium coins credited to your account.";
email_action($username,$subject,$log,$con);
}
   if (!$sql) {
        error_log(odbc_error());
        exit(0);
    }
	}
email_action(getenv('PAYPAL_ADMIN_EMAIL'),"You got $mc_gross USD with Trnx ID $txn_id","$first_name $last_name, Paid you $mc_gross USD. Payer's email id is $payer_email and ingame account id is $username. Payer recived $pc + extra $extra premium coins = $newcoins. The payer now have $ncoins Premium coins in the account. The Paypal Transaction ID of this payment is $txn_id. The transaction type was $txn_type. The exact Date and time when the premium coins were added was $payment_date. You earned total amount of:$net.",$log,$con);

        error_log("Its done");
        } else {
    // manually investigate the invalid IPN
    mail(getenv('PAYPAL_ADMIN_EMAIL'), 'Invalid IPN', $listener->getTextReport());
}

?>