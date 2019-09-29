<?
ini_set( 'error_reporting', E_ALL );
ini_set( 'display_errors', 1 );
ini_set( 'display_startup_errors', 1 );

require_once( 'app/config/config.php' );
require_once( 'app/app.php' );
require_once( 'app/models/modelUser.php' );

$app = new App( $config );
$app->user = isset( $_SESSION['user.id'] ) ? modelUser::find( isset( $_SESSION['user.id'] ) ) : NULL;
$controller = $app->controller();
$result = $controller->doAction();
echo $result;
?>
