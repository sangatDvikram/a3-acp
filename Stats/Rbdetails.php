<?php
include '../inc/config.php';
include '../inc/secondary_functions.php';
if(isset($_POST['Rb']))
{
foreach($_POST as $key => $value) {
	$data[$key] = antisql($value); // post variables are filtered
}
$msg = array();
$OnlineErr = array();
$err=array();
$pre = array();
$rb=$data['Rb'];
if($rb!='x'){
	echo "<div class='well' style='padding:10px'>";
		echo "";
		$rbquerry = odbc_exec($con2,"SELECT * FROM rbinfo WHERE Rb = '$rb'");
		$rbInfo = odbc_fetch_array($rbquerry);
		//Check Rb level-------------------------------------------------------------------------------------------------------------------
		
		$rbLevelStatus=" $lvlImg Level Required : <span class='text-error' >$rbInfo[Level_req]</span> <br>";
		                 

		//Check Rb WZ------------------------------------------------------------------------------------------------------------------------
		$wz=$rbInfo['Wz_req']." Wz";
		if($rbInfo['Wz_req']>999999){
		$wz=($rbInfo['Wz_req']/1000000)." Mil";
		}
		if ($rbInfo['Wz_req']>999999999) {
			$wz=($rbInfo['Wz_req']/1000000000)." Bil";
		}
		$WzStatus=" Wz Required : <span class='text-error' >$wz </span>  <br>";
		//Check For Item Requirment------------------------------------------------------------------------------------------------------------
		if($rbInfo['Item_req']=='none')
		{
		$ItmStatus="  Item Required : <span class='text-error'>$rbInfo[Item_req]</span>  <br>";
		}
		else{
				//This is for Single Item----------------------------------------------------------------------------
			if($rbInfo['Item_req_count']==1){
				$Info=itemInfo($rbInfo['Item_req']);
				$ItmStatus=" Item Required : <span class='text-error'> $Info[Name] <img class='thumbnail' src='$Info[Image]'> </span> <br>";
			}
			//This is for 2 items---------------------------------------------------------------------------
			elseif($rbInfo['Item_req_count']==2){

				$reqItem=explode(",", $rbInfo['Item_req']);
	
				$Info1=itemInfo($reqItem[0]);
				$Info2=itemInfo($reqItem[1]);
					$ItmStatus="Item Required : <span class='text-error'> $Info1[Name] <img class='thumbnail' src='$Info1[Image]'>  and  $Info2[Name] <img class='thumbnail' src='$Info2[Image]'> </span><br>";

			}
		  }
		//Check For Reward ------------------------------------------------------------------------------------------------------------
		if($rbInfo['Rb_reward']=='-')
		{
		$RewardStatus="";
		}
		else{
			$rewInfo=explode(";", $rbInfo['Rb_reward']);
		$Info=itemInfo($rewInfo[0]);
		$RewardStatus=" Rebirth Reward : <span class='text-success'>$Info[Name] <img class='thumbnail' src='$Info[Image]'>  </span>  <br>";
		}
		//Check for QestInfo---------------------------------------------------------------------------------------------------
		if($rbInfo['Quest_info']=='-')
		{
		$QuestStatus="";
		}
		else{$QuestStatus="Quest Info : <span class='text-info'>$rbInfo[Quest_info] </span> <br>";}
		//Check For ItemInfo-------------------------------------------------------------------------------------------------
		if($rbInfo['Item_info']=='-')
		{
		$ItemStatus="";
		}
		else{$ItemStatus=" Item Info : <span class='text-info'>$rbInfo[Item_info] </span> <br>";}
		//Chech For Coin Requiment----------------------------------------------------------------------------------------
		if($rbInfo['Coin_req']=='0')
		{
		$CoinStatus="";
		}
		else{$CoinStatus="Coins Required : <span class='text-error'>$rbInfo[Coin_req] </span> <br>";}
		//Check for Gold req----------------------------------------------------------------------------------------------
		if($rbInfo['Gold_req']=='0')
		{
		$GoldStatus="";
		}
		else{ $GoldStatus="Gold Coin Required : <span class='text-error'>$rbInfo[Gold_req] </span> <br>";}
		//Check For Online Point Req -------------------------------------------------------------------------------------
		if($rbInfo['OP_req']=='0')
		{
		$OpStatus="";
		}
		else{
				$OpStatus="Online Point Required : <span class='text-error'>$rbInfo[OP_req]<br> </span>";
		}
		//Processing End here---------------------------------------------------------------------------------------------------------------------
		echo " <div class=\"row-fluid \"> <div class='span7' style='Font-size:18px'><h4>Rebirth $rb Details</h4>
		 				$rbLevelStatus
		                $WzStatus
		                $CoinStatus
		                $GoldStatus
		                $OpStatus
		                $ItmStatus
		                $ItemStatus
		                $onlineStatus
		                $RewardStatus
		                $QuestStatus </div><div class='span5' style='Font-size:18px'>";
if($rbInfo['Item_req']!='none')
		{

			//This is for Single Item----------------------------------------------------------------------------
			if($rbInfo['Item_req_count']==1){
					$Info=itemInfo($rbInfo['Item_req']);
					$iteminfos = odbc_exec($con2,"SELECT * FROM craftingtable WHERE result = '$rbInfo[Item_req]'");
					$itm = odbc_fetch_array($iteminfos);
					$num=odbc_num_rows($iteminfos);
					$frune=itemInfo($itm['firstrune']);
					$srune=itemInfo($itm['secondrune']);
					$trune=itemInfo($itm['thirdrune']);
					$first=itemInfo($itm['first']);
					$second=itemInfo($itm['second']);
					$third=itemInfo($itm['thrid']);
					$fourth=itemInfo($itm['fourth']);
					$fifth=itemInfo($itm['fifth']);
					$sixth=itemInfo($itm['sixth']);
					$final=itemInfo($itm['final']);
					$res=itemInfo($itm['result']);
					$sucess=$itm['sucess'];
if($num!=0){
 echo "
<h4>Crafting Info for $Info[Name]: </h4>
<table cellspacing='5' cellpadding='5'>
<tr> 
<td class='tip2'><a href='/Guide/Crafting/item=".strTohex($itm['firstrune'])."'><img style='cursor:pointer' width='32px' height='64px' src='$frune[Image]' class='thumbnail scaler' alt='$frune[Name]' title='$frune[Name]'></a><span>$frune[Name]</span></td>
<td class='tip2'><a href='/Guide/Crafting/item=".strTohex($itm['secondrune'])."'><img style='cursor:pointer' width='32px' height='64px' src='$srune[Image]' class='thumbnail scaler' alt='$srune[Name]' title='$srune[Name]'></a><span>$srune[Name]</span></td>
<td class='tip2'><a href='/Guide/Crafting/item=".strTohex($itm['thirdrune'])."'><img style='cursor:pointer' width='32px' height='64px' src='$trune[Image]' class='thumbnail scaler' alt='$trune[Name]' title='$trune[Name]'></a><span>$trune[Name]</span></td>
</tr>
<tr>
<td class='tip2'><a href='/Guide/Crafting/item=".strTohex($itm['first'])."'><img style='cursor:pointer' width='32px' height='64px' src='$first[Image]' class='thumbnail scaler' alt='$first[Name]' title='$first[Name]'></a><span>$first[Name]</span></td>
<td class='tip2'><a href='/Guide/Crafting/item=".strTohex($itm['second'])."'><img style='cursor:pointer' width='32px' height='64px' src='$second[Image]' class='thumbnail scaler' alt='$second[Name]' title='$second[Name]'></a><span>$second[Name]</span></td>
<td class='tip2'><a href='/Guide/Crafting/item=".strTohex($itm['thrid'])."'><img style='cursor:pointer' width='32px' height='64px' src='$third[Image]' class='thumbnail scaler' alt='$third[Name]' title='$third[Name]'></a><span>$third[Name]</span></td>
</tr>
<tr>
<td class='tip2'><a href='/Guide/Crafting/item=".strTohex($itm['fourth'])."'><img style='cursor:pointer' width='32px' height='64px' src='$fourth[Image]' class='thumbnail scaler' alt='$fourth[Name]' title='$fourth[Name]'></a><span>$fourth[Name]</span></td>
<td class='tip2'><a href='/Guide/Crafting/item=".strTohex($itm['fifth'])."'><img style='cursor:pointer' width='32px' height='64px' src='$fifth[Image]' class='thumbnail scaler' alt='$fifth[Name]' title='$fifth[Name]'></a><span>$fifth[Name]</span></td>
<td class='tip2'><a href='/Guide/Crafting/item=".strTohex($itm['sixth'])."'><img style='cursor:pointer' width='32px' height='64px' src='$sixth[Image]' class='thumbnail scaler' alt='$sixth[Name]' title='$sixth[Name]'></a><span>$sixth[Name]</span></td>
</tr>
<tr>
<td class='tip2'></td>
<td class='tip2'><a href='/Guide/Crafting/item=".strTohex($itm['final'])."'><img style='cursor:pointer' width='32px' height='64px' src='$final[Image]' class='thumbnail scaler' alt='$final[Name]' title='$final[Name]'></a><span>$final[Name]</span></td>
<td class='tip2'></td>
</tr>

		 </table>
		 <h4>Final Result :  $res[Name] <img style='cursor:pointer' class='scaler' src='$res[Image]' title=' $res[Name] '> </h4>
		 <h4>Success Rate : <span class='text-success'> $sucess % </span> </h4>		
		";
	}
			}
			elseif($rbInfo['Item_req_count']==2){

				$reqItem=explode(",", $rbInfo['Item_req']);
	
				$Info1=itemInfo($reqItem[0]);
				$Info2=itemInfo($reqItem[1]);
					$iteminfos = odbc_exec($con2,"SELECT * FROM craftingtable WHERE result = '$reqItem[0]'");
					$itm = odbc_fetch_array($iteminfos);
					$num=odbc_num_rows($iteminfos);
					$frune=itemInfo($itm['firstrune']);
					$srune=itemInfo($itm['secondrune']);
					$trune=itemInfo($itm['thirdrune']);
					$first=itemInfo($itm['first']);
					$second=itemInfo($itm['second']);
					$third=itemInfo($itm['thrid']);
					$fourth=itemInfo($itm['fourth']);
					$fifth=itemInfo($itm['fifth']);
					$sixth=itemInfo($itm['sixth']);
					$final=itemInfo($itm['final']);
					$res=itemInfo($itm['result']);
					$sucess=$itm['sucess'];
					if($num!=0){

 echo "
<h4>Crafting Info for $Info[Name]: </h4>
<table cellspacing='5' cellpadding='5'>
<tr>
<td class='tip2'><a href='/Guide/Crafting/item=".strTohex($itm['firstrune'])."'><img style='cursor:pointer' width='32px' height='64px' src='$frune[Image]' class='thumbnail scaler' alt='$frune[Name]' title='$frune[Name]'></a><span>$frune[Name]</span></td>
<td class='tip2'><a href='/Guide/Crafting/item=".strTohex($itm['secondrune'])."'><img style='cursor:pointer' width='32px' height='64px' src='$srune[Image]' class='thumbnail scaler' alt='$srune[Name]' title='$srune[Name]'></a><span>$srune[Name]</span></td>
<td class='tip2'><a href='/Guide/Crafting/item=".strTohex($itm['thirdrune'])."'><img style='cursor:pointer' width='32px' height='64px' src='$trune[Image]' class='thumbnail scaler' alt='$trune[Name]' title='$trune[Name]'></a><span>$trune[Name]</span></td>
</tr>
<tr>
<td class='tip2'><a href='/Guide/Crafting/item=".strTohex($itm['first'])."'><img style='cursor:pointer' width='32px' height='64px' src='$first[Image]' class='thumbnail scaler' alt='$first[Name]' title='$first[Name]'></a><span>$first[Name]</span></td>
<td class='tip2'><a href='/Guide/Crafting/item=".strTohex($itm['second'])."'><img style='cursor:pointer' width='32px' height='64px' src='$second[Image]' class='thumbnail scaler' alt='$second[Name]' title='$second[Name]'></a><span>$second[Name]</span></td>
<td class='tip2'><a href='/Guide/Crafting/item=".strTohex($itm['thrid'])."'><img style='cursor:pointer' width='32px' height='64px' src='$third[Image]' class='thumbnail scaler' alt='$third[Name]' title='$third[Name]'></a><span>$third[Name]</span></td>
</tr>
<tr>
<td class='tip2'><a href='/Guide/Crafting/item=".strTohex($itm['fourth'])."'><img style='cursor:pointer' width='32px' height='64px' src='$fourth[Image]' class='thumbnail scaler' alt='$fourth[Name]' title='$fourth[Name]'></a><span>$fourth[Name]</span></td>
<td class='tip2'><a href='/Guide/Crafting/item=".strTohex($itm['fifth'])."'><img style='cursor:pointer' width='32px' height='64px' src='$fifth[Image]' class='thumbnail scaler' alt='$fifth[Name]' title='$fifth[Name]'></a><span>$fifth[Name]</span></td>
<td class='tip2'><a href='/Guide/Crafting/item=".strTohex($itm['sixth'])."'><img style='cursor:pointer' width='32px' height='64px' src='$sixth[Image]' class='thumbnail scaler' alt='$sixth[Name]' title='$sixth[Name]'></a><span>$sixth[Name]</span></td>
</tr>
<tr>
<td class='tip2'></td>
<td class='tip2'><a href='/Guide/Crafting/item=".strTohex($itm['final'])."'><img style='cursor:pointer' width='32px' height='64px' src='$final[Image]' class='thumbnail scaler' alt='$final[Name]' title='$final[Name]'></a><span>$final[Name]</span></td>
<td class='tip2'></td>
</tr>


		 </table>
		 <h4>Final Result :  $res[Name] <img style='cursor:pointer' src='$res[Image]' title=' $res[Name] '> </h4>
		 <h4>Success Rate : <span class='text-success'> $sucess % </span> </h4>		
		";
			}		
			$iteminfos = odbc_exec($con2,"SELECT * FROM craftingtable WHERE result = '$reqItem[1]'");
					$itm = odbc_fetch_array($iteminfos);
					$num=odbc_num_rows($iteminfos);
					$frune=itemInfo($itm['firstrune']);
					$srune=itemInfo($itm['secondrune']);
					$trune=itemInfo($itm['thirdrune']);
					$first=itemInfo($itm['first']);
					$second=itemInfo($itm['second']);
					$third=itemInfo($itm['thrid']);
					$fourth=itemInfo($itm['fourth']);
					$fifth=itemInfo($itm['fifth']);
					$sixth=itemInfo($itm['sixth']);
					$final=itemInfo($itm['final']);
					$res=itemInfo($itm['result']);
					$sucess=$itm['sucess'];
if($num!=0){
echo "
<h4>Crafting Info for $Info[Name]: </h4>
<table cellspacing='5' cellpadding='5'>
<tr>
<td class='tip2'><a href='/Guide/Crafting/item=".strTohex($itm['firstrune'])."'><img style='cursor:pointer' width='32px' height='64px' src='$frune[Image]' class='thumbnail scaler' alt='$frune[Name]' title='$frune[Name]'></a><span>$frune[Name]</span></td>
<td class='tip2'><a href='/Guide/Crafting/item=".strTohex($itm['secondrune'])."'><img style='cursor:pointer' width='32px' height='64px' src='$srune[Image]' class='thumbnail scaler' alt='$srune[Name]' title='$srune[Name]'></a><span>$srune[Name]</span></td>
<td class='tip2'><a href='/Guide/Crafting/item=".strTohex($itm['thirdrune'])."'><img style='cursor:pointer' width='32px' height='64px' src='$trune[Image]' class='thumbnail scaler' alt='$trune[Name]' title='$trune[Name]'></a><span>$trune[Name]</span></td>
</tr>
<tr>
<td class='tip2'><a href='/Guide/Crafting/item=".strTohex($itm['first'])."'><img style='cursor:pointer' width='32px' height='64px' src='$first[Image]' class='thumbnail scaler' alt='$first[Name]' title='$first[Name]'></a><span>$first[Name]</span></td>
<td class='tip2'><a href='/Guide/Crafting/item=".strTohex($itm['second'])."'><img style='cursor:pointer' width='32px' height='64px' src='$second[Image]' class='thumbnail scaler' alt='$second[Name]' title='$second[Name]'></a><span>$second[Name]</span></td>
<td class='tip2'><a href='/Guide/Crafting/item=".strTohex($itm['thrid'])."'><img style='cursor:pointer' width='32px' height='64px' src='$third[Image]' class='thumbnail scaler' alt='$third[Name]' title='$third[Name]'></a><span>$third[Name]</span></td>
</tr>
<tr>
<td class='tip2'><a href='/Guide/Crafting/item=".strTohex($itm['fourth'])."'><img style='cursor:pointer' width='32px' height='64px' src='$fourth[Image]' class='thumbnail scaler' alt='$fourth[Name]' title='$fourth[Name]'></a><span>$fourth[Name]</span></td>
<td class='tip2'><a href='/Guide/Crafting/item=".strTohex($itm['fifth'])."'><img style='cursor:pointer' width='32px' height='64px' src='$fifth[Image]' class='thumbnail scaler' alt='$fifth[Name]' title='$fifth[Name]'></a><span>$fifth[Name]</span></td>
<td class='tip2'><a href='/Guide/Crafting/item=".strTohex($itm['sixth'])."'><img style='cursor:pointer' width='32px' height='64px' src='$sixth[Image]' class='thumbnail scaler' alt='$sixth[Name]' title='$sixth[Name]'></a><span>$sixth[Name]</span></td>
</tr>
<tr>
<td class='tip2'></td>
<td class='tip2'><a href='/Guide/Crafting/item=".strTohex($itm['final'])."'><img style='cursor:pointer' width='32px' height='64px' src='$final[Image]' class='thumbnail scaler' alt='$final[Name]' title='$final[Name]'></a><span>$final[Name]</span></td>
<td class='tip2'></td>
</tr>

		 </table>
		 <h4>Final Result :  $res[Name] <img style='cursor:pointer' src='$res[Image]' title=' $res[Name] '> </h4>
		 <h4>Success Rate : <span class='text-success'> $sucess % </span> </h4>		
		";
}

			}
   
}
		      echo"</div></div></div>";
	}
	else{
echo "<div class='alert alert-error'>
		   <h2>Please Select Atleast One Rebirth To Get Information About It !!
		</h2></div>";
	}
}

?>

 


