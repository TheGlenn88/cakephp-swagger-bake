<?php
declare(strict_types=1);

/**
 * Test suite bootstrap for SwaggerBake.
 *
 * This function is used to find the location of CakePHP whether CakePHP
 * has been installed as a dependency of the plugin, or the plugin is itself
 * installed as a dependency of an application.
 */
$findRoot = function ($root) {
    do {
        $lastRoot = $root;
        $root = dirname($root);
        if (is_dir($root . '/vendor/cakephp/cakephp')) {
            return $root;
        }
    } while ($root !== $lastRoot);

    throw new Exception("Cannot find the root of the application, unable to run tests");
};
$root = $findRoot(__FILE__);
unset($findRoot);

chdir($root);

require_once $root . '/vendor/autoload.php';

define('SWAGGER_BAKE_TEST_ROOT', dirname(__DIR__));
define('SWAGGER_BAKE_TEST_APP', SWAGGER_BAKE_TEST_ROOT . DS . 'tests' . DS . 'test_app');

ini_set('error_reporting', 'E_ALL ^ E_DEPRECATED');

$webRoot = SWAGGER_BAKE_TEST_APP . DS . 'webroot';
if (!directoryExists($webRoot)) {
    mkdir($webRoot);
}
$swaggerJsonFile = $webRoot . DS . 'swagger.json';
if (!file_exists($swaggerJsonFile)) {
    touch($swaggerJsonFile);
}

/**
 * Define fallback values for required constants and configuration.
 * To customize constants and configuration remove this require
 * and define the data required by your plugin here.
 */
require_once $root . '/vendor/cakephp/cakephp/tests/bootstrap.php';

if (file_exists($root . '/config/bootstrap.php')) {
    require $root . '/config/bootstrap.php';
    return;
}

