<?php 

$Itminfo=$pdo->ItemOptions($slot, $char);

$Info=invtoption($slot,$char);
$img=$Itminfo['Image'];
$name=trim(htmlentities($Itminfo['Name']));
if($name!=''){
if($Itminfo['Blessing']=='Yes'){
$bless="<span style='color:#DF3A01'>Blessing : Yes</span><br>";
}
else{
$bless='';
}
if($Itminfo['Additional']=='Yes'){
$attk="<span style='color:#04B404'>Additional Attack : Yes</span><br>";
}
else{
$attk='';
}
if($Itminfo['Blue']!='0'){
if($Itminfo['Type']=='Weapon'){$blue="<span style='color:#013ADF'>Ice Attack : $Itminfo[Blue].</span><br>";}
else if($Itminfo['Type']=='Armor'){$blue="<span style='color:#013ADF'>Ice Defence : $Itminfo[Blue].</span><br>";}
else if($Itminfo['Type']=='Boots'){$blue="<span style='color:#013ADF'>Increase in Critical Hit Evasation : $Itminfo[Blue].</span><br>";}
else if($Itminfo['Type']=='Pant'){$blue="<span style='color:#013ADF'>Increase in Accuracy : $Itminfo[Blue].</span><br>";}
else if($Itminfo['Type']=='Gloves'){$blue="<span style='color:#013ADF'>Increased in Skill Duration : ".($Itminfo['Blue']*5).".</span><br>";}
else if($Itminfo['Type']=='Helmet'){$blue="<span style='color:#013ADF'>MP Absorbtion : $Itminfo[Blue].</span><br>";}
else {$blue="<span style='color:#013ADF'>Blue option : $Itminfo[Blue].</span><br>";}

}
else{
$blue='';
}
if($Itminfo['Red']!='0'){
if($Itminfo['Type']=='Weapon'){$red="<span style='color:#DF0101'>Fire Attack : $Itminfo[Red].</span><br>";}
else if($Itminfo['Type']=='Armor'){$red="<span style='color:#DF0101'>Fire Defence : $Itminfo[Red].</span><br>";}
else if($Itminfo['Type']=='Boots'){$red="<span style='color:#DF0101'>Wz Acquistion: ".($Itminfo['Red']*5).".</span><br>";}
else if($Itminfo['Type']=='Pant'){$red="<span style='color:#DF0101'>Increase in Evasion : $Itminfo[Red].</span><br>";}
else if($Itminfo['Type']=='Gloves'){$red="<span style='color:#DF0101'>Increased in Basic Attack Damage : $Itminfo[Red].</span><br>";}
else if($Itminfo['Type']=='Helmet'){$red="<span style='color:#DF0101'>HP Absorbtion : $Itminfo[Red].</span><br>";}
else {$red="<span style='color:#DF0101'>Red option : $Itminfo[Red].</span><br>";}

}
else{
$red='';
}
if($Itminfo['Grey']!='0'){
if($Itminfo['Type']=='Weapon'){$grey="<span style='color:#848484'>Lightining Attack : $Itminfo[Grey].</span><br>";}
else if($Itminfo['Type']=='Armor'){$grey="<span style='color:#848484'>Lightining Defence : $Itminfo[Grey].</span><br>";}
else if($Itminfo['Type']=='Boots'){$grey="<span style='color:#848484'>Increase in Critical Hit Rate : $Itminfo[Grey].</span><br>";}
else if($Itminfo['Type']=='Pant'){$grey="<span style='color:#848484'>Increase in Magic Evasion : $Itminfo[Grey].</span><br>";}
else if($Itminfo['Type']=='Gloves'){$grey="<span style='color:#848484'>Increased in Skills Attack Damage : $Itminfo[Grey].</span><br>";}
else if($Itminfo['Type']=='Helmet'){$grey="<span style='color:#848484'>HP/MP Consumption: $Itminfo[Grey].</span><br>";}
else {$grey="<span style='color:#848484'>Grey option : $Itminfo[Grey].</span><br>";}

}
else{
$grey='';
}if($Itminfo['Level']!='0'){
$level="<span style='color:#3A01DF' >Level : $Itminfo[Level].</span><br>";
}
else{
$level='';
}
if($Itminfo['Mount']!='0%'){
$mount="<span style='color:#DF0174'>Mounting : $Itminfo[Mount].</span><br>";
}
else{
$mount='';
}
if($Itminfo['ItemCode']=='17'){
if($Itminfo['Count']!='0'){

$strg="<span style='color:#DF3A01'>Storage Box Item : $Itminfo[Storageitem].</span><br>";
$count="<span style='color:#3A01DF'>Count : $Itminfo[Count].</span><br>";
}
else {
$strg="";
$count="<span style='color:#3A01DF'>Count : $Itminfo[Count].</span><br>";

}
$blue="";
$red="";
$grey="";
$bless="";
$level="";
}
else{
$strg='';
$count='';
}
if($Itminfo['ItemCode']=='5'){
$attk="";
$bless="";
$blue="";
$red="";
$level="";
$grey="";
$count="<span style='color:#3A01DF'>Count : $Itminfo[scnd].</span><br>";
$strg="";
}
if($Itminfo['ItemCode']=='1134'||$Itminfo['ItemCode']=='1135'||$Itminfo['ItemCode']=='1136'){
$attk="";
$bless="";
$blue="";
$red="";
$level="";
$grey="";
$count="<span style='color:#3A01DF'>Count : $Itminfo[scnd].</span><br>";
$strg="";
}

if($Itminfo['Type']=='Extra'){
$level="";
}

$message= " $level $bless $blue $red $grey $mount $attk $strg $count ";

}?>