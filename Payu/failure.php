<?php
  /*
   *  @author   Gopal Joshi
   *  @about    PayUMoney Payment Gateway integration in PHP
   */

  $status      = $_POST["status"];
  $firstname   = $_POST["firstname"];
  $amount      = $_POST["amount"];
  $txnid       = $_POST["txnid"];
  $posted_hash = $_POST["hash"];
  $key         = $_POST["key"];
  $UDF3         = $_POST["udf3"];
  $productinfo = $_POST["productinfo"];
  $email       = $_POST["email"];
  $salt        = getenv('PAYU_SALT'); // Your salt

  If(isset($_POST["additionalCharges"])) {

    $additionalCharges = $_POST["additionalCharges"];
    $retHashSeq = $additionalCharges.'|'.$salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;      
  } else {	  
    $retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
  }

  $hash = hash("sha512", $retHashSeq);

  if ($hash != $posted_hash) {
    echo "Invalid Transaction. Please try againd $UDF3";

  } else {
    echo "<h3>Your order status is ". $status .".</h3>";
    echo "<h4>Your transaction id for this transaction is ".$txnid.". You can retry the payment if needed.<br> You can contact GMProt on ".getenv('SUPPORT_PHONE')." if there is any problem.</h4>";
  }
?>