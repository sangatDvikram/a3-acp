<?php 
/*
*
*
*/
//ini_set( "display_errors", 0);
$start_time = microtime(true); 

//include '../inc/config.php';
//include '../inc/secondary_functions.php';
include 'pdoclass.php';

$pdo=new PDOExamples();
//echo $pdo->asd;
//$db=$pdo->ASDConnect();
//$db2=$pdo->A3ItemEventConnect();

/*
$char="nooblol";
$sql="Select * from charac0 where c_status=:status and  c_sheadera=:acct order by NEWID()";

    $query=$db->prepare($sql);
    //Send parameters using array :D awsom thing man
    
    $params=array(':status'=>'A',':acct'=>'nooblol');
    // For Loop to bind params which is making it more secure and we aree sending &$val meance referance of that thing 
    foreach ($params as $key => &$val) {
    	
    	$query->bindParam($key, $val);
    	
    }
    //$query->bindParam(':name',$char);
    $query->execute();
    $user=$query->fetchall();
/*
	foreach ($user as $row) {
        echo  rtrim($row ['c_id']). "<br>";
      }

$arr=$db->query("Select * from charac0 where c_id='ConstanTine'") ;
foreach ($arr as $row) {
        echo  $row ['c_id']. "<br>";
      }

// ITem list 
   $code=3; 
	  $itemq="Select * From itemlist where code<:code";
      $imq=$db2->prepare($itemq);
      $imq->bindParam(":code", $code,PDO::PARAM_INT);
      $imq->execute();
      $data=$imq->fetchAll();
      foreach ($data as $result){
      	echo $result['itmname']."<br>";
      }
      $value='6144';
      $statement="SELECT * FROM itemlist WHERE code = :code";
      $query=$db2->prepare($statement);
      $query->bindParam(':code', $value,PDO::PARAM_INT);
      //$query->bindParam(':name',$char);
      $query->execute();
      $prot10=$query->fetch();
      
      	echo $prot10['image']."<br>";
     
  $new=$pdo->RArry();
  echo $new['name']."\t\t<br>";   
*/
/*
  $Itminfo=$pdo->ItemOptions(1, "ConstanTine");
  echo "Char: $Itminfo[Char]<br> Slot : $Itminfo[Slot] <br>Item: $Itminfo[ItmInfo] <br>Blessing : $Itminfo[Blessing] <br>Item Code : $Itminfo[ItemCode]<br> Name : $Itminfo[Name]<br>--------------------------------------------------------------------<br>";
  

  $Itminfo=$pdo->ItemOptions(2, "ConstanTine");
  echo "Char: $Itminfo[Char]<br> Slot : $Itminfo[Slot] <br>Item: $Itminfo[ItmInfo] <br>Item Code : $Itminfo[ItemCode]<br> Name : $Itminfo[Name]<br>--------------------------------------------------------------------<br>";
  

  $Itminfo=$pdo->ItemOptions(3, "ConstanTine");
   echo "Char: $Itminfo[Char]<br> Slot : $Itminfo[Slot] <br>Item: $Itminfo[ItmInfo] <br>Item Code : $Itminfo[ItemCode]<br> Name : $Itminfo[Name]<br>--------------------------------------------------------------------<br>";
  
  $Itminfo=$pdo->ItemOptions(4, "ConstanTine");
  echo "Char: $Itminfo[Char]<br> Slot : $Itminfo[Slot] <br>Item: $Itminfo[ItmInfo] <br>Blessing : $Itminfo[Blessing]<br>Item Code : $Itminfo[ItemCode]<br> Name : $Itminfo[Name]<br>--------------------------------------------------------------------<br>";
  
$Itminfo=$pdo->ItemOptions(5, "ConstanTine");
  echo "Char: $Itminfo[Char]<br> Slot : $Itminfo[Slot] <br>Item: $Itminfo[ItmInfo] <br>Blessing : $Itminfo[Blessing]<br>Item Code : $Itminfo[ItemCode]<br> Name : $Itminfo[Name]<br>--------------------------------------------------------------------<br>";
  
$Itminfo=$pdo->ItemOptions(6, "ConstanTine");
  echo "Char: $Itminfo[Char]<br> Slot : $Itminfo[Slot] <br>Item: $Itminfo[ItmInfo] <br>Blessing : $Itminfo[Blessing]<br>Item Code : $Itminfo[ItemCode]<br> Name : $Itminfo[Name]<br>--------------------------------------------------------------------<br>";
  


  $Itminfo=$pdo->ItemOptions(7, "ConstanTine");
   echo "Char: $Itminfo[Char]<br> Slot : $Itminfo[Slot] <br>Item: $Itminfo[ItmInfo] <br>Item Code : $Itminfo[ItemCode]<br> Name : $Itminfo[Name]<br>--------------------------------------------------------------------<br>";
   
   $Itminfo=$pdo->ItemOptions(8, "ConstanTine");
  echo "Char: $Itminfo[Char]<br> Slot : $Itminfo[Slot] <br>Item: $Itminfo[ItmInfo] <br>Blessing : $Itminfo[Blessing]<br>Item Code : $Itminfo[ItemCode]<br> Name : $Itminfo[Name]<br>--------------------------------------------------------------------<br>";
  

$Itminfo=$pdo->ItemOptions(9, "ConstanTine");
  echo "Char: $Itminfo[Char]<br> Slot : $Itminfo[Slot] <br>Item: $Itminfo[ItmInfo] <br>Blessing : $Itminfo[Blessing]<br>Item Code : $Itminfo[ItemCode]<br> Name : $Itminfo[Name]<br>--------------------------------------------------------------------<br>";
  

$Itminfo=$pdo->ItemOptions(10, "ConstanTine");
  echo "Char: $Itminfo[Char]<br> Slot : $Itminfo[Slot] <br>Item: $Itminfo[ItmInfo] <br>Blessing : $Itminfo[Blessing]<br>Item Code : $Itminfo[ItemCode]<br> Name : $Itminfo[Name]<br>--------------------------------------------------------------------<br>";
  

  $Itminfo=$pdo->ItemOptions(24, "ConstanTine");
  echo "Char: $Itminfo[Char]<br> Slot : $Itminfo[Slot] <br>Item: $Itminfo[ItmInfo] <br>Item Code : $Itminfo[ItemCode]<br> Name : $Itminfo[Name]<br>--------------------------------------------------------------------<br>";
   
  $Itminfo=$pdo->ItemOptions(29, "ConstanTine");
   echo "Char: $Itminfo[Char]<br> Slot : $Itminfo[Slot] <br>Item: $Itminfo[ItmInfo] <br>Item Code : $Itminfo[ItemCode]<br> Name : $Itminfo[Name]<br>--------------------------------------------------------------------<br>";
  
  $Itminfo=$pdo->ItemOptions(30, "ConstanTine");
  echo "Char: $Itminfo[Char]<br> Slot : $Itminfo[Slot] <br>Item: $Itminfo[ItmInfo] <br>Item Code : $Itminfo[ItemCode]<br> Name : $Itminfo[Name]<br>--------------------------------------------------------------------<br>";
   
  */

echo "Unidentified";
$result=$pdo->plainoptions(2987755679);


echo "<pre>";
print_r($result);
echo "</pre>";

echo "Identified";
$result=$pdo->plainoptions(2987755711);


echo "<pre>";
print_r($result);
echo "</pre>";

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo "<br>Page Generated in ".(number_format(microtime(true) - $start_time, 2))." sec";
  
