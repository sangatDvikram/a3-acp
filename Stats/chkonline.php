<?php
include '../inc/config.php';
include '../inc/secondary_functions.php';
$username=$_SESSION['username'];
if(isset($_SESSION['username'])){
			$charquery = odbc_exec($con,"SELECT * FROM charac0 WHERE c_sheadera = '$_SESSION[username]' AND c_status = 'A' ORDER BY c_id ASC ");
			$i = 1;
			echo "<div class='row-fluid' >";
while ($sup2 = odbc_fetch_array($charquery)){
echo "<div class=\"span2 char$sup2[c_sheaderb]\" style=\"width:145px;\" >";
if($sup2['pnline'] == 1){echo "<p style=' padding:0;text-align:center;'><img src='http://$_SERVER[SERVER_NAME]/images/status.png' title='online'>";}else{echo "<p style=' padding:0;text-align:center;'><img src='http://$_SERVER[SERVER_NAME]/images/status-offline.png' title='offline'>";}
			echo wordwrap(htmlentities($sup2['c_id']),10,"<br />\n")."</p>";
			echo"<p style=' padding:0; padding-left:3px;font-size:13px;'>Reset:$sup2[reset]<br>Rebirth:$sup2[rb]<br>Online Points:$sup2[op]</p>";
			++$i;
			echo"</div>";
}
echo " </div>";
}
		else 
		{
		echo "No character has been log in";
		}


?>
        	 <!-- Chatacher info -->
            <div class='row-fluid' style='margin-top:20px;'><!-- Coins  info -->
            <div class='span4'>
			<?php 
$dsf1 = odbc_exec($con,"SELECT pcoins FROM account WHERE c_id = '$_SESSION[username]'");
$fgh1 = odbc_fetch_array($dsf1); ?>
            <p style='font-size:15px;padding:0'>Total Premium Coins: <?php echo $fgh1['pcoins']; ?> </p>
            </div>
            <div class='span4'>
			<?php 
			$dsf = odbc_exec($con,"SELECT coins FROM account WHERE c_id = '$_SESSION[username]'");
$fgh = odbc_fetch_array($dsf); ?>
            <p style='font-size:15px; padding:0'>Total Eshop Coins: <?php echo $fgh['coins']; ?> </p>
            </div>
            <div class='span4'>
			<?php 
$dsf1 = odbc_exec($con,"SELECT gold FROM account WHERE c_id = '$_SESSION[username]'");
$fgh1 = odbc_fetch_array($dsf1); ?>
            <p style='font-size:15px;padding:0'>Total Gold Coins: <?php echo $fgh1['gold']; ?> </p>
            </div>
            
  			 </div><!-- Coins  info -->