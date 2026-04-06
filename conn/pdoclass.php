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

		$type["Armor"] = 4129;
        $type["Boots"] = 7201;
        $type["Gloves"] = 6177;
        $type['Helmet'] = 3105;
        $type['Pant'] = 5153;
        $type['Shield']=481;
        $type['WarriorSword']=2145;
        $type['WarriorSpear']=2273;
        $type['WarriorAxe']=2209;
        $type['HKSword']=1377;
        $type['HKMace']=1441;
        $type['MageEle']=2337;
        $type['MageNon-Ele']=2721;
        $type['ArcherBow']=1569;
        $type['ArcherxBow']=1633;
		
		$grey_mod = fmod($options, 67108864);
		$grey_minus_main = $options - $grey_mod;
		$grey = $grey_minus_main / 67108864;

		$red_mod = fmod($grey_mod, 1048576);
		$red_minus_gery = $grey_mod - $red_mod;
		$red = $red_minus_gery / 1048576;

		$blue_mod = fmod($red_mod, 16384);
		$blue_minus_red = $red_mod - $blue_mod;
		$blue = $blue_minus_red / 16384;

		$something_mod = fmod($blue_mod, 32);
        $remaining= $blue_mod-$something_mod;
        $remaining = $remaining+1;
        $unidentified=fmod($remaining,3);


		$Level_mod = fmod($something_mod, 16);
		$level_minus_somthing=$something_mod-$Level_mod;
		$new=$level_minus_somthing/16;

		$something_minus_level = $something_mod - $Level_mod;


		$add = $something_minus_level / 16;


		$Additional = ($add==1) ? 'Yes' : 'No';

		return  array('Main'=>$options,'grey_mod' =>$grey_mod ,'grey_minus_main'=>$grey_minus_main,'grey'=>$grey,'red_mod'=>$red_mod,'red_minus_gery'=>$red_minus_gery,'red'=>$red,'blue_mod'=>$blue_mod,'blue_minus_red'=>$blue_minus_red,'blue'=>$blue,'something_mod'=>$something_mod,'remaining'=>$remaining,'unidentified'=>$unidentified,'Level_mod'=>$Level_mod,'level_minus_somthing'=>$level_minus_somthing,'new'=>$new,'something_minus_level'=>$something_minus_level,'add'=>$add,'Additional'=>$Additional );
		//return array('Additional'=>$Additional,'Blue'=>$blue,'Red'=>$red,'Grey'=>$grey,'Level'=>$Level_mod,'unidentified'=>$unidentified,'remaining'=>$remaining,'new'=>$new,'something_mod'=>$something_mod);

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
