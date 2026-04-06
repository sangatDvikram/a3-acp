<?php
//initializing string
$sqlstring1 = "SELECT c_headera FROM charac0 WHERE c_id = '$char'";
$rsstring1 = odbc_exec($con,$sqlstring1);
$charstring1 = odbc_result($rsstring1,'c_headera');

$temp1 = explode(";",$charstring1);

$STR = $temp1[0];
$INT = $temp1[1];
$DEX = $temp1[2];
$VITAL = $temp1[3];
$MANA = $temp1[4];
$RSTAT = $temp1[5];
$HP = $temp1[6];
$MP = $temp1[7];
$HPLEFT = $temp1[8];
$MPLEFT = $temp1[9];

?>