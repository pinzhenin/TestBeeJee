<?
/**
 * Базовый класс для моделей
 */
class Model {

	public $id;
	protected $errors = [];
	protected static $tableName;
	protected static $attributes = [];
	protected static $massLoadAttributes = [];

	public function getErrors() {
		return $this->errors;
	}

	public function attributes( $array ) {
		foreach( static::$massLoadAttributes as $attribute ) {
			if( isset( $array[$attribute] ) ) {
				$this->$attribute = $array[$attribute];
			}
		}
	}

	public function save() {
		return empty( $this->id ) ? $this->insert() : $this->update();
	}

	public function update() {
		$this->validate();
		if( $this->errors ) {
			return;
		}
		$query = 'UPDATE {tableName} SET {properties} WHERE `id` = :id';
		$param = [];
		$input = [];
		foreach( static::$attributes as $attribute ) {
			if( isset( $this->$attribute ) ) {
				$param[$attribute] = "`{$attribute}` = :{$attribute}";
				$input[':' . $attribute] = $this->$attribute;
			}
		}
		unset( $param['id'] );
		$properties = implode( ', ', $param );
		$query = preg_replace( '/{tableName}/', '`' . static::$tableName . '`', $query );
		$query = preg_replace( '/{properties}/', $properties, $query );
		$db = App::$app->db;
		$sth = $db->prepare( $query );
		$sth->execute( $input );
		$rc = $sth->execute( $input );
		return $rc;
	}

	public function insert() {
		$this->validate();
		if( $this->errors ) {
			return;
		}
		$query = 'INSERT INTO {tableName} SET {properties}';
		$param = [];
		$input = [];
		foreach( static::$attributes as $attribute ) {
			if( isset( $this->$attribute ) ) {
				$param[$attribute] = "`{$attribute}` = :{$attribute}";
				$input[':' . $attribute] = $this->$attribute;
			}
		}
		$properties = implode( ', ', $param );
		$query = preg_replace( '/{tableName}/', '`' . static::$tableName . '`', $query );
		$query = preg_replace( '/{properties}/', $properties, $query );
		$db = App::$app->db;
		$sth = $db->prepare( $query );
		$rc = $sth->execute( $input );
		return $rc;
	}

	public static function find( $id ) {
		$query = 'SELECT * FROM {tableName} WHERE `id` = :id';
		$query = preg_replace( '/{tableName}/', '`' . static::$tableName . '`', $query );
		$db = App::$app->db;
		$sth = $db->prepare( $query );
		$rc = $sth->execute( [ ':id' => $id ] );
		if( !$rc ) {
			return NULL;
		}
		$hash = $sth->fetch( PDO::FETCH_ASSOC );
		if( empty( $hash ) ) {
			return NULL;
		}
		$task = new static();
		foreach( static::$attributes as $attribute ) {
			$task->$attribute = $hash[$attribute];
		}
		return $task;
	}

	public static function findAll( $param = [] ) {
		$query = 'SELECT * FROM {tableName}';
		$query = preg_replace( '/{tableName}/', '`' . static::$tableName . '`', $query );
		if( isset( $param['order'] ) && in_array( $param['order'][0], static::$attributes ) ) {
			$query .= " ORDER BY `{$param['order'][0]}` {$param['order'][1]}";
		}
		if( isset( $param['offset'] ) && isset( $param['limit'] ) ) {
			$query .= " LIMIT {$param['offset']},{$param['limit']}";
		}
		elseif( isset( $param['limit'] ) ) {
			$query .= " LIMIT {$param['limit']}";
		}
		$db = App::$app->db;
		$sth = $db->prepare( $query );
		$rc = $sth->execute();
		if( !$rc ) {
			return [];
		}
		$list = $sth->fetchAll( PDO::FETCH_ASSOC );
		if( empty( $list ) ) {
			return [];
		}
		$tasks = [];
		foreach( $list as $hash ) {
			$task = new static();
			foreach( static::$attributes as $attribute ) {
				$task->$attribute = $hash[$attribute];
			}
			$tasks[] = $task;
		}
		return $tasks;
	}

	public static function countAll() {
		$query = 'SELECT COUNT(1) AS `count` FROM {tableName}';
		$query = preg_replace( '/{tableName}/', '`' . static::$tableName . '`', $query );
		$db = App::$app->db;
		$sth = $db->prepare( $query );
		if( $sth && $sth->execute() ) {
			$hash = $sth->fetch( PDO::FETCH_ASSOC );
			return $hash['count'];
		}
		return NULL;
	}

	public function validate() {
		$this->errors = [];
		foreach( static::$attributes as $attribute ) {
			$validateMethod = 'validate' . ucfirst( $attribute );
			if( method_exists( $this, $validateMethod ) ) {
				$this->$validateMethod();
			}
		}
	}

	public function validateId() {
		$id = (int) $this->id;
		if( $id > 0 ) {
			$this->id = $id;
		}
		elseif( $id === 0 ) {
			$this->id = NULL;
		}
		else {
			$this->errors['id'] = 'Ошибка атрибута «id»';
		}
	}

}
