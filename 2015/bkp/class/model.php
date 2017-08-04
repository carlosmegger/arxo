<?php
require_once('functions.php');
require_once('mysql.php');
/*
	* static is used to access contant and static content
	** constant and static content is not visible when used get_object_vars($this)
*/

class Model {

	const TABLE          = '';
	const PRIMARY_KEY    = 'id';
	protected static $db = null;

	public function __construct($args = null){
		global $system,$included;
		self::initDB();

		$class = get_class($this);
		$table = constant("$class::TABLE");
		$id = 0;

		if ($args !== null){
			if (is_array($args) && count($args) === 1){
				$id = $args[0];
			} elseif (is_numeric($args)){
				$id = intval($args);
			} elseif (property_exists($this, 'tag')) {
				$id = $args;
			}
		}
		if ($id !== 0){

			if (is_numeric($id) && intval($id) > 0 && property_exists($this, 'id')){
				$result = self::$db->select('',$table,array('id' => $id));
			} elseif (property_exists($this, 'tag')) {
				$result = self::$db->select('',$table,array('tag' => $id),null,null,null,0,1);
			} else {
				return;
			}

			if (count($result) === 1){
				$result = $result[0];
			}

			$args = get_object_vars($this);
			$keys = isset($this->images)?array_keys($this->images):array();

			foreach ($args as $var => $value){
				if ($var != 'images' && !in_array($var,$keys) && isset($result[$var])){
					$this->$var = $result[$var];
				}
			}
			if (!empty($keys)){
				foreach ($keys as $key){
					if (isset($result[$key])){
						$this->images[$key] = $result[$key];
					}
				}
			}
		}
	}

	protected static function initDB(){
		if (empty(self::$db)){
			self::$db = new DB(false,true,true);
		}
	}

	// Default getter with type convertion
	public function __get($field){
		if (isset($this->$field)){
			$val = $this->$field;
		} else {
			$val = null;
		}

		if (isset($this->images)){
			$keys = array_keys($this->images);
			if (in_array($field,$keys)){
				return $this->images[$field];
			}
		}

		if (is_numeric($val) && $val < PHP_INT_MAX){
			if (strpos($val,'.') !== false) $val = floatval($val);
			else $val = intval($val);
		} elseif (strtolower($val) == 'true' || strtolower($val) == 'false') $val = !!$val;

		return $val;
	}

	// Default setter with type convertion
	public function __set($field,$value){
		if (is_array($value)) return;
		if ($value !== null){
			if ($field != 'descricao'){
				$value = strip_tags($value);
			}
			if ($field == 'email'){
				$value = Functions::filterEmail($value);
				$value = DB::anti_injection($value);
			} elseif ($field == 'url') {
				if (strpos($value,"http://") < 0 ){
					$value = "http://".$value;
				}
				$value = DB::anti_injection($value);
			} elseif (is_numeric($value) && $value < PHP_INT_MAX){
				if (strpos($value,'.') !== false) $value = floatval($value);
				else $value = intval($value);
			} elseif (strtolower($value) == 'true' || strtolower($value) == 'false') $value = !!$value;
			elseif (is_string($value)) $value = DB::anti_injection($value);
		}

		if (isset($this->images)){
			$keys = array_keys($this->images);
			if (in_array($field,$keys)){
				$this->images[$field] = $value;
			} else {
				$this->$field = $value;
			}
		} else {
			$this->$field = $value;
		}
	}

	public static function contar(){
		throw new Exception('To be implemented.');
	}

	public function __call($name,$args){
		$keys = (isset($this->images))?array_keys($this->images):array();

		if (class_exists($name)){
			return new $name($args);
		} elseif (property_exists($this, $name)){
			if (!!$args){
				$this->__set($name,$args[0]);
			} else {
				return $this->__get($name);
			}
		} elseif (in_array($name,$keys)){
			return $this->images[$name];
		} else {
			throw new BadMethodCallException();
		}
	}

	// Default post function with default __set call
	public function post(){
		$args = get_object_vars($this);

		foreach ($args as $var => $value){
			if ($var != 'images' && $var != 'id' && $var != 'ordem'){
				$val = (isset($_POST[$var])) ? $_POST[$var] : null;
				$this->__set($var,$val);
			}
		}

		if (isset($_GET['id'])){
			$this->id = intval($_GET['id']);
		}

		if (property_exists($this,'tag')){
			$this->tag = Functions::montaTag($this->titulo);
		}
	}

	public function gravar(){

		$params = get_object_vars($this);
		$class = get_class($this);
		$table = constant("$class::TABLE");

		unset($params['images']);

		if (!$this->id){
			unset($params['id']);
			self::$db->insert($table,$params,true);
			$this->id = self::$db->lastID();
		} else {
			$params['id'] = $this->id;
			self::$db->update($table,$params,array('id' => $this->id));
		}
	}

	// Return an array of the current Class
	public static function listar($conditions = array(),$orderby = null,$limit = null,$max = null){
		throw new Exception('To be implemented.');
	}

	public function excluir(){
		if (!!$this->id){
			$class = get_class($this);
			$table = constant("$class::TABLE");
			self::$db->delete($table,array('id' => $this->id));
			return true;
		} else {
			return false;
		}
	}

	public function toArray(){
		return get_object_vars($this);
	}

	// Default class string convertion to JSON
	public function __toJSON(){
		$args = get_object_vars($this);
		return json_encode($args);
	}

	// Default class string convertion to JSON
	public function __serialize(){
		$args = get_object_vars($this);
		return serialize($args);
	}

	public function __autoload($className){
		$path = dirname(__FILE__).strtolower($class_name).'.php';

		if (is_file($path)){
			require_once($path);
		}
	}
}