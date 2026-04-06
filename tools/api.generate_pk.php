    <?php
    include '../inc/config.php';
    include '../inc/secondary_functions.php';
    //include '../inc/report_pk_function.php';
    //Report all PHP errors (see changelog)
error_reporting(E_ALL);


// Same as error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

    if(1){
    try
            {
                //echo $_GET['LSEh'];
                $player=antisql(htmlspecialchars_decode($_GET['player']));

   $sql = "SELECT top 100 * FROM pvplog WHERE (killer='$player' or victim='$player') and fake!=1 ORDER BY pvplog.sr_no DESC";
$rs = odbc_exec($con,$sql);
$i=1;
while (odbc_fetch_row($rs))
{
  $killer = odbc_result($rs, "killer");
  $k_lv = odbc_result($rs, "killer_lv");
  $k_rb = odbc_result($rs, "killer_rb");
  $k_rs = odbc_result($rs, "killer_reset");
  $victim = odbc_result($rs, "victim");
  $v_lv = odbc_result($rs, "victim_lv");
  $v_rb = odbc_result($rs, "victim_rb");
  $v_rs = odbc_result($rs, "victim_reset");
  $killtm = odbc_result($rs,"killtime");
  $sr_no=odbc_result($rs, 'sr_no');
  $killerInfo=playerInfo($killer,14,14);
  $victimInfo=playerInfo($victim,14,14);




if($killer=="$player")
  { $killers="<i><b style='text-decoration:none;color:#000000'>".$killerInfo['StyledName']."</b></i>";}
else
  { $killers=$killerInfo['StyledName'];}
if($victim=="$player")
  { $victims="<i><b style='text-decoration:none;color:#000000'>".$victimInfo['StyledName']."</b></i>";}
else{$victims=$victimInfo['StyledName'];}





        $status=checkReportPKStatus($sr_no);
           //$status=""; 
 
 if(CheckvalidUser()||$_SESSION['grade'] == "BAN") 
 {
     $array=array($i,"$killerInfo[NationImage]<a href='http://$_SERVER[SERVER_NAME]/player/$killer'>$killers</a>","(RS$k_rs,RB$k_rb,Lvl$k_lv)","$victimInfo[NationImage]<a href='http://$_SERVER[SERVER_NAME]/player/$victim'>$victims</a>","(RS$v_rs,RB$v_rb,Lvl$v_lv)",$killtm,$status);
 }
    else
 {
     $array=array($i,"$killerInfo[NationImage]<a href='http://$_SERVER[SERVER_NAME]/player/$killer'>$killers</a>","(RS$k_rs,RB$k_rb,Lvl$k_lv)","$victimInfo[NationImage]<a href='http://$_SERVER[SERVER_NAME]/player/$victim'>$victims</a>","(RS$v_rs,RB$v_rb,Lvl$v_lv)",$killtm);

 }
           

            $data[$i-1]=array_values($array);
        
            $i++;
        }
        echo json_encode(array('data'=>array_values($data)));
    } catch (PDOException $e) {
                die($e->getMessage());
            }
        }