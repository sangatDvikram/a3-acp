
<?php 

if($_GET['passkey']!="khuljasimsim"){
	header("Location: http://$_SERVER[SERVER_NAME]/ACP/"); 
}

	include '../inc/config.php';
include '../inc/secondary_functions.php';
$sql = "SELECT charac0.c_id, charac0.c_sheadera, charac0.rb,account.acc_status, account.c_status, charac0.d_udate, charac0.pnline, charac0.c_sheaderc, charac0.reset, charac0.c_sheaderb FROM charac0 INNER JOIN account ON charac0.c_sheadera = account.c_id WHERE charac0.pnline = '1' ORDER BY charac0.c_id DESC";
$rs = odbc_exec($con,$sql);

$i=1;
$numb=odbc_num_rows($rs);
if($numb!=0||$numb==1){	

				echo"	<div style='background:#c2c2c2'><table class='table table-hover'>
              <thead>
                <tr>
                  <th>Sr.</th>
                  <th>Name</th>
                  <th>ID</th>
                  <th>Acc Status </th>
                  <th>Class</th>
                  <th>Level</th>
                  <th>Rebirth</th>
                  <th>Rank</th>
                  <th>Players Referred</th>
                  <th>Login time</th>
                  <th> Town </th>
                  <th> IP </th>
                </tr>
              </thead>
              <tbody></div>";
				

	while (odbc_fetch_row($rs))
	{
		$reset2 = odbc_result($rs, "reset");
		$id = odbc_result($rs, "c_sheadera");
		$online = odbc_result($rs, "pnline");
		$heroes2 = odbc_result($rs, "c_id");
		$level2 = odbc_result($rs, "c_sheaderc");
		$grade= odbc_result($rs, "acc_status");
		$lola = odbc_exec($con, "SELECT * FROM AccountInfo WHERE word='$heroes2'");
		$numrow = odbc_num_rows($lola);
		$rblevel2 = odbc_result($rs, "rb");
		$char_type = odbc_result($rs, "c_sheaderb");
		$date2 = odbc_result($rs, "d_udate");
		$quer1 = odbc_exec($con,"SELECT * from CharInfo where CharName='$heroes2'");
		$town = odbc_result($quer1, "Nation");
		$status = odbc_result($rs, "c_status");
		$quer2 = odbc_exec($con,"SELECT TOP(1) ip from iplog where charname='$heroes2' order by sr_no desc");
		$ipaddr = odbc_result($quer2, "ip");


		
		
		if ($char_type == '0')
		{
			$class = "Warrior";
		}
		else
		{
			if ($char_type == '1')
			{
				$class = "Holy Knight";
			}
			else
			{
				if ($char_type == '2')
				{
					$class = "Mage";
				}
				else
				{
					if ($char_type == '3')
					{
						$class = "Archer";
					};
				};
			};
		};
		if ($reset2 == '3')
		{
			$rank = "Emperor";
		}
		else
		{
			if ($reset2 == '2')
			{
				$rank = "King";
			}
			else
			{
				if ($reset2 == '1')
				{
					$rank = "Viscount";
				}
				else
				{
					if ($reset2 == null || $reset2 == '0')
					{
						$rank = "Ultimate Soldier";
					}
					else
					{
						if ($reset2 == '-1')
						{
							$rank = "Test Character";
						};
						
					};
				};
			};
		};
		if ($grade=="Admin"||$grade=="GM"||$grade!="Normal")
						{
							$rank = "<b>Game Master</b>";
						};
						
		if($town == "0")
		{
			$town_txt = "<span style='color:#e00000;text-align:center;'>Temoz</span>";
		}
		else if($town == "1")
		{
			$town_txt = "<span style='color:#0000e0;text-align:center;'>Quanto</span>";
		}
		else
		{
			$town_txt = "<span style='color:#007000;text-align:center;'>Unknown</span>";
		}
						
		if($grade!="Normal")
		{
			echo "<tr class='info'><td>$i</td><td >";
			if($online == 1)
			{
				echo "<img src='http://$_SERVER[SERVER_NAME]/images/status.png' title='online'>";
			}
			else
			{
				echo "<img src='http://$_SERVER[SERVER_NAME]/images/status-offline.png' title='offline'>";
			}
		echo "<b title='Game Master' style=\"background:url(../images/backround21.gif) -30px -17px repeat;z-index:6;Padding:5px;color:#FF8000;text-shadow: 0.1em 0.1em 0.2em #FE9A2E;\">".$heroes2."</b></td><td >$id</td><td >$status</td><td >$class</td><td >$level2</td><td >$rblevel2</td><td>$rank</td><td >$numrow</td><td >$date2</td><td>$town_txt</td><td>$ipaddr</td></tr>";
		}
		else if($reset2 == '2')
		{
			echo "<tr><span class='text-warning'><td>$i</td><td >";
			if($online == 1){echo "<img src='http://$_SERVER[SERVER_NAME]/images/status.png' title='online'>";}else{echo "<img src='http://$_SERVER[SERVER_NAME]/images/status-offline.png' title='offline'>";}
			echo "<b title='King' style=\"background:url(../images/backround17.gif) 0 -5px repeat;z-index:6;Padding:2px;color:#2E9AFE;text-shadow: 1px 1px 3px #58ACFA;zoom:1\">".$heroes2."</b></td><td >$id</td><td >$status</td><td >$class</td><td >$level2</td><td >$rblevel2</td><td>$rank</td><td >$numrow</td><td >$date2</td></span><td>$town_txt</td><td>$ipaddr</td></tr>";
		}
		else if($reset2 == '1')
		{
			echo "<tr><span class='text-warning'><td>$i</td><td >";
			if($online == 1){echo "<img src='http://$_SERVER[SERVER_NAME]/images/status.png' title='online'>";}else{echo "<img src='http://$_SERVER[SERVER_NAME]/images/status-offline.png' title='offline'>";}
			echo "<b title='Viscount' style=\"background:url(../images/backround7.gif) 0 -5px repeat;z-index:6;Padding:2px;color:#FE2E2E;text-shadow: 1px 1px 3px #FA5858;zoom:1\">".$heroes2."</b></td><td >$id</td><td >$status</td><td >$class</td><td >$level2</td><td >$rblevel2</td><td>$rank</td><td >$numrow</td><td >$date2</td></span><td>$town_txt</td><td>$ipaddr</td></tr>";
		}
		else
		{
			echo "<tr><td>$i</td><td >";
			if($online == 1){echo "<img src='http://$_SERVER[SERVER_NAME]/images/status.png' title='online'>";}else{echo "<img src='http://$_SERVER[SERVER_NAME]/images/status-offline.png' title='offline'>";}
			echo $heroes2."</td><td >$id</td><td >$status</td><td>$class</td><td>$level2</td><td >$rblevel2</td><td>$rank</td><td align=\"center\">$numrow</td><td >$date2</td><td>$town_txt</td><td>$ipaddr</td></tr>";
		}

	$i++;
	};

echo "</tbody>
	</table>";
}
else{echo "<div class=\"alert alert-info\" align=\"Center\">Server is under maintenance, It Will be Up Soon....!!</div>";}

?>