<?php
/*	Author: Massami W. Kamigashima - 27.12.2012
	+ public
	- private

	(var) = required
	[var] = optional

	Note: Condition values accepts the following special characters:
			!value
			%value , value% , %value%
			< , <= , > , >=

	Function list:
	+ __construct([$utf8 = true,[$debug = false]])
	+ getDB()
	+ setClass($class)
	- anti_injection($sql,[$exceptions = array()])
	+ query([$query = null])
	+ select($fields,$table[,$whereParams = array()[,$groupby = array()[,$groupParams = array()[,$orderby = null[,$start = null[,$max = null,[$condType = "AND"]]]]]]])
	+ update($table,$setParams,$whereParams[,$limit = 0])
	+ insert($table,$params[,$updateOnExist = false])
	+ delete($table, $condition)
	+ count($table,[$params = array()])
	- execute([$params = array()])
	- fetchValues()
	+ lastID()
	+ rowCount()
	+ tableCount($table)
	+ loadClass($class,$condition,$orderby = null)
	- conditions($array)
	+ __clone()
*/

class DB {
	// Connection control
	private $db				= null;
	private $port			= '3306';

	private $host			= "localhost";
	private $user			= "dataprisma";
	private $pass			= "prisma";
	private $database		= "cajovil";

	#private $host			= "localhost";
	#private $user			= "arxo10";
	#private $pass			= "o2x3r4ajxT1";
	#private $database		= "arxo10";

	// History variables for function re-usage
	private $prepared		= null;
	private $lastAction		= '';
	private $lastFields		= array();
	private $lastParams		= array();
	private $lastCondFields	= array();
	private $lastCondParams	= array();
	private $paramArray 	= false;

	// Constructor parameter. If set true, will show the PDO query parameters on error.
	private $debug			= false;

	// Constructor parameter. If set true, it will return a fetched class
	private $toClass		= false;
	private $class			= '';

	public function __construct($class = false, $utf8 = true,$debug = false){
		try {
			if ($utf8) {
				$this->db = new PDO("mysql:dbname={$this->database};host={$this->host};port={$this->port}", $this->user, $this->pass,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"));
			} else {
				$this->db = new PDO("mysql:dbname={$this->database};host={$this->host};port={$this->port}", $this->user, $this->pass);
			}

			$this->debug = $debug;
			// IF toClass is set true, setClass($class) must be called to work
			$this->toClass = !!$class;
		} catch (PDOException $e){
			die($e->getMessage());
		}
	}

	public function getDB(){
		return $this->db;
	}

	// Add or remove current class loader
	public function setClass($class){
		$this->class   = (string) $class;
		$this->toClass = !!$this->class;
	}

	/*	Security function to protect queries from dangerous SQL reserved words */
	public static function anti_injection($sql,$exceptions = array()){
		$rules = '/(from|select|insert|delete|where|truncate|alter table|create table|update|drop table|show tables|--|\\\\)/i';

		if (is_array($exceptions) && !empty($exceptions)){
			foreach ($exceptions as $ex){
				$rules = str_replace($ex.'|', '', $rules);
			}
		}

		return preg_replace($rules,"",$sql);
	}

	/*	Only SELECT are allowed on this function
		$query [string] = Complete SQL string query
	*/
	public function query($query = null,$params = array()){
		$this->paramArray = false;
		$query = $this->anti_injection($query,array('select','from','where','delete'));

		// Check if there is a valid query on $query or stored in the class
		if (!!$query){
			$this->prepared = $this->db->prepare($query);
		} else {
			throw new Exception('Query error. Invalid query.');
		}
		$this->execute($params);
		$results = $this->fetchValues();

		return $results;
	}

	/*	Select function with field storage.
		Note: For more complex queries using UNION or JOIN, use the query() function instead.
		$fields		 (string) = list of fields to be selected, separe each field with comma (,). If an empty string is provided, the wildcard (*) is used instead.
		$table		 (string) = the selected table
		$whereParams [array]  = list of condition fields/values for WHERE block (if any). Array format: ( $field => $value )
			* if $value is null => $field IS NULL
			* if $value is !null => $field IS NOT NULL
			* if $value is !$value => $field != $value
		$groupby	 [array]  = list of fields to be grouped
		$having [array]  = list of condition fields/values for HAVING block (if any). Array format: ( $field => $value ). Ignored if $groupby is empty
			* if $value is null => $field IS NULL
			* if $value is !null => $field IS NOT NULL
			* if $value is !$value => $field != $value
		$orderby	 [string] = list of fields to be ordered by. Comma (,) separated.
		$start		 [int]	  = starting value for LIMIT block
		$max		 [int]	  = row limit value for LIMIT block
		$condType	 [string] = Condition Type, AND or OR used on WHERE statement
	*/
	public function select($fields, $table, $whereParams = array(), $groupby = array(), $having = array(), $orderby = null, $start = null, $max = null,$condType = 'AND'){

		$this->paramArray = false;

		if (!is_array($having)){
			$having = array();
		}

		// Validate input values
		if (!trim($table)){
			throw new Exception('Invalid Table.');
		} else {
			$table = $this->anti_injection($table);
		}

		$size = count($whereParams);
		$size2 = count($this->lastFields);

		$this->lastFields = array();

		$this->lastCondFields = array();
		$this->lastParams     = array();

		if (!is_array($whereParams)){
			$whereParams = array();
			$cond        = array();
		} else {
			$i = 0;
			$cond = $this->conditions($whereParams);
		}

		$this->lastAction = 'select';

		if ($fields == ''){
			$fields = '*';
		} else {
			$fields = $this->anti_injection($fields);
		}
		//----------------------

		// Creating statement
		$query = "SELECT $fields FROM $table";

		$size = count($cond);

		if ($size > 0){
			$query .= ' WHERE '.implode(' '.$condType.' ',$cond);
		}

		if (is_array($groupby) && !empty($groupby)){
			$query .= ' GROUP BY '.implode(',',$groupby);

			if (!empty($having)){
				$cond = array();

				foreach ($having as $field => $value){
					if ($value === null || strtolower($value) == 'null'){
						$cond[] = $field .' IS NULL';
					} else if ($value === ''){
						$cond[] = '('.$field .' = "" OR '.$field .' IS NULL)';
					} else if (strtolower($value) == '!null'){
						$having[$field] = preg_replace('!','',$value,1);
						$cond[] = $field .' IS NOT NULL';
					} else if (preg_match('/(^%|%$)/', $value) && !!$value){
						$having[$field] = $value;
						$this->lastParams[] = $value;
						$cond[] = $field .' LIKE :'.$field;

						if (!in_array(':'.$field,$this->lastFields)){
							$this->lastFields[] = ':'.$field;
						}
					} else if (preg_match('/^(<=?|>=?)\s?[\d]+(\.[\d]+)?$/', $value,$found)){
						$aux = str_replace($found[1],'',$value);
						$aux = trim($aux);
						$having[$field] = $aux;
						$cond[] = $field .' '.$found[1].' :'.$field;
						$this->lastParams[] = $aux;

						if (!in_array(':'.$field,$this->lastFields)){
							$this->lastFields[] = ':'.$field;
						}
					} else if (preg_match('/^!(.+)$/', $value)){
						$having[$field] = preg_replace('!','',$value,1);
						$cond[] = $field .' != :'.$field;
						$this->lastParams[] = substr($value,1);

						if (!in_array(':'.$field,$this->lastFields)){
							$this->lastFields[] = ':'.$field;
						}
					} else {
						$cond[] = $field .' = :'.$field;
						$this->lastParams[] = substr($value,1);

						if (!in_array(':'.$field,$this->lastFields)){
							$this->lastFields[] = ':'.$field;
						}
					}
				}

				$query .= ' HAVING '.implode(' AND ',$cond);
			}
		}

		if ($orderby != null){
			$query .= ' ORDER BY '.$orderby;
		}
		if ($max !== null){
			$query .= " LIMIT $start,$max";
		}
		
		$this->prepared = $this->db->prepare($query);
		// --------------

		// Re-organize the array of key => values
		if (count($this->lastFields) > 0){
			if (count($this->lastFields) == count($this->lastParams)){
				$params = array_combine($this->lastFields,$this->lastParams);
			} else {
				throw new Exception('Wrong parameter count.');
			}
		} else if ($this->paramArray){
			$params = $this->lastParams;
		} else {
			$params = array();
		}

		$this->execute($params);

		// If a class is informed
		if ($this->toClass && $this->class != ''){
			$objects = array();

			if ($this->rowCount() === 1){
				return $this->prepared->fetchObject($this->class);
			} else {
				$objects = array();

				while ($object = $this->prepared->fetchObject($this->class)){
					$objects[] = $object;
				}
				return $objects;
			}
		} else {
			return $this->fetchValues();
		}
	}

	/*
		$table		 (string)
		$setParams	 (array)  = list of parameters for SET block. Array format: ( $field => $value )
		$whereParams (array)  = list of parameters for SET block. Array format: ( $field => $value )
		$limit		 [int]	  = limit of affected rows
	*/
	public function update($table, $setParams, $whereParams, $limit = 0){
		$this->paramArray = false;
		
		if (!trim($table)){
			throw new Exception('Invalid Table.');
		} else {
			$table = $this->anti_injection($table);
		}

		if (!is_array($setParams) || empty($setParams)){
			throw new Exception('The new values for UPDATE must be provided!');
		} else {
			foreach ($setParams as $field => $value){
				$field = $this->anti_injection($field);
				if ($value === null){
					$setParams[$field] = null;
				} else {
					$setParams[$field] = $this->anti_injection($value);
				}
			}
		}

		if (!is_array($whereParams) || empty($whereParams)){
			throw new Exception('For safety purposes, the condition values (WHERE) for UPDATE must be provided!');
		} else {
			foreach ($whereParams as $field => $value){
				$field = $this->anti_injection($field);
				if ($value === null){
					$whereParams[$field] = null;
				} else {
					$whereParams[$field] = $this->anti_injection($value);
				}
			}
		}

		$this->lastAction = 'update';

		$limit    = intval($limit);
		$query    = "UPDATE $table SET ";
		
		$size     = count($setParams);
		$sizeCond = count($whereParams);

		$this->lastFields     = array();
		$this->lastParams     = array();
		$this->lastCondFields = array();
		$this->lastCondParams = array();

		if ($size > 0) {
			$cond   = $this->set($setParams);
			$query .= implode(', ',$cond);
		} else {
			throw new Exception('Wrong parameter count.');
		}

		$query .= " WHERE ";
		if ($sizeCond > 0){
			$intersect = array_keys(array_intersect_key($setParams,$whereParams));

			$cond = array();
			foreach ($whereParams as $field => $value){
				$varName = $field;
				if (in_array($field,$intersect)){
					$varName .= '2';
				}

				if ($value === null || strtolower($value) == 'null'){
					$cond[] = $field .' IS NULL';
				} else if ($value === ''){
					$cond[] = '('.$field .' = "" OR '.$field .' IS NULL)';
				} else if (strtolower($value) == '!null'){
					$cond[] = $field .' IS NOT NULL';
				} else if (preg_match('/(^%|%$)/', $value) && !!$value){
					$this->lastCondFields[] = ':'.$varName;
					$this->lastCondParams[] = $value;
					$cond[] = $field .' LIKE :'.$varName;
				} else if (preg_match('/^(<=?|>=?)\s?[\d]+(\.[\d]+)?$/', $value,$found)){
					$aux = str_replace($found[1],'',$value);
					$aux = trim($aux);
					
					$this->lastCondFields[] = ':'.$varName;
					$this->lastCondParams[] = $aux;
					$cond[] = $field .' '.$found[1].' :'.$varName;
				} else if (preg_match('/^!(.+)$/', $value)){
					$this->lastCondFields[] = ':'.$varName;
					$this->lastCondParams[] = substr($value,1);
					$cond[] = $field .' != :'.$varName;
				} else {
					$this->lastCondFields[] = ':'.$varName;
					$this->lastCondParams[] = $value;
					$cond[] = $field .' = :'.$varName;
				}
			}
			$query .= implode(' AND ',$cond);
		} else {
			throw new Exception('Wrong parameter count.');
		}

		if ($limit > 0){
			$query .= ' LIMIT '.$limit;
		}
		$this->prepared = $this->db->prepare($query);

		if (count($this->lastFields) > 0){
			if (count($this->lastFields) == count($this->lastParams)){
				$params = array_combine($this->lastFields,$this->lastParams);
			} else {
				throw new Exception('Wrong parameter count.');
			}
		} else if (!$this->paramArray){
			$params = array();
		}

		$params2 = array_combine($this->lastCondFields,$this->lastCondParams);
		$params = array_merge($params,$params2);
		$this->execute($params);
	}

	/*	
		$table
		$params		   (array) = list of parameters for SET block. Array format: ( $field => $value )
		$updateOnExist (bool)  = flag for update if the primary key already exists (true/false)
	*/
	public function insert($table, $params, $updateOnExist = false){
		$this->paramArray = false;

		if (!trim($table)){
			throw new Exception('Invalid Table.');
		} else {
			$table = $this->anti_injection($table);
		}

		if (!is_array($params) || empty($params)){
			throw new Exception('The parameters for INSERT must be provided!');
		} else {
			foreach ($params as $field => $value){
				$field = $this->anti_injection($field);
				if ($value === null){
					$params[$field] = NULL;
				} else {
					$params[$field] = $this->anti_injection($value);
				}
			}
		}
		
		$this->lastAction = 'insert';

		$query = "INSERT INTO $table ";

		$size = count($params);

		$this->lastFields = array();
		$this->lastParams = array_values($params);

		if ($size > 0) {
			$cond = array();
			foreach ($params as $field => $value){
				$this->lastFields[] = ':'.$field;
				$cond[] = $field.' = :'.$field;
			}
			$query .= ' ('.implode(',',array_keys($params)).') VALUES ('.implode(',',$this->lastFields).') ';

			if ($updateOnExist){
				$query .= ' ON DUPLICATE KEY UPDATE '.implode(',',$cond);
			}
		} else {
			throw new Exception('Wrong parameter count.');
		}

		$this->prepared = $this->db->prepare($query);

		if (count($this->lastFields) > 0){
			if (count($this->lastFields) == count($this->lastParams)){
				$params = array_combine($this->lastFields,$this->lastParams);
			} else {
				throw new Exception('Wrong parameter count.');
			}
		} else if (!$this->paramArray){
			$params = array();
		}

		$this->execute($params);
		return $this->lastID();
	}

	/*	
		$table
		$condition	(array) = list of parameters for WHERE block. Array format: ( $field => $value )
	*/
	public function delete($table, $condition){
		$this->paramArray = false;

		if (!trim($table)){
			throw new Exception('Invalid Table.');
		} else {
			$table = $this->anti_injection($table);
		}

		if (!is_array($condition) || empty($condition)){
			throw new Exception('The condition parameters for DELETE must be provided!');
		} else {
			foreach ($condition as $field => $value){
				$field = $this->anti_injection($field);
				$condition[$field] = $this->anti_injection($value);
			}
		}
		
		$this->lastAction = 'delete';

		$query = "DELETE FROM $table ";

		$size = count($condition);

		$this->lastFields = array();
		$this->lastParams = array();

		if ($size > 0) {
			$cond = $this->conditions($condition);
			$query .= ' WHERE '.implode(' AND ',$cond);

			$qtd = count($this->lastParams);
			for ($i = 0; $i < $qtd; $i++){
				$value = $this->lastParams[$i];
				if ($value === null || $value === '' || $value == 'null'){
					unset($this->lastParams[$i]);
				}
			}
		} else {
			throw new Exception('Wrong parameter count.');
		}

		$this->prepared = $this->db->prepare($query);

		if (count($this->lastFields) > 0){
			if (count($this->lastFields) == count($this->lastParams)){
				$condition = array_combine($this->lastFields,$this->lastParams);
			} else {
				throw new Exception('Wrong parameter count.');
			}
		} else if (!$this->paramArray){
			$condition = array();
		}

		$this->execute($condition);
	}

	public function count($table,$params = array()){
		$this->paramArray = false;
		if (!trim($table)){
			throw new Exception('Invalid Table.');
		} else {
			$table = $this->anti_injection($table);
		}
		$this->lastAction = 'count';

		$query = "SELECT COUNT(*) FROM $table";
		$this->lastFields = array();
		$this->lastParams = array();

		if (is_array($params) && !empty($params)){
			foreach ($params as $field => $value){
				$field = $this->anti_injection($field);
				$params[$field] = $this->anti_injection($value);
			}
			$cond = $this->conditions($params);
			$query .= ' WHERE '.implode(' AND ',$cond);
		}
		$this->prepared = $this->db->prepare($query);

		if (count($this->lastFields) > 0){
			if (count($this->lastFields) == count($this->lastParams)){
				$params = array_combine($this->lastFields,$this->lastParams);
			} else {
				throw new Exception('Wrong parameter count.');
			}
		} else if (!$this->paramArray){
			$params = array();
		}

		$this->execute($params);

		return $this->prepared->fetchColumn();
	}

	/*	Execute the prepared query and check for errors */
	private function execute($params = array()){

		#echo '<div style="display:none">';
		#echo $this->prepared->queryString.'<br />';
		#var_dump($params);
		#echo '</div>';
		#echo '<br />';

		if ($this->prepared == null){
			throw new Exception('Query not found.');
		}

		$this->prepared->execute($params);
		// Check for query errors
		if ($this->prepared->errorCode() != '00000'){
			if ($this->debug){
				$this->prepared->debugDumpParams();
				$error = $this->prepared->errorInfo();
				var_dump($error);
				die();
			}
		}
	}

	/*	Return the query contents */
	private function fetchValues(){

		if ($this->toClass && $this->class != ''){
			$objects = array();
			if ($this->rowCount() === 1){
				$objects[] = $this->prepared->fetchObject($this->class);
			} else {
				while ($object = $this->prepared->fetchObject($this->class)){
					$objects[] = $object;
				}
			}
			return $objects;
		} else {
			$results = array();

			if ($this->rowCount() === 1){
				$results = array($this->prepared->fetch(PDO::FETCH_ASSOC));
			} else {
				while ($rs = $this->prepared->fetch(PDO::FETCH_ASSOC)){
					$results[] = $rs;
				}
			}

			return $results;
		}
	}

	/*	Last insert ID */
	public function lastID(){
		if ($this->db == null || $this->prepared == null || $this->lastAction != 'insert'){
			throw new Exception('Query not found.');
		} else {
			return $this->db->lastInsertId();
		}
	}

	/*	Number of rows affected by the last query */
	public function rowCount(){
		if ($this->db == null || $this->prepared == null){
			throw new Exception('Query not found.');
		} else {
			return $this->prepared->rowCount();
		}
	}

	/*	Number of rows stored in the table */
	public function tableCount($table){
		if ($this->db == null){
			throw new Exception('Query not found.');
		} else {
			if (!trim($table)){
				throw new Exception('Invalid Table.');
			} else {
				$table = $this->anti_injection($table);
			}
			
			$prepared = $this->db->prepare('SELECT COUNT(*) FROM :table');
			$prepared->execute(array(':table' => $table));

			// Check for query errors
			if ($prepared->errorCode() != '00000'){
				if ($this->debug){
					$this->prepared->debugDumpParams();
				}
				$error = $prepared->errorInfo();
				throw new Exception($error[2]);
			}
			return $prepared->fetchColumn();
		}
	}

	/*	Dynamically loads an existent class and populate it
		Notes:
		*	The selected table must have defined the constant "const TABLE = 'table_name'"
		**	Be sure that the required class was properly included in the script first
	*/
	public function loadClass($class,$condition = array(),$orderby = null,$start = null,$qtd = null){
		
		$this->toClass = true;
		$this->class = $this->anti_injection($class);

		if (is_array($condition) && !empty($condition)){
			foreach ($condition as $field => $value){
				if ($value === null || (is_numeric($field) && !$value)){
					unset($condition[$field]);
					continue;
				}
			}
		}
		if (empty($condition)){
			$condition = null;
		}

		$table = constant("$class::TABLE");

		$class = $this->select('',$table,$condition,null,null,$orderby,$start,$qtd);

		// Reset fields to prevent problem on next queries
		$this->toClass = false;
		$this->class = "";

		return $class;
	}

	private function conditions($array){
		$cond = array();

		foreach ($array as $field => $value){
			if (is_array($value)){
				$this->paramArray = true;
			}
		}

		foreach ($array as $field => $value){

			if (is_array($value)){
				$aux = array();
				foreach ($value as $val){
					$aux[] = implode(' AND ',$this->conditions(array($field => $val)));
				}
				$aux = '('.implode(' OR ',$aux).')';
				$cond[] = $aux;
				continue;
			}

			$field = $this->anti_injection($field);
			if (preg_match('/regexp/i', $value) && !!$value){
				$value = $this->anti_injection($value,array('*'));
			} else {
				$value = $this->anti_injection($value);
			}

			if ($value === null || strtolower($value) == 'null'){
				$cond[] = $field .' IS NULL';
			} else if ($value === ''){
				$cond[] = '('.$field .' = "" OR '.$field .' IS NULL)';
			} else if (strtolower($value) == '!null'){
				$cond[] = '('.$field .' != "" AND '.$field .' IS NOT NULL)';
			} else if (preg_match('/regexp/i', $value) && !!$value){
				$cond[] = $field .' '.$value;
			} else if (preg_match('/(^%|%$)/', $value) && !!$value){
				$this->lastParams[] = $value;

				if ($this->paramArray){
					$cond[] = $field .' LIKE ?';
				} else {
					$cond[] = $field .' LIKE :'.$field;
				}

				if (!in_array(':'.$field,$this->lastFields)){
					$this->lastFields[] = ':'.$field;
				}
			} else if (preg_match('/^(<=?|>=?)[\s]*[\d]+(\.[\d]+)?$/', $value,$found)){
				$aux = str_replace($found[1],'',$value);
				$aux = trim($aux);

				if ($this->paramArray){
					$cond[] = $field .' '.$found[1].' ?';
				} else {
					$cond[] = $field .' '.$found[1].' :'.$field;
				}
				$this->lastParams[] = $aux;

				if (!in_array(':'.$field,$this->lastFields)){
					$this->lastFields[] = ':'.$field;
				}
			} else if (preg_match('/^(<=?|>=?)[\s]*/', $value,$found)){
				$aux = str_replace($found[1],'',$value);
				$aux = trim($aux);

				if ($this->paramArray){
					$cond[] = $field .' '.$found[1].' ?';
				} else {
					$cond[] = $field .' '.$found[1].' :'.$field;
				}
				$this->lastParams[] = $aux;

				if (!in_array(':'.$field,$this->lastFields)){
					$this->lastFields[] = ':'.$field;
				}
			} else if (preg_match('/^!(.*)$/', $value)){
				$str = substr($value,1);

				if ($str === false){
					$this->lastParams[] = "";
				} else {
					$this->lastParams[] = $str;
				}

				if ($this->paramArray){
					$cond[] = $field .' != ?';
				} else {
					$cond[] = $field .' != :'.$field;
				}

				if (!in_array(':'.$field,$this->lastFields)){
					$this->lastFields[] = ':'.$field;
				}
			} else {
				$this->lastParams[] = $value;

				if ($this->paramArray){
					$cond[] = $field .' = ?';
				} else {
					$cond[] = $field .' = :'.$field;
				}

				if (!in_array(':'.$field,$this->lastFields)){
					$this->lastFields[] = ':'.$field;
				}
			}
		}
		if ($this->paramArray){
			$this->lastFields = array();
		}

		return $cond;
	}

	private function set($array){
		$cond = array();

		foreach ($array as $field => $value){

			$field = $this->anti_injection($field);

			if ($value === null){
				$value = NULL;
			} else {
				$value = $this->anti_injection($value);
			}

			$this->lastParams[] = $value;
			$cond[] = $field .' = :'.$field;

			if (!in_array(':'.$field,$this->lastFields)){
				$this->lastFields[] = ':'.$field;
			}
		}
		return $cond;
	}

	public function __clone(){
		$this->prepared       = null;
		$this->lastAction     = "";
		$this->lastFields     = array();
		$this->lastParams     = array();
		$this->lastCondFields = array();
		$this->lastCondParams = array();
		$this->paramArray	  = false;
	}
}
?>