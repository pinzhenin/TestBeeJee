<?

class App {

	public $config;
	public $db;
	public $user;

	public function __construct( $config ) {
		session_start();
		$this->config = $config;
		$this->db = new PDO(
			"mysql:host={$config['db']['host']};dbname={$config['db']['database']}", $config['db']['username'], $config['db']['password']
		);
	}

	public function controller() {
		$controller = NULL;

		$requestUri = $_SERVER['REQUEST_URI'];
		list( $null, $controllerId, $actionId ) = preg_split( '|[/?]+|', $requestUri );

		$template = '/^[[:alpha:]][[:alnum:]]*$/';
		if( preg_match( $template, $controllerId ) && preg_match( $template, $actionId ) ) {
// Проверить, что контроллер существует
			$controllerClass = 'controller' . ucfirst( $controllerId );
			require_once( "{$controllerClass}.php" );
			$controller = new $controllerClass( $actionId );
		}

		return $controller;
	}

}
