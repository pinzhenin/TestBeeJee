<?
require_once( 'Model.php' );

/**
 * This is the model class for table "task".
 */
class modelTask extends Model {

	public $id;
	public $userName;
	public $userEmail;
	public $taskText;
	public $taskStatus;
	public $editedByAdmin;

	protected $errors = [];
	protected static $tableName = '_task';
	protected static $attributes = [ 'id', 'userName', 'userEmail', 'taskText', 'taskStatus', 'editedByAdmin' ];
	protected static $massLoadAttributes = [ 'userName', 'userEmail', 'taskText' ];

	public function validateUserName() {
		$userName = trim( $this->userName );
		if( mb_strlen( $userName ) ) {
			$this->userName = $userName;
			return;
		}
		$this->errors['userName'] = 'Ошибка атрибута «userName»';
	}

	public function validateUserEmail() {
		$userEmail = trim( $this->userEmail );
		if( preg_match( '/.+@.+\..+/i', $userEmail ) ) {
			$this->userEmail = $userEmail;
			return;
		}
		$this->errors['userEmail'] = 'Ошибка атрибута «userEmail»';
	}

	public function validateTaskText() {
		$taskText = trim( $this->taskText );
		if( mb_strlen( $taskText ) ) {
			$this->taskText = $taskText;
			return;
		}
		$this->errors['taskText'] = 'Ошибка атрибута «taskText»';
	}

	public function validateTaskStatus() {
		$taskStatus = trim( $this->taskStatus );
		if( in_array( $taskStatus, [ 'активно', 'выполнено' ] ) ) {
			return;
		}
		if( empty( $taskStatus ) ) {
			$this->taskStatus = 'активно';
			return;
		}
		$this->errors['taskStatus'] = 'Ошибка атрибута «taskStatus»';
	}

	public function validateEditedByAdmin() {
		return;
	}

}
