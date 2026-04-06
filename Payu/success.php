<?php
$status=$_POST["status"];
$firstname=$_POST["firstname"];
$amount=$_POST["amount"];
$txnid=$_POST["txnid"];
$posted_hash=$_POST["hash"];
$key=$_POST["key"];
$udf1=$_POST["udf1"];
$productinfo=$_POST["productinfo"];
$email=$_POST["email"];
$salt = getenv('PAYU_SALT');
require_once "../inc/config.php";
require_once "../inc/secondary_functions.php";

If (isset($_POST["additionalCharges"])) {
       $additionalCharges=$_POST["additionalCharges"];
        $retHashSeq = $additionalCharges.'|'.$salt.'|'.$status.'||||||||||'.$udf1.'|'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
        
                  }
  else {    

        $retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;

         }
     $hash = hash("sha512", $retHashSeq);
     //$txnid="pritam";
       if ($hash != $posted_hash) {
         echo "Invalid Transaction. Please try again ";
          
          $query4 = odbc_exec($con,"UPDATE account SET pcoins = pcoins + $amount + ($amount*0.3) WHERE c_id = '$productinfo'");

       }
     else {
               
          echo "<h3>Thank You. Your order status is ". $status .".</h3>";
          echo "<h4>Your Transaction ID for this transaction is ".$txnid.".</h4>";
          echo "<h4>We have received a payment of Rs. " . $amount . ". Your Premium Coins will soon be Credited.<br>The Page will redirect to A3Ultimate ACP Homepage. </h4>";
          $query1 = odbc_exec($con,"SELECT pcoins FROM account WHERE c_id = '$productinfo'");
          $pcoins = odbc_result($query1,"pcoins");
          $rs = odbc_exec($con, "SELECT Count(*) AS counter FROM coinlog WHERE GMName='" . $txnid . "'");
          $arr = odbc_fetch_array($rs);
          $count = $arr[counter];
          $discount = $amount*0;
          $newcoins=$amount+$discount;
          $ncoins=$pcoins+$newcoins;
          if ($count < 1)
            {
                $query4 = odbc_exec($con,"UPDATE account SET pcoins = pcoins + $newcoins WHERE c_id = '$productinfo'");
                $query2 = odbc_exec($con, "INSERT INTO coinlog(GMName,eshopper,coinsadded,extra,DateTime) VALUES('$txnid','$productinfo','$amount','$amount', CONVERT(DATETIME, '$date', 102))");
                $msg[] = "$amount + $discount Premium Coins have been successfully added, Into account $productinfo !!";
$log = "Hello,<br>You have successfully purchased ".$amount." Premium coins in account ID: ".$productinfo.".<br>You have also received ".$discount." extra Premium coins as an offer. Total Premium coins added to your account is ".$newcoins."<br>You now have ".$ncoins." Premium Coins in your account.<br>You can use these Premium coins to shop at our awesome E-Shop.<br><a href=\"/beta/Eshop/\">Click Here</a> to go to our E-Shop. <br><br> - Eshop Admin Ultimate";
log_action($productinfo,"N.A",$log,$con);
$subject = "A3 Ultimate : ".$newcoins." Premium coins credited to your account.";
email_action($productinfo,$subject,$log,$con);
echo $htmlHeader;
          while($stuff){
            echo $stuff;
           }
           echo "<script>window.location = '/ACP/'</script>";
          }
           // echo "<br>Executed $count";
            
            else{
            echo "<br>Your account is already Credited with the premium coins, Please close this window.";
            echo $htmlHeader;
          while($stuff){
            echo $stuff;
           }
           echo "<script>window.location = '/ACP/'</script>";
          }

          }         
?>