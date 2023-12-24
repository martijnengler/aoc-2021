#!/Users/martijnengler/.bin/php
<?php
// https://adventofcode.com/2021/day/13
define("TEST_MODE",       true);
define('AOC_INPUT_FILE',  "");
define('SPLIT_CHARACTER', ',');

require_once __DIR__ . '/../init.php';

$folds_part = false;
$dots       = [];
$folds      = [];

foreach($lines as &$line)
{
	if($line[0] === '')
	{
		$folds_part = true;
		continue;
	}

	if(!$folds_part)
	{
		$dots[] = ['row' => $line[0], 'col' => $line[1]];
	}

	else
	{
		$parts = explode('=', $line[0]);
		$axis  = substr($parts[0], -1);
		$value = $parts[1];
		$folds[] = ['axis' => $axis, 'value' => $value];
	}
}

print_r($dots);
print_r($folds);
