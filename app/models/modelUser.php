<?
require_once( 'Model.php' );

/**
 * This is the model class for table "user".
 */
class modelUser extends Model {

	public $id;
	public $login;
	public $password;

	protected $errors = [];
	protected static $tableName = '_user';
	protected static $attributes = [ 'id', 'login', 'password' ];
	protected static $massLoadAttributes = [ 'login', 'password' ];

	public function auth() {
		$this->validate();
		if( $this->errors ) {
			return FALSE;
		}
		$user = self::findByLogin( $this->login, $this->password );
		if( isset( $user ) ) {
			$this->id = $user->id;
			$this->login = $user->login;
			$this->password = NULL;
			return TRUE;
		}
		$this->errors['auth'] = 'Неправильные реквизиты доступа';
		return FALSE;
	}

	public function login() {
		$_SESSION['user.id'] = $this->id;
		$_SESSION['user.login'] = $this->login;
	}

	public function logout() {
		unset( $_SESSION['user.id'] );
		unset( $_SESSION['user.login'] );
	}

	public static function findByLogin( $login, $password ) {
		$query = "SELECT * FROM {tableName} WHERE `login` = :login";
		$query = preg_replace( '/{tableName}/', '`' . self::$tableName . '`', $query );
		$db = App::$app->db;
		$sth = $db->prepare( $query );
		if( $sth && $sth->execute( [ ':login' => $login ] ) ) {
			$hash = $sth->fetch( PDO::FETCH_ASSOC );
			if( password_verify( $password, $hash['password'] ) ) {
				$user = new self();
				foreach( self::$attributes as $attribute ) {
					$user->$attribute = $hash[$attribute];
				}
				return $user;
			}
		}
		return NULL;
	}

	public function validateLogin() {
		$login = trim( $this->login );
		if( mb_strlen( $login ) ) {
			$this->login = $login;
			return;
		}
		$this->errors['login'] = 'Ошибка атрибута «login»';
	}

	public function validatePassword() {
		$password = trim( $this->password );
		if( mb_strlen( $password ) ) {
			$this->password = $password;
			return;
		}
		$this->errors['password'] = 'Ошибка атрибута «password»';
	}

}
