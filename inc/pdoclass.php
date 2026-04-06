<?php
class PDOExamples
{
	public $asd = "mysql:host=localhost;dbname=a3acp";
	public $a3itm="mysql:host=localhost;dbname=a3acp";
	public $user;
	public $password;



	public function __construct()
	{
		$this->user     = getenv('MYSQL_DB_USERNAME');
		$this->password = getenv('MYSQL_DB_PASSWORD');
	}

	public function ASDConnect()
	{
		return new PDO($this->asd,$this->user,$this->password);
	}
	public function A3ItemEventConnect()
	{
		return new PDO($this->a3itm,$this->user,$this->password);
	}

	public function plainoptions($options){
		
		$i1 = fmod($options, 67108864);
		$j1 = $options - $i1;
		$grey = $j1 / 67108864;

		$i2 = fmod($i1, 1048576);
		$j4 = $i1 - $i2;
		$red = $j4 / 1048576;

		$i3 = fmod($i2, 16384);
		$j5 = $i2 - $i3;
		$blue = $j5 / 16384;

		$i4 = fmod($i3, 32);
		$j6 = fmod($i4, 16);
		$i8 = $i4 - $j6;
		$bless = $i8 / 16;


		$blessing = ($bless==1) ? 'Yes' : 'No';

		return array('Blessing'=>$blessing,'Blue'=>$blue,'Red'=>$red,'Grey'=>$grey,'Level'=>$j6);

	}

	public function storageboxoptions($options){
		
		$item = fmod($options, 16384);
		$bb = $options - $item;
		$count = $bb / 16384;
		return array('Item'=>$item,'Count'=>$count);

	}
	public function addmounting($options){
		
		$options=(int)$options;
		$mount=fmod($options, 65536);
		$bb = $options - $mount;
		$mcount = $bb / 65536;
		$item = fmod($mount, 32768);
		$bb = $mount - $item;
		$adatt = $bb / 32768;
		$mcount=($mcount*10)."%";
		$ad1 = ($adatt==1) ? 'Yes' : 'No';
		return array('Mount'=>$mcount,'Additional'=>$ad1,'Item'=>$item);

	}
	public function RArry()
	{
		return array("name"=>'This is name of my return');
	}
	public function itemInfo($value)
	{
		$db2=$this->A3ItemEventConnect();
		$statement="SELECT * FROM itemlist WHERE code = :code";
		$query=$db2->prepare($statement);
		$query->bindParam(':code', $value,PDO::PARAM_INT);
		$query->execute();
		$prot10=$query->fetch();
		$name=clear($prot10['itmname']);
		$search  = array('&nbsp;',"'", '%20');
		$name = str_replace($search,"", $name);
		$name = rtrim($name);
		return array('Name'=>$name,'Image'=>$prot10['image'],'Code'=>$prot10['code'],'Type'=>rtrim($prot10['ittype']),'Class'=>rtrim($prot10['itclass']));

	}
	public function ItemOptions($slot,$char)
	{
		$char=(string)$char;
		$imcode=0;
		$db=$this->ASDConnect();
		include('pdombody.php');

		$newArry =explode(';', $INVEN[1]);
		$sr = explode(";",$INVEN[1]);
		$result1 = array();
		$source = array_values($sr);
		$count = count($source);
		for($i = 3; $i < $count; $i +=4) {
			$result1[] = $source[$i];
		}
		$getResultKey=array_keys($result1,$slot-1);
		$msg="";
		$slots="";
		$result=array();
		foreach($getResultKey as $value){
			$result[]=($value*4)+3;
			 
		}
		foreach($result as $value){
			$msg.="".$newArry[$value-3].";".$newArry[$value-2].";".$newArry[$value-1].";".$newArry[$value].";";
			$slot=$value;
		}
		$break=explode(';', $msg);
		$itm=$this->addmounting($break[0]);
		if($itm['Item']==17){
			$strgItem=$this->storageboxoptions($break[1]);
		}
		$Plainoptions=$this->plainoptions($break[1]);
		if($itm['Item']=='')$imcode=0;
		else $imcode=$itm['Item'];
		$itminfo=$this->itemInfo($imcode);
		if($itm['Item']==17){
			$Strgitminfo=$this->itemInfo($strgItem['Item']);
		}

		return array("Slot"=>$slot,"Char"=>$char,"ItmInfo"=>$msg,"ItemCode"=>$imcode,"Name"=>$itminfo['Name'],"Blessing"=>$Plainoptions['Blessing'],"Blue"=>$Plainoptions['Blue'],"Red"=>$Plainoptions['Red'],"Grey"=>$Plainoptions['Grey'],"Level"=>$Plainoptions['Level'],"Image"=>$itminfo['Image'],"Type"=>$itminfo['Type'],"Class"=>$itminfo['Class'],"Mount"=>$itm['Mount'],"Additional"=>$itm['Additional'],"Itmid"=>$break[0],"Typeid"=>$break[1],"Uniqid"=>$break[2],"Itmslot"=>$break[3],"Storageitem"=>$Strgitminfo['Name'],"Count"=>$strgItem['Count'],"StrgType"=>$Strgitminfo['Type'],"StrgImage"=>$Strgitminfo['Image'],"StrgClass"=>$Strgitminfo['Class']);
	}

}
