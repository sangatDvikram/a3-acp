<?php 
require_once "inc/config.php";
require_once "inc/secondary_functions.php";
//page_protect();


$account = $_GET['acc'];
$vercode = $_GET['code'];
$account = antisql($account);
$varcode = antisql($varcode);

		foreach($_GET as $key => $value) 
		{
			$data[$key] = antisql($value); 
		}
		
		$dsf1 = odbc_exec($con,"SELECT * FROM account WHERE c_id = '{$account}'");
		$fgh1 = odbc_fetch_array($dsf1);
		$activated = $fgh1['verified'];	
		$code = $fgh1['actcode'];		
		$codea = $vercode;
		$i=0;
		if($code == $codea) 
		{

			if($activated > 1) 
			{
				$err[] = "Notice : Your account is banned. Please contact support. You will be redirected to the support page in 10 seconds."; 
				header("location:http://$_SERVER[SERVER_NAME]/Login/Ban/"); 
			}
			else if($activated == 1) 
			{
				$err[] = "Notice : Account already Activated. You will be redirected to the index page in 5 seconds."; 
				header("location:http://$_SERVER[SERVER_NAME]/Login/Activated/");
			}
			else
			{
				$sql_insert1 = odbc_exec($con, "UPDATE account SET verified = 1  WHERE c_id = '{$account}'");
				header("location:http://$_SERVER[SERVER_NAME]/Login/Success/"); 				
			}
		}
		else
		{
			header("location:http://$_SERVER[SERVER_NAME]/Login/Error/");
		}
		
		
?>
