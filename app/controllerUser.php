<?
require_once( 'Controller.php' );
require_once( 'models/modelUser.php' );

class controllerUser extends Controller {

	public function actionLogin() {
		if( empty( $_POST['user'] ) ) {
			return $this->render( NULL, 'viewUserLogin' );
		}
		$user = new modelUser();
		$user->attributes( $_POST['user'] );
		if( $user->auth() ) {
			$user->login();
			return $this->render( $user, 'viewUserWelcome' );
		}
		return $this->render( $user, 'viewUserLogin' );
	}

	public function actionLogout() {
		global $app;
		$user = $app->user;
		if( isset( $user ) ) {
			$user->logout();
		}
		return $this->render( $user, 'viewUserLogout' );
	}

}
