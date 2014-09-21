<?php
/**
 * Boot loader
 *
 * Static run settings like what configuration is going to be loaded during run time
 */

ini_set('display_errors', true);

define('FUZZ_PATH_LIBS', __DIR__ . '/libs');

// autoloader to load script files
require_once FUZZ_PATH_LIBS . '/Loader.php';
Fuzz\Loader::shared()->addNamespacePath('Fuzz', FUZZ_PATH_LIBS);
