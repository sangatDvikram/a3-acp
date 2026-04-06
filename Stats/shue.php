<?php

function shuedatacalc($shue)
{
	$slot1= $shue[0];
	$slot3= $shue[2];
	$slot4= $shue[3];

	$info = array();
	//--------------------------- 4th Part Calculations
	array_push($info, slot3info($slot3));
	array_push($info, slot4info($slot4,$info['Lvl']));


}


function slot3info($slot3)
{
	$it = $slot3;
	$i1 = fmod($it, 2147483648);
	$j1 = $it - $i1;
	$icedef = $j1 / 2147483648;

	$i2 = fmod($i1, 1073741824);
	$j4 = $i1 - $i2;
	$iceatk = $j4 / 1073741824;

	$i3 = fmod($i2, 536870912);
	$j5 = $i2 - $i3;
	$firedef = $j5 / 536870912;

	$i4 = fmod($i3, 268435456);
	$j6 = $i3 - $i4;
	$fireatk = $j6 / 268435456;

	$i5 = fmod($i4, 4194304);
	$j7 = $i4 - $i5;
	$hp = $j7 / 4194304;

	$i6 = fmod($i5, 256);
	$j8 = $i5 - $i6;
	$exp = $j8 / 256;

	$lvl = $i6;

	if($icedef==1) { $icedef = ceil($lvl/5);} else {$icedef=0;}
	if($iceatk==1) { $iceatk = ceil($lvl/5);} else {$iceatk=0;}
	if($firedef==1) { $firedef = ceil($lvl/5);} else {$firedef=0;}
	if($fireatk==1) { $fireatk = ceil($lvl/5);} else {$fireatk=0;}	
	

	return array('IceDef'=>$icedef,'IceAtk'=>$iceatk,'FireDef'=>$firedef,'HP'=>$hp,'Exp'=>$exp,'Lvl'=>$i6);

}





function slot4info($slot4,$lvl)
{
	$it = $slot4 - 536870912;
	$i1 = fmod($it, 2147483648);
	$j1 = $it - $i1;
	$crit = $j1 / 2147483648;

	$i2 = fmod($i1, 1073741824);
	$j4 = $i1 - $i2;
	$alive = $j4 / 1073741824;

	$i3 = fmod($i2, 534773760);
	$j5 = $i2 - $i3;
	$equip = $j5 / 534773760;

	$i4 = fmod($i3, 128);
	$j6 = $i3 - $i4;
	$hunger = $j6 / 128;

	$i5 = fmod($i4, 64);
	$j7 = $i4 - $i5;
	$acexp = $j7 / 64;

	$i6 = fmod($i5, 16);
	$j8 = $i5 - $i6;
	$magatk = $j8 / 16;

	$i7 = fmod($i6, 8);
	$j9 = $i6 - $i7;
	$defence = $j9 / 8;

	$i8 = fmod($i7, 4);
	$j10 = $i7 - $i8;
	$atkpwr = $j10 / 4;

	$i9 = fmod($i8, 2);
	$j11 = $i8 - $i9;
	$deflight = $j11 / 2;

	$i10 = fmod($i9, 1);
	$j12 = $i9 - $i10;
	$atklight = $j12 / 1;

	if($crit==1) { $crit = ceil($lvl/3); } else {$crit=0;}
	if($acexp==1) { 
		if($lvl >0 && $lvl <51)
			$acexp = (floor($lvl/5)+5);
		else
			$acexp = 15;
	} else {$acexp=0;}
	if($magatk%2!=0) { $magatk =$lvl*2;} else {$magatk=0;}	
	if($defence==1) { $defence = $lvl; } else {$defence=0;}	
	if($atkpwr==1) { $atkpwr = $lvl*2;} else {$atkpwr=0;}	
	if($deflight==1) { $deflight = ceil($lvl/5);} else {$deflight=0;}	
	if($atklight==1) { $atklight = ceil($lvl/5);} else {$atklight=0;}


	return array('CritHit'=>$crit,'Alive'=>$alive,'Equip'=>$equip,'Hunger'=>$hunger,'Acqexp'=>$acexp,'MagAtk'=>$magatk,'Defence'=>$defence,'AtkPwr'=>$atkpwr,'DefLight'=>$deflight,'AtkLight'=>$atklight);

}


?>