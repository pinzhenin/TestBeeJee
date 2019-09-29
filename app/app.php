<?
require_once( 'models/modelUser.php' );

class App {

	public static $app;

	public static function init( $config ) {
		session_start();
		self::$app = new stdClass;
		self::$app->config = $config;
		self::$app->db = new PDO(
			"mysql:host={$config['db']['host']};dbname={$config['db']['database']}", $config['db']['username'], $config['db']['password']
		);
		self::$app->user =
			isset( $_SESSION['user.id'] ) ? modelUser::find( $_SESSION['user.id'] ) : NULL;
	}

	public static function controller() {
		$requestUri = $_SERVER['REQUEST_URI'];
		list( $null, $controllerId, $actionId ) = preg_split( '|[/?]+|', $requestUri );

		$template = '/^[[:alpha:]][[:alnum:]]*$/';
		if( preg_match( $template, $controllerId ) && preg_match( $template, $actionId ) ) {
			$controllerClass = 'controller' . ucfirst( $controllerId );
			if( file_exists( __DIR__ . "/{$controllerClass}.php" ) ) {
				require_once( "{$controllerClass}.php" );
				$controller = new $controllerClass( $actionId );
				return $controller;
			}
		}

		// нет запрашиваемого контроллера
		require_once( "Controller.php" );
		$controller = new Controller( NULL );
		$controller->error404();
		exit;
	}

}
