<?php

ini_set('display_errors', true);
ini_set('display_startup_errors', true);
error_reporting(-1);

define("LIBS_PATH", realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'libs'));
set_include_path(LIBS_PATH);

require_once "Application.php";
/*require_once "Application/Model.php";
*/
try
{
	Application::setupLoader();

	Application\Model::connect(array(
		'host' => 'ec2-184-72-238-68.compute-1.amazonaws.com',
		'port' => '5432',
		'user' => 'eopnkqfceewvii',
		'password' => 'test1234',
		'dbname' => 'd28ncdd5aodkib',
	));

	Application\Persistent::init();

	$application = new Application();
	$application->run();
	echo $application->render();
}
catch(\Exception $ex)
{
	header('HTTP/1.0 404 Not Found');
	print $ex->getMessage();
}

