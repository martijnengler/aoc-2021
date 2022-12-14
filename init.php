<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/../lib/php/libinit.php';

if(isset($argv[1]) && strlen($argv[1]) > 0)
{
	$input_filename = $argv[1];
}
elseif(defined("AOC_INPUT_FILE") && strlen(AOC_INPUT_FILE) > 0)
{
	$input_filename = AOC_INPUT_FILE;
}
else
{
	$input_filename = dirname($argv[0]) . DIRECTORY_SEPARATOR . '/';
	$input_filename .= (defined('TEST_MODE') && TEST_MODE) ? 'test' : 'input';
}
$input = file_get_contents($input_filename);
$lines = file($input_filename, FILE_IGNORE_NEW_LINES);
$original_lines = $lines;

if(defined("SPLIT_CHARACTER") && !is_null(SPLIT_CHARACTER))
{
	$lines = splitArrayValues(SPLIT_CHARACTER, $lines);

	// set this for legacy reasons:
	$split_lines = $lines;
}

$climate = new League\CLImate\CLImate;
