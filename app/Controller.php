<?

class Controller {

	public $actionId;
	public $layout = 'viewLayout';

	public function __construct( $actionId ) {
		$this->actionId = $actionId;
	}

	public function doAction() {
		$actionMethod = 'action' . ucFirst( $this->actionId );
		if( method_exists( $this, $actionMethod ) ) {
			return $this->$actionMethod();
		}
		$this->error404();
	}

	public function render( $data, $viewFile, $layoutFile = NULL ) {
		if( empty( $layoutFile ) ) {
			$layoutFile = $this->layout;
		}
		$layout = $this->renderPartial( $data, $layoutFile );
		$view = $this->renderPartial( $data, $viewFile );
		$result = preg_replace( '/{content}/', $view, $layout );
		return $result;
	}

	public function renderPartial( $data, $viewFile ) {
		ob_start();
		include( "views/{$viewFile}.php" );
		$view = ob_get_contents();
		ob_end_clean();
		return $view;
	}

	public function error401() {
		http_response_code( 401 );
		echo $this->renderPartial( NULL, 'viewError401' );
	}

	public function error403() {
		http_response_code( 403 );
		echo $this->renderPartial( NULL, 'viewError403' );
	}

	public function error404() {
		http_response_code( 404 );
		echo $this->renderPartial( NULL, 'viewError404' );
	}

}
