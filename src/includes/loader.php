<?php
/**
 * Autoloader function
 * Only slightly useful. Would have to move all the provided classes into my folder, or do the naming structure thing.
 * As there is probably automated testing, we are not changing filenames or locations
 */
spl_autoload_register(function ($class) {
	require dirname(__DIR__) . "/classes/{$class}.php";
});