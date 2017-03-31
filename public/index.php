<?php

date_default_timezone_set( 'UTC' );

const DEFAULT_APP = 'Frontend';

if ( !isset( $_GET[ 'app' ] ) || !file_exists( __DIR__ . '/../App/' . $_GET[ 'app' ] ) ) {
	$_GET = DEFAULT_APP;
}

require __DIR__ . '/../lib/OCFram/SplClassLoader.php';


$OCFramLoader = new SplClassLoader( 'OCFram', __DIR__ . '/../lib' );
$OCFramLoader->register();

$appLoader = new SplClassLoader( 'App', __DIR__ . '/..' );
$appLoader->register();

$modelLoader = new SplClassLoader( 'Model', __DIR__ . '/../lib/vendors' );
$modelLoader->register();

$entityLoader = new SplClassLoader( 'Entity', __DIR__ . '/../lib/vendors' );
$entityLoader->register();

$formBuilderLoader = new SplClassLoader( 'FormBuilder', __DIR__ . '/../lib/vendors' );
$formBuilderLoader->register();

$appClass = 'App\\' . $_GET[ 'app' ] . '\\' . $_GET[ 'app' ] . 'Application';

/** @var OCFram\Application $app */
$app = new $appClass;
if ( !$app->user()->isAuthenticated() ) {
	$app->user()->setRole( \OCFram\User::DEFAULTROLE );
}
$app->run();