<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>A3 Ultimate - ACP OP to Online Points Converter</title>
<?php include 'header-acp.php'; 
page_protect();
if(isset($_POST['E1']))
{
foreach($_POST as $key => $value) {
$data[$key] = antisql($value); }
$msg = array();
$err = array();
$char = $data['character'];
$name=$char;
$charquery = odbc_exec($con,"SELECT * FROM charac0 WHERE c_id = '$name' AND c_status = 'A' AND c_sheadera = '$_SESSION[username]'");
$sup2 = odbc_fetch_array($charquery);
if($sup2['pnline'] == 1) { $err[] = "Please logout in game before continuing."; }
if($char == "") { $err[] = "No character was selected. Please select a character and try again."; 
} else {
$username = $_SESSION['username'];
$sql1 = "SELECT account.c_id, account.c_headera, charac0.c_id FROM account INNER JOIN charac0 ON account.c_id = charac0.c_sheadera WHERE (account.c_id = '$username') AND (charac0.c_id = '$char')";
$rs1 = odbc_exec($con,$sql1);
$result66 = odbc_exec($con,"SELECT c_id, op FROM charac0 WHERE c_id = '$char'"); 
$num = odbc_num_rows($result66);
$coins = odbc_result($result66, "op");
//if its return 1, then its the correct user
$rec1 = odbc_fetch_row($rs1);
if ($rec1 == 1)
	{
		//initializing string
				include('inc/m_body_char.php');
				$sr = explode(";",$INVEN[1]);
				if($sr[0] == '9653')
				{
					if($sr[1] == '32' || '39')
					{
						if($sr[2] == '393483' || '786699')
						{
							if($sr[3] == '0')
							{
								$shue = explode(";",$PETACT[1]);
								if(1)
								{
									$newcoins = $coins + 4000;
									$shue[2] = $shue[2] + 0;
									$PETACT[1] = $shue[0].";".$shue[1].";".$shue[2].";".$shue[3];
									
									$value=0;
									unset($sr[$value]);
									unset($sr[$value+1]);
									unset($sr[$value+2]);
									unset($sr[$value+3]);
									$sr = array_values($sr);
									$INVEN[1]=implode(";", $sr);
									$temp[6] = implode("=",$INVEN);
									$mbody = implode("\_1",$temp);
									$newString = $mbody;
									if(empty($err)) {
									$sqlgo= "update charac0 set m_body = '$newString' where c_id = '$char'";
									$rs12 = odbc_exec($con,$sqlgo);
									}
									if (!$rs12)
									{
										$err[] = "Error : Sorry, we are unable to process, please try again later.";
									}
									else
									{
										$msg[] = "Successfully converted OP 1."; 
										$lap = "UPDATE charac0 SET op = '$newcoins' WHERE (c_id = '$char')";
										$updatelog = odbc_exec($con, "INSERT INTO convertlog(item_used,convip,result_item,character,ID,oldcoin,newcoin,datetime) VALUES('$sr[0]','$_SERVER[REMOTE_ADDR]','$replace','$char','$username','$coins','$newcoins', CONVERT(DATETIME, '$date', 102))");
										$top = odbc_exec($con, $lap);
									};
								}
								else
								{
									$err[] = "Error : There is something Wrong.. Please take this screenshot and email us.";
								};
							}
							else
							{
								$err[] = "Error : Can't find any OP in your inventory! Please keep OP in the first slot of your Inventory.";
							};
						}
						else
						{
							$err[] = "Error : Can't find any OP in your inventory! Please keep OP in the first slot of your Inventory.";
						};	
					}
					else
					{
						$err[] = "Error : Can't find any OP in your inventory! Please keep OP in the first slot of your Inventory.";
					};
				}
				elseif($sr[0] == '9763')
				{
					if($sr[1] == '32' || '39')
					{
						if($sr[2] == '393483' || '786699')
						{
							if($sr[3] == '0')
							{
								$shue = explode(";",$PETACT[1]);
								if(1)
								{
									$newcoins = $coins + 40000;
									$shue[2] = $shue[2] + 0;
									$PETACT[1] = $shue[0].";".$shue[1].";".$shue[2].";".$shue[3];
									$value=0;
									unset($sr[$value]);
									unset($sr[$value+1]);
									unset($sr[$value+2]);
									unset($sr[$value+3]);
									$sr = array_values($sr);
									$INVEN[1]=implode(";", $sr);
									$temp[6] = implode("=",$INVEN);
									$mbody = implode("\_1",$temp);
									$newString = $mbody;
									if(empty($err)) {
									$sqlgo= "update charac0 set m_body = '$newString' where c_id = '$char'";
									$rs12 = odbc_exec($con,$sqlgo);
									}
									if (!$rs12)
									{
										$err[] = "Error : Sorry, we are unable to process, please try again later.";
									}
									else
									{
										$msg[] = "Successfully converted OP 4.";
										$lap = "UPDATE charac0 SET op = '$newcoins' WHERE (c_id = '$char')";
										$updatelog = odbc_exec($con, "INSERT INTO convertlog(item_used,result_item,character,ID,oldcoin,newcoin,datetime) VALUES('$sr[0]','$replace','$char','$username','$coins','$newcoins', CONVERT(DATETIME, '$date', 102))");
										$top = odbc_exec($con, $lap);
									};
								}
								else
								{
									$err[] = "Error : There is something Wrong.. Please take this screenshot and email us.";
								};
							}
							else
							{
								$err[] = "Error : Can't find any OP in your inventory! Please keep OP in the first slot of your Inventory.";
							};
						}
						else
						{
							$err[] = "Error : Can't find any OP in your inventory! Please keep OP in the first slot of your Inventory.";
						};	
					}
					else
					{
						$err[] = "Error : Can't find any OP in your inventory! Please keep OP in the first slot of your Inventory.";
					};
				}
				elseif($sr[0] == '9911134')
				{
					if($sr[1] == '32' || '39')
					{
						if($sr[2] == '393483' || '786699')
						{
							if($sr[3] == '0')
							{
								$shue = explode(";",$PETACT[1]);
								if(1)
								{
									$newcoins = $coins + 4;
									$shue[2] = $shue[2] + 0;
									$PETACT[1] = $shue[0].";".$shue[1].";".$shue[2].";".$shue[3];
									$inventory = explode(";",$INVEN[1]);
									$chunk = array_chunk($inventory,4);
									$value=0;
									unset($sr[$value]);
									unset($sr[$value+1]);
									unset($sr[$value+2]);
									unset($sr[$value+3]);
									$sr = array_values($sr);
									$INVEN[1]=implode(";", $sr);
									$temp[6] = implode("=",$INVEN);
									$mbody = implode("\_1",$temp);
									$newString = $mbody;
									if(empty($err)) {
									$sqlgo= "update charac0 set m_body = '$newString' where c_id = '$char'";
									$rs12 = odbc_exec($con,$sqlgo);
									}
									if (!$rs12)
									{
										$err[] = "Error : Sorry, we are unable to process, please try again later.";
									}
									else
									{
										$msg[] = "Successfully converted 4 gold. Your new balance is $newcoins gold.";
										$lap = "UPDATE account SET gold = '$newcoins' WHERE (c_id = '$username')";
										$updatelog = odbc_exec($con, "INSERT INTO convertlog(item_used,result_item,character,ID,oldcoin,newcoin,datetime) VALUES('$sr[0]','$replace','$char','$username','$coins','$newcoins', CONVERT(DATETIME, '$date', 102))");
										$top = odbc_exec($con, $lap);
									};
								}
								else
								{
									$err[] = "Error : There is something Wrong.. Please take this screenshot and email us.";
								};
							}
							else
							{
								$err[] = "Error : Can't find any OP in your inventory! Please keep OP in the first slot of your Inventory.";
							};
						}
						else
						{
							$err[] = "Error : Can't find any OP in your inventory! Please keep OP in the first slot of your Inventory.";
						};	
					}
					else
					{
						$err[] = "Error : Can't find any OP in your inventory! Please keep OP in the first slot of your Inventory.";
					};
				}
				elseif($sr[0] == '97123411')
				{
					if($sr[1] == '32' || '39')
					{
						if($sr[2] == '393483' || '786699')
						{
							if($sr[3] == '0')
							{
								$shue = explode(";",$PETACT[1]);
								if(1)
								{
									$newcoins = $coins + 1000;
									$shue[2] = $shue[2] + 0;
									$PETACT[1] = $shue[0].";".$shue[1].";".$shue[2].";".$shue[3];
									$inventory = explode(";",$INVEN[1]);
									$chunk = array_chunk($inventory,4);
									foreach($chunk as $key)
										{
											if(end($key) == "0")
												{ 
													$search = implode(";",$key);
													$replace = "";
													$subject = $INVEN[1];
													$INVEN[1] = str_replace($search,$replace,$subject);
												}
										}
									$newString = $temp[0]."\_1".$temp[1]."\_1".$temp[2]."\_1".$temp[3]."\_1".$temp[4]."\_1".$temp[5]."\_1".$INVEN[0]."=".$INVEN[1]."\_1".$temp[7]."\_1".$temp[8]."\_1".$temp[9]."\_1".$temp[10]."\_1".$temp[11]."\_1".$temp[12]."\_1".$temp[13]."\_1".$temp[14]."\_1".$temp[15]."\_1".$temp[16]."\_1".$temp[17]."\_1".$PETACT[0]."=".$PETACT[1]."\_1".$temp[19]."\_1".$temp[20]."\_1".$temp[21]."\_1".$temp[22]."\_1";
									if(empty($err)) {
									$sqlgo= "update charac0 set m_body = '$newString' where c_id = '$char'";
									$rs12 = odbc_exec($con,$sqlgo);
									}
									if (!$rs12)
									{
										$err[] = "Error : Sorry, we are unable to process, please try again later.";
									}
									else
									{
										$msg[] = "Successfully converted 1000 coins. Your new balance is $newcoins Coins.";
										$lap = "UPDATE account SET coins = '$newcoins' WHERE (c_id = '$username')";
										$updatelog = odbc_exec($con, "INSERT INTO convertlog(item_used,result_item,character,ID,oldcoin,newcoin,datetime) VALUES('$sr[0]','$replace','$char','$username','$coins','$newcoins', CONVERT(DATETIME, '$date', 102))");
										$top = odbc_exec($con, $lap);
									};
								}
								else
								{
									$err[] = "Error : There is something Wrong.. Please take this screenshot and email us.";
								};
							}
							else
							{
								$err[] = "Error : Can't find any OP in your inventory! Please keep OP in the first slot of your Inventory.";
							};
						}
						else
						{
							$err[] = "Error : Can't find any OP in your inventory! Please keep OP in the first slot of your Inventory.";
						};	
					}
					else
					{
						$err[] = "Error : Can't find any OP in your inventory! Please keep OP in the first slot of your Inventory.";
					};
				}
				
				else
				{
					$err[] = "Error : Can't find any OP in your inventory! Please keep OP in the first slot of your Inventory.";
				};
	}
}
}
?>
    <div class="container-fluid">
      
          
          <div class="row-fluid ">
              <div class="span3">
              <?php include 'side_bar.php';?>
            </div><!-- Menu -->
              <div class="span9"><!-- Main -->
              <div class="page-header" style="margin-top:0;">
 			   <h1>Account Control Panel:<small>OP to Online Points Converter</small></h1></div>

<form method="POST" action="">
		<?php
$query1 = "SELECT charac0.c_id FROM account INNER JOIN charac0 ON account.c_id = charac0.c_sheadera WHERE (charac0.c_sheadera = '$_SESSION[username]') AND (charac0.c_status = 'A') ORDER BY charac0.c_id";
$rs1 = odbc_exec($con,$query1);
if(odbc_num_rows($rs1) == 0)
{
	echo '<div class="alert alert-error" align="center">No Character was found in the account. Please create a character in game first.</div>';
} else {
	echo '<div class="alert alert-block" ><b>1. Please put the OP in the first slot of your inventory!<br>2. Please logout from game before submitting this form.</b></div>';
	
	if(!empty($err))  {
	   echo "<div class=\"alert alert-error\" align=\"Center\"><h4>";
	  foreach ($err as $e) {
	    echo "$e <br>";
	    }
	  echo "</h4></div>";
	   }
	   if(!empty($msg))  {
	    echo "<div class=\"alert alert-success\" align=\"Center\"> <h4>" . $msg[0] . "</h4></div>";

	   }
	echo '<hr><h4 class="text-center text-info"> - SELECT A CHARACTER - </h4><br><div class="controls" align="center"> ';

while (odbc_fetch_row($rs1))
	{
		$heroes1 = odbc_result($rs1, "c_id");
?> <label class="radio inline">
<input type="radio" value="<?php echo $heroes1; ?>" name="character" id="<?php echo $heroes1; ?>" /><?php echo $heroes1; ?></label>
<?php
}
echo '</div>';
echo ' <div class="form-actions" align="center"><input class="btn btn-primary" align="center" type="submit" value="Submit" name="E1" /></div>';
}
?>

</form>
</div><!-- Main -->
</div><!-- Cointainer -->
<hr>
<?php include('browser.php'); 
$ua=getBrowser();
 $ip=$_SERVER['REMOTE_ADDR'];
?>
<div class="row-fluid" align="center">
<div class="span4" style="border-right:1px solid #d9d9d9"><p style="margin:0; padding:0; text-align:center">Your IP:&nbsp;&nbsp;  <i>  <?php echo getRealIpAddr();?> </i></p></div>
<div class="span4" style="border-right:1px solid #d9d9d9"><p style="margin:0; padding:0; text-align:center">Your Browser:<i>&nbsp;&nbsp;<?php echo $ua['name'] . " " . $ua['version'] ;?></i></p></div>
<div class="span4"><p style="margin:0; padding:0 ;text-align:center">Visitor Counter : <i>&nbsp;&nbsp;<?php echo $_country; ?></i></p></div>

</div><!-- details -->
</div> <!-- /container fluid-->
<?php include 'footer.php';?>