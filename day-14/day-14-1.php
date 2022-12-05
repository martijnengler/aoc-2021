#!/Users/martijnengler/.bin/php
<?php
// https://adventofcode.com/2021/day/14
define("TEST_MODE", true);
require_once __DIR__ . '/../init.php';
$template = array_shift($lines);
array_shift($lines);

$mapping = [];
foreach($lines as $line)
{
	list($a,$b) = explode(" -> ", $line);
	$mapping[$a] = $b;
}
print_r($mapping);
