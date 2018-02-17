<?php
class Model {
	public function __construct($data = null) {
		if ($data) {
			$obj = static::readId($data);
			if (!empty($obj)){
				$fields = get_object_vars($obj);
				foreach ($fields as $fieldName => $fieldValue){
					$this->$fieldName=$fieldValue;
				}
			}
		}	
	}
	
	public static function convertArrayToObject ($arr, $class){
		if (is_array($arr)){
			$obj = new $class();
			foreach ($arr as $key => $value){
				$obj->$key=$value;
			}
			return $obj;
		}	
		return null;
	}
	
	public function save() {
		$method = isset($this->id) ? 'update' : 'insert';
		return $this->$method();
	}
	
	public static function getConn() {
		static $conn = null;
		if ($conn===null) {
		    require ('application/database.php');
			
			$conn = mysqli_connect(
				$MYSQL_CONFIG['HOST'],
				$MYSQL_CONFIG['USER'],
				$MYSQL_CONFIG['PASSWORD'],
				$MYSQL_CONFIG['DATABASE']
			);
			mysqli_set_charset($conn,"utf8");
			//if connection not exist then send error message
			if (!$conn) {
				die (PHP_EOL.'<b>error ['.mysqli_connect_errno().']:</b> <i>'.mysqli_connect_error().'</i>'.PHP_EOL);			
			}
		}
		return $conn;
	}	
	
    public static function readId ($id){
		return static::readRecords(sprintf('`id` = %u',$id), true);
		
    }
	
    public static function getAll(){
		return static::readRecords('1', true, true);
    }	

    public static function countAll($cond='1'){
		$query=sprintf("SELECT count(*) as c FROM `%s` WHERE %s",static::$TABLE_NAME, $cond);
		$result = static::execQuery($query);
		if (!empty($result)){
			return $result[0]['c'];
		}else{
			return false;
		}
    }		

    public static function getPage($index=0, $amount, $cond='1'){
    	return static::readRecords($cond, true, true, $index, $amount);   
        
    }
	
    public static function getFirst(){
		return static::readRecords('1', true, false, 0, 1, 'id', false);
    }	
	
    public static function getLast(){
		return static::readRecords('1', true, false, 0, 1, 'id', true);
    }	
	protected static function getClassName (){
		$tableName=static::$TABLE_NAME ? static::$TABLE_NAME : '';
		if (strlen(trim($tableName))<1) { return false;}
			$className = ucfirst(substr($tableName, -1)==="s" ? substr($tableName, 0, -1) : $tableName);
		return $className;		
	}
	
	public function insert(){
		$fields = get_object_vars($this);
		unset($fields['id']);
		$query = sprintf("INSERT INTO `%s` SET ", static::$TABLE_NAME);
		$data = [];
		foreach ($fields as $fieldName => $fieldValue){
			if ($fieldValue){
				$data[] = sprintf("%s = '%s'", $fieldName,htmlspecialchars( $fieldValue, ENT_QUOTES));
			}
		}
		$query = $query.implode(', ',$data);
		return static::execQuery($query);
	}
	
	public function update(){
		$fields = get_object_vars($this);
		unset($fields['id']);
		$query = sprintf("UPDATE `%s` SET ", static::$TABLE_NAME);
		$data = [];
		foreach ($fields as $fieldName => $fieldValue){
			if ($fieldValue){
				$data[] = sprintf("%s = '%s'",$fieldName,htmlspecialchars($fieldValue, ENT_QUOTES));
			}
		}
		$query = $query.implode(', ',$data).sprintf(" WHERE id='%s'",$this->id);
		return static::execQuery($query);
	}	
	
	public static function insertRow($array=[]){
		if (count($array)>0){
			$keys = array_keys($array);
			$values = array_values($array);
			$key_data = '(`'.implode('`,`',$keys).'`)';
			$value_data = "('".implode("','",$values)."')";
			$query=sprintf("INSERT INTO `%s` %s VALUES %s",static::$TABLE_NAME,$key_data,$value_data);
			if (!empty($queryResult = mysqli_query(static::getConn(), $query))){
				return [true, ""];
			}else{
				return [false, "Cannot insert this to database"];
			}
		}
	}
	
    protected function setRecord ($record){
		foreach($record as $key => $value){
			$this->$key = $value;
		}
    }		
    
    protected static function deleteRecords($conditons="0"){
		$query=sprintf("DELETE FROM `%s` WHERE %s",static::$TABLE_NAME,$conditons);
		return static::execQuery($query);
    }

	//	useage if it is public:
	//	Model::readRecords("id>22", true, true, -1, -1, 'id', true)

	protected static function readRecords ($conditons="1", $returnData=false, $array=false, $pageIndex=0, $perPage=PHP_INT_MAX, $orderBy=false, $orderDesc=false, $join=false){

		if ($perPage < 1) $perPage = 30;
		$orderBy = $orderBy ? sprintf("ORDER BY `%s` %s",$orderBy,$orderDesc ? "DESC" : "ASC") : "";
		$startPage = $pageIndex>-1 ? ($pageIndex*$perPage): 0;
		$endPage = $pageIndex>-1 ? $perPage : PHP_INT_MAX;
		$joinStr = "";
		$tableName = static::$TABLE_NAME;
		if ($join) {
			$joinStr = $join[0]. " ".$join[1]." ON ".$tableName.".".$join[2]."=".$join[1].".id";
			deg($joinStr);
			die;
		}
		$query = sprintf("SELECT * FROM `%s` %s WHERE %s %s LIMIT %u, %u",$tableName,$joinStr, $conditons,$orderBy, $startPage,$endPage);
		$result = static::execQuery($query);

		// we check if we got result
		if (!empty($result)){
			// we check if we need return data
			if ($returnData!==false){
				$className = static::getClassName();
				$out = [];
				//if we need 1 item then first block, if we need mor record then we use foreach
				if (!$array){
					$obj = new $className;
					$obj -> setRecord($result[0]);
					$out = $obj;
				}else{
					foreach ($result as $row) {
						$obj = new $className();
						$obj -> setRecord($row);
						$out[] = $obj;
					}	
				}
				return $out;
			}
			return true;
		}else{
			return false;
		}		
	}
	
	public function getInsertedId(){
		if (isset($this->id)) {
			return $this->id;
		}else{
			return mysqli_insert_id(static::getConn());
		}
		
	}
	
	protected static function execQuery ($query){
		$queryResult = mysqli_query(static::getConn(), $query);
		
		if (!$queryResult) {
			die (PHP_EOL.'--<b>error ['.mysqli_connect_errno().']:</b> <i>'.mysqli_connect_error().'</i>'.PHP_EOL);			
		}
		
		if (is_object($queryResult)){
			$result = [];
			while($row = mysqli_fetch_assoc($queryResult)){
				$result[] = $row;
			}; 
			mysqli_free_result($queryResult);
			return $result;
		}
		return $queryResult;
	}
	
}

//get_called_class() if static method give the caller object name