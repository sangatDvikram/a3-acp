<?php
include '../inc/config.php';
include '../inc/secondary_functions.php';
if(isset($_POST['char']))
{
foreach($_POST as $key => $value) {
	$data[$key] = antisql($value); // post variables are filtered
}
$msg = array();
$OnlineErr = array();
$err=array();
$pre = array();
$char=$data['char'];
if($char!='x'){
		$charquery = odbc_exec($con,"SELECT * FROM charac0 WHERE c_id = '$char' ");
		$charInfo = odbc_fetch_array($charquery);
		$actquery = odbc_exec($con,"SELECT * FROM account WHERE c_id = '$charInfo[c_sheadera]'");
		$actInfo = odbc_fetch_array($actquery);
		$rbque = odbc_exec($con2,"SELECT top 1 * FROM rbinfo order by Rb desc");
		$rbInfoQ = 18;
		$rebirth=$charInfo['rb'];
		if($rebirth>=18){
			echo "<div class='alert alert-info'><center>
		   <h3><img src='/images/like-32.png' width='24' height='24'>  Congratulations $char is Max Rebirth $rebirth Player ^_^ !!
		</h3></center></div>";
		}
		else
		{
		$newRb=$rebirth+1;
		$rbquerry = odbc_exec($con2,"SELECT * FROM rbinfo WHERE Rb = '$newRb'");
		$rbInfo = odbc_fetch_array($rbquerry);
		//Check the online Status
		if(is_online($charInfo['c_sheadera'])) { $OnlineErr[] = "Please logout in game before continuing."; }
		//-------------------------------------------------------------------------------------------------------------------------
		//Images
		$errImg="<img src='/images/Delete.png'  width='24' height='24'>";
		$SuccessImg="<img src='/images/Select.png'  width='24' height='24'>";
		$InfoImg="<img src='/images/Info.png'  width='24' height='24'>";
		//Text and Table
		$errTxt="class='text-error'";
		$sucTxt="class='text-success'";
		$errCls="class='error'";
		$sucCls="class='success'";
		//-------------------------------------------------------------------------------------------------------------------------
		if(empty($OnlineErr)){
			$Img=$SuccessImg;
			$Stats='Offline';
			$onlineTxt=$sucTxt;
			$onlineClass=$sucCls;
		}
		else{
			
			$Img=$errImg;
			$Stats='Online';
			$err[]='1';
			$onlineTxt=$errTxt;
			$onlineClass=$errCls;
		}
		$onlineStatus="<tr $onlineClass>
		                 <td> $Img Character Status Required:   <span class='text-error' >Offline</span></td>
		                 <td>Your Status : <span $onlineTxt > $Stats </span></td>
		               </tr>";
		//Check Rb level-------------------------------------------------------------------------------------------------------------------
		if($charInfo['c_sheaderc']>=$rbInfo['Level_req']&&is_numeric($rbInfo['Level_req']))
		{
		$lvlClass=$sucCls;
		$lvlTxt=$sucTxt;
		$lvlImg=$SuccessImg;
		}
		else{
		$err[]='1';
		$lvlClass=$errCls;
		$lvlTxt=$errTxt;
		$lvlImg=$errImg;
		}
		$rbLevelStatus="<tr $lvlClass>
		                 <td> $lvlImg Level Required : <span class='text-error' >$rbInfo[Level_req]</span></td>
		                 <td>Your Level : <span $lvlTxt > $charInfo[c_sheaderc] </span></td>
		               </tr>";

		//Check Rb WZ------------------------------------------------------------------------------------------------------------------------
		if($charInfo['c_headerc']>=$rbInfo['Wz_req'])
		{
		$WzClass=$sucCls;
		$WzTxt=$sucTxt;
		$WzImg=$SuccessImg;
		}
		else{
		$err[]='1';
		$WzClass=$errCls;
		$WzTxt=$errTxt;
		$WzImg=$errImg;
		}
		$WzStatus="<tr $WzClass>
		                 <td> $WzImg Wz Required : <span class='text-error' >$rbInfo[Wz_req]</span></td>
		                 <td>Your Wz : <span $WzTxt > $charInfo[c_headerc] </span></td>
		               </tr>";
		//Check For Item Requirment------------------------------------------------------------------------------------------------------------
		if($rbInfo['Item_req']=='none')
		{
		$ItmStatus="<tr $sucCls>
		<td> $SuccessImg Item Required : <span class='text-error'>$rbInfo[Item_req]</span></td>
		<td> <span $sucTxt > </span></td>
		</tr>";
		}
		else{
			$pdo=new PDOExamples();
				//This is for Single Item----------------------------------------------------------------------------
			if($rbInfo['Item_req_count']==1){
				include('../inc/m_body_char.php');
				$invt = explode(";",$INVEN[1]);
				//$Itminfo=$pdo->ItemOptions($slot, $char);
				$info=$pdo->ItemOptions(1, $char);
				if($info['Name']=='')$info['Name']="Empty Slot";
				if($rbInfo['Item_req']==$info['ItemCode']){
					$ItmStatus="<tr $sucCls>
				<td> $SuccessImg Item Required : <span class='text-error'>".ItemName($rbInfo['Item_req'])."</span></td>
				<td> Your Inventory: <span $sucTxt >".clear($info['Name'])."</span></td>
				</tr>";

				}else{
					$err[]='1';
					$ItmStatus="<tr $errCls>
				<td> $errImg Item Required : <span class='text-error'>".ItemName($rbInfo['Item_req'])."</span></td>
				<td> Your Inventory: <span $errTxt >".clear($info['Name'])."</span></td>
				</tr>";
				}
			}
			//This is for 2 items---------------------------------------------------------------------------
			elseif($rbInfo['Item_req_count']==2){
				include('../inc/m_body_char.php');
				$invt = explode(";",$INVEN[1]);
				$reqItem=explode(",", $rbInfo['Item_req']);
				$invt1=$pdo->ItemOptions(1, $char);
				$invt2=$pdo->ItemOptions(2, $char);
				if($invt1['Name']=='')$invt1['Name']="Empty Slot";
				if($invt2['Name']=='')$invt2['Name']="Empty Slot";
				if($reqItem[0]==$invt1['ItemCode']&&$reqItem[1]==$invt2['ItemCode']){
					$ItmStatus="<tr $sucCls>
				<td> $SuccessImg Item Required : <span class='text-error'><br>1st Slot : ".ItemName($reqItem[0])." <br>2nd Slot : ".ItemName($reqItem[1])."</span></td>
				<td> Your Inventory: <span $sucTxt ><br>1st Slot : ".clear($invt1['Name'])." <br>2nd Slot : ".clear($invt2['Name'])."</span></td>
				</tr>";

				}else{
					$err[]='1';
					$ItmStatus="<tr $errCls>
				<td> $errImg Item Required : <span class='text-error'><br>1st Slot : ".ItemName($reqItem[0])." <br>2nd Slot : ".ItemName($reqItem[1])."</span></td>
				<td> Your Inventory: <span $errTxt ><br>1st Slot : ".clear($invt1['Name'])." <br>2nd Slot : ".clear($invt2['Name'])."</span></td>
				</tr>";
				}
			}
		  }
		//Check For Reward ------------------------------------------------------------------------------------------------------------
		if($rbInfo['Rb_reward']=='-')
		{
		$RewardStatus="";
		}
		else{
		$rewInfo=explode(";", $rbInfo['Rb_reward']);
		$RewardStatus="<tr $sucCls>
				<td> $SuccessImg Rebirth Reward : <span class='text-success'>".ItemName($rewInfo[0])." </span></td>
				<td> </td>
				</tr>";
		}
		//Check for QestInfo---------------------------------------------------------------------------------------------------
		if($rbInfo['Quest_info']=='-')
		{
		$QuestStatus="";
		}
		else{
		$QuestStatus="<tr class=' info'>
				<td> $InfoImg Quest Info : <span class='text-info'>$rbInfo[Quest_info] </span></td>
				<td> </td>
				</tr>";
		}
		//Check For ItemInfo-------------------------------------------------------------------------------------------------
		if($rbInfo['Item_info']=='-')
		{
		$ItemStatus="";
		}
		else{
		$ItemStatus="<tr class=' info'>
				<td> $InfoImg Item Info : <span class='text-info'>$rbInfo[Item_info] </span></td>
				<td> </td>
				</tr>";
		}
		//Chech For Coin Requiment----------------------------------------------------------------------------------------
		if($rbInfo['Coin_req']=='0')
		{
		$CoinStatus="";
		}
		else{
			if($actInfo['coins']>=$rbInfo['Coin_req']){
				$CoinStatus="<tr $sucCls>
				<td> $SuccessImg Coins Required : <span class='text-error'>$rbInfo[Coin_req] </span></td>
				<td> Your Coins :<span $errTxt > $actInfo[coins]</span></td>
				</tr>";
			}else{
				$CoinStatus="<tr $errCls>
				<td> $errImg Coins Required : <span class='text-error'>$rbInfo[Coin_req] </span></td>
				<td> Your Coins : <span $errTxt >$actInfo[coins] </span></td>
				</tr>";
			}
		}
		//Check for Gold req----------------------------------------------------------------------------------------------
		if($rbInfo['Gold_req']=='0')
		{
		$GoldStatus="";
		}
		else{
			if($actInfo['gold']>=$rbInfo['Gold_req']){
				$GoldStatus="<tr $sucCls>
				<td> $SuccessImg Gold Coins Required : <span class='text-error'>$rbInfo[Gold_req] </span></td>
				<td> Your Gold Coins :<span $errTxt > $actInfo[gold]</span></td>
				</tr>";
			}else{
				$GoldStatus="<tr $errCls>
				<td> $errImg Gold Coins Required : <span class='text-error'>$rbInfo[Gold_req] </span></td>
				<td> Your Gold Coins : <span $errTxt >$actInfo[gold] </span></td>
				</tr>";
			}
		}
		//Check for coin req----------------------------------------------------------------------------------------------
		if($rbInfo['Coin_req']=='0')
		{
		$CoinStatus="";
		}
		else{
			if($actInfo['coins']>=$rbInfo['Coin_req']){
				$CoinStatus="<tr $sucCls>
				<td> $SuccessImg Coins Required : <span class='text-error'>$rbInfo[Coin_req] </span></td>
				<td> Your Coins :<span $errTxt > $actInfo[coins]</span></td>
				</tr>";
			}else{
				$CoinStatus="<tr $errCls>
				<td> $errImg Coins Required : <span class='text-error'>$rbInfo[Coin_req] </span></td>
				<td> Your Coins : <span $errTxt >$actInfo[coins] </span></td>
				</tr>";
			}
		}
		//Check For Online Point Req -------------------------------------------------------------------------------------
		if($rbInfo['OP_req']=='0')
		{
		$OpStatus="";
		}
		else{
			if($charInfo['op']>=$rbInfo['OP_req']){
				$OpStatus="<tr $sucCls>
				<td> $SuccessImg Online Point Required : <span class='text-error'>$rbInfo[OP_req] </span></td>
				<td> Your Online Point :<span $errTxt > $charInfo[op]</span></td>
				</tr>";
			}else{
				$OpStatus="<tr $errCls>
				<td> $errImg Online Point Required : <span class='text-error'>$rbInfo[OP_req] </span></td>
				<td> Your Online Point : <span $errTxt >$charInfo[op] </span></td>
				</tr>";
			}
		}

		//Check for Active Quest details ------------------------------------------------------------------------------------------
		include('../inc/m_body_char.php');
		$charquest = explode(";",$CQUEST[1]);
		$charquest1="";
		
		if($charquest[0]==65535){
			$Img=$SuccessImg;
			$Stats='No Active Quest found.';
			$questTxt=$sucTxt;
			$questClass=$sucCls;
		}
		else{			
			$Img=$errImg;
			$Stats='Active Quest in Progress<br>Quit or finish quest to continue.';
			$err[]='1';
			$questTxt=$errTxt;
			$questClass=$errCls;
		}

		$charqueststatus="<tr $questClass>
		                 <td> $Img Character Quest Status Required:   <span class='text-error' >No Active Quests</span></td>
		                 <td>Your Status : <span $questTxt > $Stats </span></td>
		               </tr>";

		//Processing End here---------------------------------------------------------------------------------------------------------------------
		echo "<center><h2>$char Rebirth Details </h2>";
		echo "<div style='font-size:18px'>";
		echo "<div class='alert'>
		   <strong>Current RB : </strong>$rebirth<br>
		  <strong>Next RB : </strong>$newRb<br>
		</div>";
		echo "<h4>Criteria for Rebirth : $newRb</h4><br><table class='table table-striped'>
		  <thead>
		             <tr>
		                  
		                  <th style='text-align:center' width='50%'>Rebirth Requirmet</th>
		                  <th style='text-align:center' width='50%'>Your Stats</th>
		                  
		                </tr>
		              </thead>
		                <tbody>
		                $rbLevelStatus
		                $WzStatus
		                $CoinStatus
		                $GoldStatus
		                $OpStatus
		                $ItmStatus
		                $ItemStatus
		                $onlineStatus
		                $RewardStatus
		                $QuestStatus
		                $charqueststatus
		              </tbody>
		</table>
		</center>";

		//Dissable or Enable the RB Button
		if(empty($err)){
		echo '<div class="form-actions" align="center">
		<input class="btn btn-success btn-large" align="center" type="submit" value="Take Rebirth" name="R1" onclick="disable()" >
		</div>';
		}
		else{
		echo '<div class="form-actions" align="center">
		<input class="btn btn-success btn-large" align="center" type="submit" value="Take Rebirth" name="R1" onclick="disable()" disabled="disabled" >
		</div>';
		}

		echo "</div>";
	}
	}
	else{
echo "<div class='alert alert-error'>
		   <h2>Please Select Atleast one Character !!
		</h2></div>";
	}
}

?>

 


