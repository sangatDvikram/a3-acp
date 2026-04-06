<table class="table table-hover">
              <thead>
                <tr>
                  <th>Sr.</th>
                  <th>Name </th>
                  <th>Reputation Points</th>
                 
                </tr>
              </thead>
              <tbody>
                
              
<?php 
include '../inc/config.php';
include '../inc/secondary_functions.php';
ini_set( "display_errors", 0);
$sql = "SELECT TOP 25 * FROM Pkstats where rp < 0 ORDER BY rp ASC";
$rs = odbc_exec($con,$sql);
$i=1;
while ($player=odbc_fetch_array($rs))
{
$playerInfo=playerInfo($player['pname'],14,14);
echo "<tr><td>$i</td><td>$playerInfo[NationImage]<a href='http://$_SERVER[SERVER_NAME]/player/$player[pname]'>$playerInfo[StyledName]</a></td><td>$player[rp]</td></tr>";


$i++;
};
?>
</tbody>
<?php odbc_close($con);odbc_close($con2); ?>
            </table>