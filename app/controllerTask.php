<?
require_once( 'Controller.php' );
require_once( 'models/modelTask.php' );

class controllerTask extends Controller {

	public $layout = 'viewLayout';

	public function actionAdd() {
		$data = isset( $_POST['task'] ) ? $_POST['task'] : [];
		if( empty( $data ) ) {
			return $this->render( NULL, 'viewTaskAdd' );
		}
		$task = new modelTask();
		$task->attributes( $data );
		$task->save();
		return $this->render( $task, 'viewTaskAdd' );
	}

	public function actionEdit() {
		$user = App::$app->user;
		if( !isset( $user ) ) {
			$this->error401();
			return;
		}
		if( isset( $_POST['task'] ) ) {
			$task = modelTask::find( $_POST['task']['id'] );
			if( empty( $task ) ) {
				$this->error404();
				return;
			}
			$taskTextOrig = $task->taskText;
			$task->attributes( $_POST['task'] );
			$task->taskStatus = $_POST['task']['taskStatus'];
			$task->validate();
			$taskTextEdit = $task->taskText;
			if( $taskTextOrig !== $taskTextEdit ) {
				$task->editedByAdmin = TRUE;
			}
			if( $task->save() ) {
				$success = TRUE;
			}
			return $this->render( [ 'task' => $task, 'success' => $success ], 'viewTaskEdit' );
		}
		elseif( isset( $_GET['id'] ) ) {
			$task = modelTask::find( $_GET['id'] );
			if( empty( $task ) ) {
				$this->error404();
				return;
			}
			return $this->render( [ 'task' => $task ], 'viewTaskEdit' );
		}
		else {
			$this->error404();
			return;
		}
	}

	public function actionDone() {
		$user = App::$app->user;
		if( !isset( $user ) ) {
			$this->error401();
			return;
		}
		$id = $_GET['id'];
		$task = modelTask::find( $id );
		$task->taskStatus = 'выполнено';
		$task->save();
		return $this->render( $task, 'viewTaskDone' );
	}

	public function actionList() {
		// page
		$page = isset( $_GET['page'] ) ? ( int ) $_GET['page'] : 1;
		if( $page < 1 ) {
			$page = 1;
		}
		// sort
		if( isset( $_GET['sort'] ) && ( $_GET['sort'] == $_SESSION['sortColumn'] ) ) {
			$_SESSION['sortColumn'] = $_GET['sort'];
			$_SESSION['sortDirect'] = ($_SESSION['sortDirect'] == 'ASC') ? 'DESC' : 'ASC';
		}
		elseif( isset( $_GET['sort'] ) ) {
			$_SESSION['sortColumn'] = $_GET['sort'];
			$_SESSION['sortDirect'] = 'ASC';
		}
		$order = isset( $_SESSION['sortColumn'] ) ? [ $_SESSION['sortColumn'], $_SESSION['sortDirect'] ] : NULL;
		// models
		$count = modelTask::countAll();
		$tasks = modelTask::findAll( [ 'offset' => ($page - 1) * 3, 'limit' => 3, 'order' => $order ] );
		return $this->render(
			[
				'tasks' => $tasks,
				'count' => $count,
				'page' => $page,
				'sort' => $order
			],
			'viewTaskList'
		);
	}

}
