<?php 
class LoginRestart
{
	private $ASD;
	private $A3Item;
	
	function __construct()
	{
	  $this->A3Item=new PDO("mysql:host=localhost;dbname=a3acp", "root", "");
	  $this->ASD=new PDO("mysql:host=localhost;dbname=a3acp", "root", "");
	}
	function getRestartCount()
	{
			
	}
	private function registerrestart()
	{
		try
		{
		$statement="Insert Into LoginRestart (Username,RTime) VALUES(:user,:time)";
		$query=$this->A3Item->prepare($statement);
		$query->execute(array(":user"=>$_SESSION['username'],":time"=>time()+300));
		}
		catch (PDOException $e)
		{
			die ($e->getMessage());
		}	
	}
	public function restartstatus()
	{
		try
		{
			$statement="Select TOP 1 RTime from LoginRestart Where Username=:user order by RTime desc";
			$query=$this->A3Item->prepare($statement);
			$query->execute(array(":user"=>$_SESSION['username']));
			$row=$query->fetch(PDO::FETCH_NAMED);
			if (time()>$row['RTime'])
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		catch (PDOException $e)
		{
			die ($e->getMessage());
		}	
	}
	function restart()
	{
		if ($this->restartstatus()) 
		{
			$this->registerrestart();
			//$WshShell = new COM("WScript.Shell"); 
			//$oExec = $WshShell->Run("D:\lsrestart.bat", 3, true); 
			//require_once('../run.php');
			$echo=file_get_contents('/run.php');
			return true;
		}
		else 
		{
			return false;
		}
	}
}