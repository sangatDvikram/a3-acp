<table class="table table-hover">
              <thead>
                <tr>
                  <th>Sr.</th>
                  <th>Name</th>
                  <th>Class</th>
                  <th>Level</th>
                  <th>Rebirth</th>
                  <th>Rank</th>
                  <th>Last Login</th>
                  <th>Players Referred</th>
                </tr>
              </thead>
              <tbody>
                
              
<?php 
include '../inc/config.php';
include '../inc/secondary_functions.php';
ini_set( "display_errors", 0);
$sql = "SELECT TOP 25 charac0.c_id, charac0.rb, charac0.d_udate,charac0.pnline, charac0.c_sheaderc, charac0.reset, charac0.c_sheaderb FROM charac0 INNER JOIN account ON charac0.c_sheadera = account.c_id WHERE (charac0.c_status <> 'X') AND (account.acc_status <> 'Admin 1') AND (account.acc_status <> 'Admin') AND (account.c_status = 'A') AND (account.acc_status <> 'GM') ORDER BY  charac0.reset DESC, ABS(charac0.rb) DESC, ABS(charac0.c_sheaderc) DESC, charac0.d_udate DESC, charac0.c_id";
$rs = odbc_exec($con,$sql);
$i=1;
while (odbc_fetch_row($rs))
{
	$heroes2 = odbc_result($rs, "c_id");	
	
	$playerInfo=playerInfo($heroes2,14,14);

	
echo "<tr  style='text-align:center'><td>$i</td><td >$playerInfo[StatusImage]";

echo"$playerInfo[NationImage] <a href='http://$_SERVER[SERVER_NAME]/player/$heroes2'>$playerInfo[StyledName]</a></td><td >$playerInfo[Type]</td><td >$playerInfo[Level]</td><td >$playerInfo[Rb]</td><td>$playerInfo[Rank]</td><td align=\"center\">$playerInfo[login]</td><td>$playerInfo[Referred]</td></tr>";
$i++;
};
?>
<?php odbc_close($con);odbc_close($con2); ?>
</tbody>
            </table>