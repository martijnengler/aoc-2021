<?php
require_once __DIR__ . '/../lib/php/libinit.php';
$input_filename = dirname($argv[0]) . DIRECTORY_SEPARATOR . '/';
if(defined('INPUT_FILE'))
{
	$input_filename .= INPUT_FILE;
}
else
{
	$input_filename .= (defined('TEST_MODE') && TEST_MODE) ? 'test' : 'input';
}
$lines = file($input_filename, FILE_IGNORE_NEW_LINES);
