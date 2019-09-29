<?

ini_set( 'error_reporting', E_ALL );
ini_set( 'display_errors', 1 );
ini_set( 'display_startup_errors', 1 );

require( 'app/config/config.php' );
require( 'app/app.php' );

App::init( $config );
$controller = App::controller();
$result = $controller->runAction();
echo $result;
