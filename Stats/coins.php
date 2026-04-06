<?php
include '../inc/config.php';
include '../inc/secondary_functions.php';
?>
<?php 
$dsf1 = odbc_exec($con,"SELECT pcoins FROM account WHERE c_id = '$_SESSION[username]'");
$fgh1 = odbc_fetch_array($dsf1); ?>
            Total Premium Coins: <?php echo $fgh1['pcoins']; ?> </li>
                <li><?php 
			$dsf = odbc_exec($con,"SELECT coins FROM account WHERE c_id = '$_SESSION[username]'");
$fgh = odbc_fetch_array($dsf); ?>
            Total Eshop Coins: <?php echo $fgh['coins']; ?> </li>
			<li><?php 
$dsf1 = odbc_exec($con,"SELECT gold FROM account WHERE c_id = '$_SESSION[username]'");
$fgh1 = odbc_fetch_array($dsf1); ?>
           Total Gold Coins: <?php echo $fgh1['gold']; ?>