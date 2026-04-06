<?php
/**
 * Database quries and connection class to perform various operations on Database using PDO.
 * @author vikramsangat
 * @category pdo sql
 */
class Dbconnections
{
	
	//////////////////////////////////////
	/////    Protected Properties    /////
	//////////////////////////////////////
	
	protected $_connection;
	protected $_query;
	protected $_statement;
	protected $_parameters=array();


	//////////////////////////////////////
	/////   Methodes Initialization  /////
	//////////////////////////////////////
	/**
	 * Connection string for PDO according to db you wana work with.
	 * @param string $dbname select database name.
	 */
	function __construct($dbname)
	{
		
			if($dbname=='ASD')
			{
			$this->_connection= new PDO("odbc:webasdOdbc", getenv('ODBC_DB_USERNAME'), getenv('ODBC_DB_PASSWORD'));
			}
			elseif($dbname=='A3ItemEvent')
			{
			$this->_connection= new PDO("odbc:webasdItemEvent", getenv('ODBC_DB_USERNAME'), getenv('ODBC_DB_PASSWORD'));
			}

		
	}
	/**
	 * Plain Sql quries can be created here .
	 * 
	 * @param string $query SQL Query string.
	 * @return array With all the returnd columns.
	 */
	function buildQuery($query)
	{
		$results=array();
		$this->_query=$query;
		$statement=$this->_prepareQuery();
		$statement->execute();
		$return=$statement->fetchAll(PDO::FETCH_NAMED);
		return $return;
	}
	/**
	 * Protected function to Prepare Query.
	 * @return PDOStatement
	 */
	protected function _prepareQuery()
	{
		if(!$stmnt=$this->_connection->prepare($this->_query))
		{
			trigger_error('Problem Preparing Query',E_USER_ERROR);
		}
		return $stmnt;
	}
	/////////////////////////////////////
	////////     Insert Query    ////////
	/////////////////////////////////////
	/**
	 * Select query that selects colums.
	 * @abstract can be used as chaining Methode.
	 * @param string $items select the colums of database.
	 * 
	 */
	public function select($items)
	{
		$this->_type='select';
		$this->_query="SELECT ".$items;
		return $this;
	}
	/**
	 * From method to select from which table to select the data.
	 * @param string $tablenames Name of Table in Database.
	 */
	public  function from($tablenames)
	{
		$this->_query.="From ".$tablenames;
		return $this;
	}
	/**
	 * Order by clause of sql.
	 * @param string $order Order by statement.
	 * @return Dbconnections
	 */
	public function orderby($order)
	{
		$this->_query.='Order By '.$order;
		return $this;
	}
	
	/////////////////////////////////////
	////////     Insert Query    ////////
	/////////////////////////////////////
	/**
	 * Inset table selector.
	 * @param string $tablename Name of table to perform action upon.
	 * 
	 */
	public function insertInto($tablename)
	{
		
		$this->_query="INSERT into ".$tablename;
		return $this;
	}
	/**
	 * Select values to be inserted
	 * @param array $tabledata paramatric array of items 
	 * 
	 */
	public function values($tabledata)
	{
		$keys=array_keys($tabledata);
		$values=array_values($tabledata);
		foreach ($values as $key=> $val)
		{
			if(strpos($val,'?') !== false)
			{
			$values[$key]="{$val}";
			}
			else 
			{
			$values[$key]="'{$val}'";	
			}
		}
		$this->_query.=" (" . implode($keys, ',') .") VALUES( ". implode($values, ',')." )";
		return $this;
	}
	
	
	/////////////////////////////////////
	////////     Update Query    ////////
	/////////////////////////////////////
	/**
	 * Select table to perform Update action on.
	 * @param string $table Name of table.
	 * 
	 */
	public function update($table)
	{
		$this->_query='UPDATE '. $table ; 
		return $this;
	}
	/**
	 * Set values to be Updated.
	 * @param array $tabledata paramatric array of items
	 *
	 */
	public function set($tabledata)
	{
		$values =array();
		
		foreach ($tabledata as $key=>$val)
		{
			if(strpos($val,'?') !== false)
			{
			$values[]="$key = {$val} ";
			}
			else 
			{
			$values[]="$key = '{$val}' ";	
			}
			
		}
		$this->_query.=" SET ".implode($values, ',');
		return $this;
	}
	/////////////////////////////////////
	////////     Delete Query    ////////
	/////////////////////////////////////
	/**
	 * Select table to perform delect action upon.
	 * @param string $tableName Name of table.
	 *
	 */
	public function delete($tableName)
	{
	  $this->_query="DELETE FROM ".$tableName;
	  return $this;
	}
	//Global Things That will be required
	/**
	 * Where Statement selector.
	 * @param statement $arr where statement.
 	 *
	 */
	public function where($arr)
	{
		$this->_query.=" Where ". $arr;
		return $this;
	}
	/**
	 * Bind the paramter with values .
	 * @param array $parameters Parameters used in query.
	 */
	public function bindparamers($parameters)
	{
		foreach ($parameters as $key=>$value)
		{
			$this->_parameters[$key]=$value;
		}
		return $this;
	}
	/**
	 * Execute the Query.
	 * @param array $params array of params.
	 * @return array number of rows if performing select opperation and number of rows affected when using insert update delete.
	 */
	public function executeQuery($params=NULL)
	{
		try 
		{
		 $this->_statement=$this->_connection->prepare($this->_query);
		
		
		 if(!empty($this->_parameters))
		 {
			 foreach ($this->_parameters as $key => &$val)
			 {
		    	$this->_statement->bindParam($key, $val);
		     }
		 }
		 $this->_statement->execute($params);
		 $pos=strpos($this->_query, 'SELECT');
		 if ($pos!==false)
		 {
		 	$result=$this->_statement->fetchAll(PDO::FETCH_NAMED);
		 	
		 }
		 else
		 {
		   	$result=$this->_statement->rowCount();
		 }
		 return $result;
		}
		catch (PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	
}