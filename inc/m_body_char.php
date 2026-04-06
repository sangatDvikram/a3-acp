<?php
//initializing string
$sqlstring="SELECT m_body FROM charac0 WHERE c_id = '$char'";
$rsstring = odbc_exec($con,$sqlstring);
$charstring = odbc_result($rsstring,'m_body');
//echo "$charstring <br>";

//explode the string
$temp = explode("\_1",$charstring);

//initialize variable for the string
$EXP = explode("=",$temp[0]);
$SKILL = explode("=",$temp[1]);
$PK = explode("=",$temp[2]);
$RTM = explode("=",$temp[3]);
$SINFO = explode("=",$temp[4]);
$WEAR = explode("=",$temp[5]);
$INVEN = explode("=",$temp[6]);
$PETINV = explode("=",$temp[7]);
$CQUEST = explode("=",$temp[8]);
$WAR = explode("=",$temp[9]);
$SQUEST = explode("=",$temp[10]);
$FAVOR = explode("=",$temp[11]);
$PSKILL = explode("=",$temp[12]);
$SKLSLT = explode("=",$temp[13]);
$CHATOPT = explode("=",$temp[14]);
$TYR = explode("=",$temp[15]);
$SKILLEX = explode("=",$temp[16]);
$SKLSLTEX = explode("=",$temp[17]);
$PETACT = explode("=",$temp[18]);
$LORE = explode("=",$temp[19]);
$LQUEST = explode("=",$temp[20]);
$RESRV0 = explode("=",$temp[21]);
$RESRV1 = explode("=",$temp[22]);
?>