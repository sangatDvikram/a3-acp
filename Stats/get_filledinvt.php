<?php
include '../inc/config.php';
include '../inc/secondary_functions.php';
if(isset($_POST['char']))
{
foreach($_POST as $key => $value) {
	$data[$key] = antisql($value); // post variables are filtered
}

$char=$data['char'];


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
echo "<option selected='selected'>--Select Invt--</option>
";
$j=0;
foreach($result as $value1) {

  print '<option value="'.$j.'">'.$value1.'</option>';
  $j++;
  }
}

}

?>

 


