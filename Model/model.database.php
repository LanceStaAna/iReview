<?php

class Database {
	
	public static $zpv_conn;
	
	public static function connection() {
		
		try {
		
			require dirname(dirname(__FILE__)) . '/config/config.sql_connection.php';
			
			
			//$fv_conn = new PDO("mysql:host=192.168.1.2;dbname=DRAGONSSE;port=3306" ,$sql['USERNAME'], $sql['PASSWORD']);
			
			//local
			$fv_conn = new PDO("mysql:host=".$sql['HOST'].";dbname=".$sql['DB_NAME'].";port=3306" ,$sql['USERNAME'], $sql['PASSWORD']);
			$fv_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			return $fv_conn;
		}
		
		catch (Exception $e){

			return false;
		}
	}
	
	//---------------------------TABLE OPERATION METHODS----------------------------
	
	
	public static function insertRow($insertQuery, $parameters = array()) {
	
		try {
		
			$stmt = Database::$zpv_conn->prepare("INSERT INTO $insertQuery");
			$stmt->execute($parameters);
		}
	
		catch (Exception $e){
			return false;
		}
	}
	
	public static function deleteRow($deleteQuery, $parameters = array()) {
	
		try {
	
			$stmt = Database::$zpv_conn->prepare("DELETE FROM $deleteQuery");
			$stmt->execute($parameters);
		}
	
		catch (Exception $e){
			return false;
		}
	}
	
	public static function updateRow($updateQuery, $parameters = array()) {
	
		try {
	
			$stmt = Database::$zpv_conn->prepare("UPDATE $updateQuery");
			$stmt->execute($parameters);
		}
	
		catch (Exception $e){
			return false;
		}
	}
	
	//---------------------------TABLE QUERY METHODS--------------------------------
	
	
	public static function getRow($tableName, $conditions = array()) {
		
		try {
		
			$tableResults = Database::$zpv_conn->prepare("SELECT * FROM $tableName");
			$tableResults->setFetchMode(PDO::FETCH_ASSOC);
			$tableResults->execute($conditions);
				
		
			return ($tableResults->rowCount() > 0)
			? $tableResults
			:false;
		}
		
		catch (Exception $e){
			return false;
		}
	}
	
	
	public static function getRow_v2($queryStatement, $conditions = array()) {
	
		try {
	
			$tableResults = Database::$zpv_conn->prepare("SELECT * FROM $queryStatement");
			$tableResults->setFetchMode(PDO::FETCH_ASSOC);
			$tableResults->execute($conditions);
				
			$result = $tableResults->fetchAll();
				
			return (count($result) > 0)
			? $result
			:false;
		}
	
		catch (Exception $e){
			return false;
		}
	}
	
	
	public static function query($queryStatement, $conditions = array()) {
	
		try {
	
			$tableResults = Database::$zpv_conn->prepare("$queryStatement");
			$tableResults->setFetchMode(PDO::FETCH_ASSOC);
			$tableResults->execute($conditions);
	
			
			return ($tableResults->rowCount() > 0)
			? $tableResults
			:false;
		}
	
		catch (Exception $e){
			return false;
		}
	}
	
	
	public static function query_v2($queryStatement, $conditions = array()) {
	//returns an array
	
		try {
	
			$tableResults = Database::$zpv_conn->prepare("$queryStatement");
			$tableResults->setFetchMode(PDO::FETCH_ASSOC);
			$tableResults->execute($conditions);
			
			$result = $tableResults->fetchAll();
			
			
			return (count($result) > 0)
			? $result
			:false;
		}
	
		catch (Exception $e){
			return false;
		}
	}
	
	
	public static function getOnlyOneRow($tableName, $conditions = array()) {
	
		try {
	
			$tableResults = Database::$zpv_conn->prepare("SELECT * FROM $tableName");
			$tableResults->setFetchMode(PDO::FETCH_ASSOC);
			$tableResults->execute($conditions);
				
		
			return ($tableResults->rowCount() === 1)
			? $tableResults
			:false;
		}
	
		catch (PDOException $e){
			return false;
		}
	}
	
	
	public static function getOnlyOneRow_v2($tableName, $conditions = array()) {
	
		try {
	
			$tableResults = Database::$zpv_conn->prepare("SELECT * FROM $tableName");
			$tableResults->setFetchMode(PDO::FETCH_ASSOC);
			$tableResults->execute($conditions);
	
			$result = $tableResults->fetchAll();
				
			return (count($result) === 1)
			? $result
			:false;
		}
	
		catch (PDOException $e){
			return false;
		}
	}
	
	
	public static function queryOnlyOneRow($tableName, $conditions = array()) {
		
		try {
		
			$tableResults = Database::$zpv_conn->prepare("$tableName");
			$tableResults->setFetchMode(PDO::FETCH_ASSOC);
			$tableResults->execute($conditions);
	
			return ($tableResults->rowCount() === 1)
			? $tableResults
			:false;
		}
	
		catch (Exception $e){
			return false;
		}
	}
	
	
	public static function queryOnlyOneRow_v2($tableName, $conditions = array()) {
	
		try {
	
			$tableResults = Database::$zpv_conn->prepare("$tableName");
			$tableResults->setFetchMode(PDO::FETCH_ASSOC);
			$tableResults->execute($conditions);
	
			$result = $tableResults->fetchAll();
			
			return (count($result) === 1)
			? $result
			:false;
		}
	
		catch (Exception $e){
			return false;
		}
	}
	
	public static function rowCount($query, $conditions = array()) {
	
		try {
	
			$tableCount = Database::$zpv_conn->prepare("SELECT $query");
			$tableCount->setFetchMode(PDO::FETCH_ASSOC);
			$tableCount->execute($conditions);
	
			return $tableCount;
		}
	
		catch (Exception $e){
			return false;
		}
	}
	
}


Database::$zpv_conn = Database::connection();

if (!Database::$zpv_conn) {
	//header('Location: ../connectionError.php');
	echo "No Database Connection";
	die();
}



/**

	NAMING CONVENTIONS
	
	VARIABLES:
	|----------------------------------------------------------|
	| Page Variables                  ::                       |
	| - variables that are only		  ::   $pv_[variable name] |
	|   declared and used in 1 page.  ::                       |
	|----------------------------------------------------------|
	| Function or method Variables    ::                       |
	| - variables that are only       ::                       |
	|	declared and used inside a    ::   $fv_[variable name] |
	|	function or a method.         ::                       |
	|----------------------------------------------------------|
	| Global Variables                ::                       |
	| - variables that are declared   ::   $gv_[variable name] |
	|	in one page and used in       ::                       |
	|	another.                      ::                       |
	|----------------------------------------------------------| 
	| Page Arrays                     ::                       |
	| - arrays that are declared and  ::   $pa_[array name]    |
	|	used only in 1 page           ::                       |
	|----------------------------------------------------------|
	| Global Arrays                   ::                       |
	| - arrays that are declared in   ::   $ga_[array name]    |
	|	one page and used in another  ::                       |
	|----------------------------------------------------------|
	| Table Data                      ::                       |
	| - an array of associative       ::   $td_[array name]    |
	|	arrays that contains          ::                       |
	|	data returned from the DB     ::                       |
	|----------------------------------------------------------|

	FUNCTIONS/METHODS/CLASSES/CLASS PROPERTIES
	|-----------------------------------------------------------|
	| Custom Functions           ::   zf_[function name]()      |
	| - user defined functions   ::                             |
	|-----------------------------------------------------------|
	| Custom Class               ::   zc_[class name]           |
	| - user defined class       ::                             |
	|-----------------------------------------------------------|
	| Custom Property Variable   ::                             |
	| - a user defined property  ::                             |    
	|	in a user defined	     ::   $zpv_[poperty name]       |
	|   class that contains only ::                             |
	|   ONE string of data       ::                             |
	|-----------------------------------------------------------|
	| Custom Property Array      ::                             |
	| - a user defined property  ::                             |   
	|   in a user defined        ::   $zpa_[property name]      |
	|   class that contains      ::                             |
	|   an array                 ::                             |
	|-----------------------------------------------------------|
	| Custom Methods             ::                             |
	| - a user defined method in ::   zm_[method name]()        |
	|   a user defined class     ::                             |
	|-----------------------------------------------------------|

*/












