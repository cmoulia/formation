<?php
/**
 * Created by PhpStorm.
 * User: cmoulia
 * Date: 27/02/2017
 * Time: 16:32
 */


use OCFram\SplClassLoader;

require '../lib/OCFram/SplClassLoader.php';


$OCFramLoader = new SplClassLoader( 'OCFram', '/lib' );
$OCFramLoader->register();