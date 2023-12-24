#!/Users/martijnengler/.bin/php
<?php
// https://adventofcode.com/XXXYEARXXX/day/XXXDAYXXX
define("TEST_MODE",       true);
define('AOC_INPUT_FILE',  "");
define('SPLIT_CHARACTER', null);

require_once __DIR__ . '/../init.php';

$lines = array_map(fn($x) => $x, $lines);
$lines = array_map(function($x){
	return $x;
}, $lines);

print_r($lines);

foreach($lines as $line)
{

}
