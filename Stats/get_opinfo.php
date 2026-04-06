<?php
include '../inc/config.php';
include '../inc/secondary_functions.php';
 //ini_set( "display_errors", 0);
 $response = array('op' => '','enable' => '','slots'=>'');

if(isset($_POST['char']))
{
foreach($_POST as $key => $value) {
	$data[$key] = antisql($value); // post variables are filtered
}
$op="";
$char=$data['char'];
$slot="";
if($char!="x"){
$query1 = odbc_exec($con,"SELECT * FROM charac0 WHERE c_id='$char' ");
while ($sup = odbc_fetch_array($query1))
	{
include('../inc/m_body_char.php');
$sr = explode(";",$INVEN[1]);
$result = array();
$source = array_values($sr);
$count = count($source);
for($i = 3; $i < $count; $i +=4) {
    $result[] = $source[$i]+1;
}

$array2 = array( "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29" ,"30");
$result1 = array_diff($array2,$result);
sort($result);
$slot= "";
$j=0;
foreach($result1 as $value1) {

  $slot.= '<option value="'.($value1-1).'">'.$value1.'</option>';
  $j++;
  }
}
$en=0;
$on=0;
$getchars = odbc_exec($con,"SELECT * FROM charac0 WHERE c_id = '$char' AND c_status = 'A'");
while (odbc_fetch_row($getchars))
	{
		$online = odbc_result($getchars, "op");
		$on=$on+$online;
	}
if($on>5000){
$en=1;
}

if($en=='1'){
$op="<div class='alert alert-info'>Total ONLINE POINTS of $char is : $on </div> ";
}else{
$slot= "<option selected='selected' value=\"x\">--Select Invt--</option>";
$op="<div class='alert alert-error'><h4> $char have $on online points but to convert online points to OP1 it requires 5000 online points!!</h4> </div>";
}
}
else{
$op="";
$slot= "<option selected='selected' value=\"x\">--Select Invt--</option>";
}

$response['op'] = $op;
$response['enable'] = $en;
$response['slots'] = $slot;
}
echo json_encode($response);
exit(0);
?>

 


