<table class="table table-hover">
              <thead>
                <tr>
                  <th>Sr.</th>
                  <th>Killer</th>
                  <th>Killer Details</th>
                  <th>Victim</th>
                  <th>Victim Details</th>
                  <th>Kill Time</th>
                </tr>
              </thead>
              <tbody>
                
              
<?php 
include '../inc/config.php';
include '../inc/secondary_functions.php';
ini_set( "display_errors", 0);
$sql = "SELECT TOP 25 pvplog.killer, pvplog.killer_lv, pvplog.killer_rb,pvplog.killer_reset, pvplog.victim, pvplog.victim_lv, pvplog.victim_rb, pvplog.victim_reset, pvplog.killtime FROM pvplog ORDER BY pvplog.sr_no DESC";
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
  $killerInfo=playerInfo($killer,14,14);
  $victimInfo=playerInfo($victim,14,14);

echo "<tr><td>$i</td><td >";
if($killer=="$killer")
  { $killers="<b style='text-decoration:none;color:#000000'>".$killerInfo['StyledName']."</b>";}
else
  { $killers=$killerInfo['StyledName'];}
if($victim=="$victim")
  { $victims="<b style='text-decoration:none;color:#000000'>".$victimInfo['StyledName']."</b>";}
else{$victims=$victimInfo['StyledName'];}

echo "$killerInfo[NationImage]<a href='http://$_SERVER[SERVER_NAME]/player/$killer'>$killers</a></td><td>(RS$k_rs,RB$k_rb,Lvl$k_lv)</td><td> $victimInfo[NationImage]<a href='http://$_SERVER[SERVER_NAME]/player/$victim'>$victims</a></td><td>(RS$v_rs,RB$v_rb,Lvl$v_lv)</td><td>$killtm</td></tr>";
$i++;
};
?>
</tbody>
<?php odbc_close($con);odbc_close($con2); ?>
            </table>