<?php 
$info=stroption($slot,$char);
$img=$info['Image'];
$name=trim(htmlentities($info['Name']));
if($name!=''){
if($info['Blessing']=='Yes'){
$bless="<span style='color:#DF3A01'>Blessing : Yes</span><br>";
}
else{
$bless='';
}
if($info['Additional']=='Yes'){
$attk="<span style='color:#04B404'>Additional Attack : Yes</span><br>";
}
else{
$attk='';
}
if($info['Blue']!='0'){
if($info['Type']=='Weapon'){$blue="<span style='color:#013ADF'>Ice Attack : $info[Blue].</span><br>";}
else if($info['Type']=='Armor'){$blue="<span style='color:#013ADF'>Ice Defence : $info[Blue].</span><br>";}
else if($info['Type']=='Boots'){$blue="<span style='color:#013ADF'>Increase in Critical Hit Evasation : $info[Blue].</span><br>";}
else if($info['Type']=='Pant'){$blue="<span style='color:#013ADF'>Increase in Accuracy : $info[Blue].</span><br>";}
else if($info['Type']=='Gloves'){$blue="<span style='color:#013ADF'>Increased in Skill Duration : ".($info['Blue']*5).".</span><br>";}
else if($info['Type']=='Helmet'){$blue="<span style='color:#013ADF'>MP Absorbtion : $info[Blue].</span><br>";}
else {$blue="<span style='color:#013ADF'>Blue option : $info[Blue].</span><br>";}

}
else{
$blue='';
}
if($info['Red']!='0'){
if($info['Type']=='Weapon'){$red="<span style='color:#DF0101'>Fire Attack : $info[Red].</span><br>";}
else if($info['Type']=='Armor'){$red="<span style='color:#DF0101'>Fire Defence : $info[Red].</span><br>";}
else if($info['Type']=='Boots'){$red="<span style='color:#DF0101'>Wz Acquistion: ".($info['Red']*5).".</span><br>";}
else if($info['Type']=='Pant'){$red="<span style='color:#DF0101'>Increase in Evasion : $info[Red].</span><br>";}
else if($info['Type']=='Gloves'){$red="<span style='color:#DF0101'>Increased in Basic Attack Damage : $info[Red].</span><br>";}
else if($info['Type']=='Helmet'){$red="<span style='color:#DF0101'>HP Absorbtion : $info[Red].</span><br>";}
else {$red="<span style='color:#DF0101'>Red option : $info[Red].</span><br>";}

}
else{
$red='';
}
if($info['Grey']!='0'){
if($info['Type']=='Weapon'){$grey="<span style='color:#848484'>Lightining Attack : $info[Grey].</span><br>";}
else if($info['Type']=='Armor'){$grey="<span style='color:#848484'>Lightining Defence : $info[Grey].</span><br>";}
else if($info['Type']=='Boots'){$grey="<span style='color:#848484'>Increase in Critical Hit Rate : $info[Grey].</span><br>";}
else if($info['Type']=='Pant'){$grey="<span style='color:#848484'>Increase in Magic Evasion : $info[Grey].</span><br>";}
else if($info['Type']=='Gloves'){$grey="<span style='color:#848484'>Increased in Skills Attack Damage : $info[Grey].</span><br>";}
else if($info['Type']=='Helmet'){$grey="<span style='color:#848484'>HP/MP Consumption: $info[Grey].</span><br>";}
else {$grey="<span style='color:#848484'>Grey option : $info[Grey].</span><br>";}

}
else{
$grey='';
}if($info['Level']!='0'){
$level="<span style='color:#3A01DF' >Level : $info[Level].</span><br>";
}
else{
$level='';
}
if($info['Mount']!='0%'){
$mount="<span style='color:#DF0174'>Mounting : $info[Mount].</span><br>";
}
else{
$mount='';
}
if($info['ItemNumber']=='17'){
if($info['Count']!='0'){

$strg="<span style='color:#DF3A01'>Storage Box Item : $info[StorageItem].</span><br>";
$count="<span style='color:#3A01DF'>Count : $info[Count].</span><br>";
}
else {
$strg="";
$count="<span style='color:#3A01DF'>Count : $info[Count].</span><br>";

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
if($info['ItemNumber']=='5'){
$attk="";
$bless="";
$blue="";
$red="";
$level="";
$grey="";
$count="<span style='color:#3A01DF'>Count : $info[scnd].</span><br>";
$strg="";
}
if($info['ItemNumber']=='1134'||$info['ItemNumber']=='1135'||$info['ItemNumber']=='1136'){
$attk="";
$bless="";
$blue="";
$red="";
$level="";
$grey="";
$count="<span style='color:#3A01DF'>Count : $info[scnd].</span><br>";
$strg="";
}

if($info['Type']=='Extra'){
$level="";
}

$message= " $level $bless $blue $red $grey $mount $attk $strg $count ";

}?>