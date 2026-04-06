<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>A3 Ultimate - ACP Take Rebirth</title>
<?php include 'header-acp.php'; /*
if($_SESSION['grade'] != "Admin") {
header("Location: http://$_SERVER[SERVER_NAME]/ACP/"); }*/
page_protect();
if(isset($_POST['R1']))
{
    foreach($_POST as $key => $value) {
        $data[$key] = antisql($value); }
    $msg = array();
    $err = array();
    $pre = array();
    $char = $data['char'];
    $name=$char;
//Character info ------------------------------------------------------------------------------------
    $charquery = odbc_exec($con,"SELECT * FROM charac0 WHERE c_id = '$char' ");
    $charInfo = odbc_fetch_array($charquery);
//Account info---------------------------------------------------------------------------------------
    $actquery = odbc_exec($con,"SELECT * FROM account WHERE c_id = '$charInfo[c_sheadera]'");
    $actInfo = odbc_fetch_array($actquery);
    $rebirth=$charInfo['rb'];
    $newRb=$rebirth+1;
//Rebirth info---------------------------------------------------------------------------------------
    $rbquerry = odbc_exec($con2,"SELECT * FROM rbinfo WHERE Rb = '$newRb'");
    $rbInfo = odbc_fetch_array($rbquerry);
    if(is_online($_SESSION['username'])) { $err[] = "Please logout in game before continuing."; }
    if(isonline($char)) { $err[] = "Please logout in game before continuing."; }
    $charquery = odbc_exec($con,"SELECT * FROM charac0 WHERE c_id = '$char' and c_sheadera='$_SESSION[username]' AND c_status = 'A' ");
    $numb=odbc_num_rows($charquery);
    if($numb!=1){$err[] = "Error : Please check that you are not doing any thing stupid :) !! Because We always Love You !! ";}

    if(empty($err)) {
        if($char == "") { $err[] = "No character was selected. Please select a character and try again.";
        } else {
            $username = $_SESSION['username'];
            $sql1 = "SELECT account.c_id, account.c_headera, charac0.c_id FROM account INNER JOIN charac0 ON account.c_id = charac0.c_sheadera WHERE (account.c_id = '$username') AND (charac0.c_id = '$char')";
            $rs1 = odbc_exec($con,$sql1);
//if its return 1, then its the correct user
            $rec1 = odbc_fetch_row($rs1);
            if ($rec1 == 1)
            {
                include('inc/m_body_char.php');
                $pre[] =  "<h4>Your previous details: </h4>";
                $check_rb = $charInfo['rb'];
                $pre[] = "Current RB: ".$check_rb;
                $check_reset = $charInfo['reset'];
                $char_reset = $check_reset;
                $new=$check_reset.",RB".$check_rb;
                $pre[] = "Current Reset: ".$check_reset;
                $check_woonz = $charInfo['c_headerc'];
                $pre[] = "Current Woonz: ".$check_woonz;
                $pre[] = "Current Coins: ".$actInfo['coins'];
                $pre[] = "Current Gold: ".$actInfo['gold'];
                $pre[] = "Current Online Points: ".$charInfo['op'];
                $char_level = $charInfo['c_sheaderc'];
                $pre[] = "Current character level: ".$char_level;
                //Check Level
                if($char_level<$rbInfo['Level_req']){ $err[] = "Error : You Dont have Enough level to take Rebirth $newRb!!";  }
                //Check Coins
                if($actInfo['coins']<$rbInfo['Coin_req']){ $err[] = "Error : You Dont have Enough Eshop Coins to take Rebirth $newRb!!";  }
                //Check Online Points
                if($charInfo['op']<$rbInfo['OP_req']){ $err[] = "Error : You Dont have Enough Online points to take Rebirth $newRb!!";  }
                //Check Gold coins
                if($actInfo['gold']<$rbInfo['Gold_req']){ $err[] = "Error : You Dont have Enough Gold coins to take Rebirth $newRb!!";  }
                //Check Wz
                if($actInfo['c_sheaderc']<$rbInfo['Wz_req']){ $err[] = "Error : You Dont have Enough Wz to take Rebirth $newRb!!";  }
                //Check Inventory------------------------------------------------------------------------------------------------------------------------
                if($rbInfo['Item_req']!='none')
                {
                    //This is for 1 item---------------------------------------------------------------------------
                    if($rbInfo['Item_req_count']==1){

                        $invt = explode(";",$INVEN[1]);
                        $info=invtoption(0,$char);
                        if($invt1['Name']=='')$invt1['Name']="Empty Slot";
                        if($rbInfo['Item_req']==$info['first']){ goto exit1;}else{ $err[]="Error : You Dont have Item Required for Rebirth $newRb!!"; }
                    }
                    //This is for 2 items---------------------------------------------------------------------------
                    elseif($rbInfo['Item_req_count']==2){

                        $invt = explode(";",$INVEN[1]);
                        $reqItem=explode(",", $rbInfo['Item_req']);
                        $invt1=invtoption(0,$char);
                        $invt2=invtoption(1,$char);
                        if($reqItem[0]==$invt1['first']&&$reqItem[1]==$invt2['first']){goto exit1;}else{ $err[]="Error : You Dont have Item Required for Rebirth $newRb!!"; }
                    }
                }
                exit1:
                //------------------------------------------------------Checking End here---------------------------------
                if(empty($err)){

                    $char_rb = $rbInfo['Rb'];
                    $char_level = 1;
                    $EXP[1]= "0";
                    $check_woonz = $check_woonz - $rbInfo['Wz_req'];
                    $inventory=explode(";", $INVEN[1]);
                    $loginfo="none";
                    //Empty The Inventry Slot if there is item requirmet
                    if($rbInfo['Item_req']!='none'){

                        if($rbInfo['Item_req_count']==1){
                            global $inventory;
                            $value=0;
                            if($inventory[3]==0){
                                $loginfo=$inventory[0].";".$inventory[1].";".$inventory[4].";".$inventory[3].";";
                                //Unset first Four value;
                                unset($inventory[0]);
                                unset($inventory[1]);
                                unset($inventory[2]);
                                unset($inventory[3]);
                                $inventory = array_values($inventory);

                            }
                            else{
                                $err[]="Error : You Dont have Item Required for Rebirth $newRb!!";
                            }
                            //print_r($inventory);
                        }
                        elseif ($rbInfo['Item_req_count']==2) {
                            global $inventory;
                            $value=0;
                            //Unset first Eight value;
                            if($inventory[3]==0&&$inventory[7]==1){
                                $loginfo=$inventory[0].";".$inventory[1].";".$inventory[4].";".$inventory[3].";".$inventory[4].";".$inventory[5].";".$inventory[6].";".$inventory[7].";";
                                //Unset first Four value;
                                unset($inventory[0]);
                                unset($inventory[1]);
                                unset($inventory[2]);
                                unset($inventory[3]);
                                unset($inventory[4]);
                                unset($inventory[5]);
                                unset($inventory[6]);
                                unset($inventory[7]);
                                $inventory = array_values($inventory);}
                            else{
                                $err[]="Error : You Dont have Item Required for Rebirth $newRb!!";
                            }
                            //print_r($inventory);
                        }
                    }

                    //$inventory = array_values($inventory);
                    $count=count($inventory);
                    $newinv=implode(";", $inventory);
                    //Add Rebirth Reward if there is any :)
                    if($rbInfo['Rb_reward']!='-'){
                        if($count==0){
                            $INVEN[1]=$rbInfo['Rb_reward'];
                        }else{
                            $INVEN[1]=$newinv.";".$rbInfo['Rb_reward'];
                        }
                    }
                    
                    //Merge all things
                    $temp[6] = implode("=",$INVEN);
                    $temp[0] = implode("=",$EXP);
                    $m_body = implode("\_1",$temp);
                    //Update
                    if(empty($err)){
                        $kRs3 = odbc_exec($con,"UPDATE charac0 SET pnline = '1', c_sheaderc = '$char_level',c_headerc = '$check_woonz', rb=$char_rb, m_body = '$m_body',op=op-$rbInfo[OP_req]  WHERE c_id = '$char'");
                        $kRs31 = odbc_exec($con,"UPDATE account SET coins = coins-$rbInfo[Coin_req],gold = gold-$rbInfo[Gold_req] WHERE c_id = '$username'");
                        $kRs0 = odbc_exec($con,"SELECT reset,rb FROM charac0 WHERE c_id = '$char'");
                        $check_reset = odbc_result($kRs0,'reset');
                        $check_rb = odbc_result($kRs0,'rb');
                        $new=$check_reset.",RB".$check_rb;
                        odbc_exec($con,"UPDATE charac0 set d_restart = '$new' where c_id='$char'");
                        //Generate Log
                        @mkdir("userlogs/RBLog/".date("Y")."/".date("F")."",0755, true);
                        $logf = fopen("userlogs/RBLog/".date("Y")."/".date("F")."/".date("jS")."-".date("F")."-RBLog-log.txt", "a+");
                        fprintf($logf, "Date: %s  Account : %s User : %s Reward: %s, RB: %s, Item Used:%s Item Replaced:%s \r\n", date("d-m-Y h:i:s A"),trim($charInfo['c_sheadera']),trim($charInfo['c_id']),$rbInfo['Rb_reward'],$rbInfo['Rb'], $rbInfo['Item_req'],$loginfo );
                        fclose($logf);
                        
                        if($rbInfo['Rb']==10&&$charInfo['reset']==0){
                        rewardref($char,$username,$con);
                        }
                    }
                    else{$err[]="Error : You Dont have Item Required for Rebirth $newRb!!";
                    }
                    if(!$kRs31)
                    {
                        $err[] = "Sorry, the data could not be updated now, try again later.";
                    }
                    else
                    {
                        $msg[] = "Rebirth ".$char_rb." successful!.";
                        $lap = "UPDATE account SET d_udate = CONVERT(DATETIME, '$date', 102) WHERE (c_id = '$username')";
                        $top = odbc_exec($con, $lap);
                    }

                }
                else{

                    $err[] = "Please check that you meet all the requirements of this rebirth!";
                }
            }
        }
    }
}?><script type="text/javascript" src="/js/rbtestscript.js"></script>
<div class="container-fluid">


    <div class="row-fluid ">
        <div class="span3">
            <?php include 'side_bar.php';?>
        </div><!-- Menu -->
        <div class="span9"><!-- Main -->
            <div class="page-header" style="margin-top:0;">
                <h1>Account Control Panel: <small>Take Rebirth</small></h1></div>

            <form method="POST" action="">
                <?php
                $query1 = "SELECT charac0.c_id,rb FROM account INNER JOIN charac0 ON account.c_id = charac0.c_sheadera WHERE (charac0.c_sheadera = '$_SESSION[username]') AND (charac0.c_status = 'A') ORDER BY charac0.c_id";
                $rs1 = odbc_exec($con,$query1);
                if(odbc_num_rows($rs1) == 0)
                {
                    echo '<div class="alert alert-error" align="center">No Character was found in the account. Please create a character in game first.</div>';
                } else {
                    /*	echo '<h4 class="text-center text-error"> - IMPORTANT - </h4><br><div class="alert alert-info"><ol>
                        <li>Please logout your character before taking rebirth.</li><li> For RB 1-5 there is no need to remove items from your Inventory. Just ensure that
                    you have kept the required WZ in inventory!</li><li> If you are taking RB 6 or above which requires an item kept in your inventory, please keep the RB item in the first slot of the inventory!.</li></ol></div>
                    <hr>';*/


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

                    if(!empty($pre))  {
                        echo "<div class=\"alert alert-info\">";
                        foreach ($pre as $e) {
                            echo "$e <br>";
                        }
                        echo "</div>";
                    }

                    ?><form class="form-inline" method='POST'>
                    <fieldset id="item">
                        <legend>Select Character: <img src="/images/ajax-loader.gif" class="loader"></legend><center>
                            Character
                            <select name="char" class="char owner">

                                <option selected="selected" value="x">--Select Char--</option>
                                <?php
                                $getchars = odbc_exec($con,"SELECT * FROM charac0 WHERE c_sheadera = '$_SESSION[username]' AND c_status = 'A'");
                                while (odbc_fetch_row($getchars))
                                {
                                    $heroes1 = odbc_result($getchars, "c_id");
                                    ?>
                                    <option  value="<?php echo $heroes1; ?>"><?php echo $heroes1; ?></option>
                                <?php
                                }
                                ?>
                            </select></center>
                        <div id='main'>
                            <div id="rbdetails" style="font-family:Ubuntu"></div>
                        </div>

                    </form>
                <?php } ?>
                </table>
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