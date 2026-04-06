<?php
include '../inc/config.php';
include '../inc/secondary_functions.php';
if(isset($_POST['char']))
{
foreach($_POST as $key => $value) {
	$data[$key] = antisql($value); // post variables are filtered
}
$msg = array();
$OnlineErr = array();
$err=array();
$pre = array();
$char=$data['char'];
if($char!='x'){

$username = $_SESSION['username'];
include_once '../inc/stat_of_char.php';
    echo "<h3>Stats of $char is as follows : </h3>";
	echo "
	<table border='0' class='table table-striped'>
	<tr>
  <td>Strength :</td>
  <td><div class='input-prepend'>
    <button class='btn add' onclick=\"add('strength');return false;\">+</button><button class='btn minus' onclick=\"minus('strength');return false;\">-</button>
    <input type='text' class='span4 strength' name='strength' readonly='readonly'  value='$STR'>
  </div></td><td rowspan='3' align='center'>Strength,<br> Dexterity and <br>Intelligence should have <br> Min 50 and Max 65535 stats</td>
  </tr>
  <tr>
  <td><lable>Dexterity :</lable></td>
  <td><div class='input-prepend'>
    <button class='btn add' onclick=\"add('Dex');return false;\">+</button><button class='btn minus' onclick=\"minus('Dex');return false;\">-</button>
    <input type='text' class='span4 Dex ' name='Dex' readonly='readonly'  value='$DEX'>
    
  </div></td>
  </tr>
  <tr><td>
  <lable>Intelligence :</lable></td>
  <td><div class='input-prepend'>
   <button class='btn add' onclick=\"add('Int');return false;\">+</button><button class='btn minus' onclick=\"minus('Int');return false;\">-</button>
    <input type='text' class='span4 Int ' name='Int' readonly='readonly'  value='$INT'>
  </div></td>
  </tr>
  <tr><td>
  <lable>Vital :</lable></td>
  <td><div class='input-prepend'>
    <button class='btn add' onclick=\"add('vitality');return false;\">+</button><button class='btn minus' onclick=\"minus('vitality');return false;\">-</button>
    <input type='text' class='span4 vitality ' name='vitality' readonly='readonly'  value='$VITAL'>
  </div></td><td rowspan='2' align='center'>Vitality and <br>Mana <br>should have <br> Min 50 and Max 15000 stats </td>
  </tr>
  <tr><td>
  <lable>Mana :</lable></td>
 <td> <div class='input-prepend'>
    <button class='btn add' onclick=\"add('Mana');return false;\">+</button><button class='btn minus' onclick=\"minus('Mana');return false;\">-</button>
    <input type='text' class='span4 Mana ' name='Mana' readonly='readonly'  value='$MANA'>
  </div></td>
  </tr>
  <tr><td>
  <lable>Remaining:</lable></td><td>
  <input type='text' class='span2 remaining' name='remaining' readonly='readonly'  value='$RSTAT'></td></tr>
  <tr><td colspan='3'>
  <input class='btn btn-primary btn-large btn-block' align='center' type='submit' value='Change Stats' name='R1' ></td></tr>
  </table>

";
		
	}
	else{
echo "<div class='alert alert-error'>
		   <h2>Please Select Atleast one Character !!
		</h2></div>";
	}
}

?>

 


