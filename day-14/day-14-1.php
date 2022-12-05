#!/Users/martijnengler/.bin/php
<?php

/*
$a = [1,2,3];
array_splice($a, 1, 0, '4');
print_r($a);
exit;
 */

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

$do_steps = 1 ;
for($i = 0; $i < $do_steps; $i++)
{
	$geefditeennaam = 0;
	$splices_to_do = [];
	$chars = str_split($template);
	foreach($chars as $key => $val)
	{
		if(!isset($chars[$key+1]))
			break;

		$str = $val . $chars[$key+1];
		if(isset($mapping[$str]))
		{
			$geefditeennaam++;
			$splices_to_do[$key + $geefditeennaam] = $mapping[$str];
		}
	}

	foreach($splices_to_do as $offset => $val)
	{
		array_splice($chars, $offset, 0, $val);
	}
	print_r(implode("", $chars));
}
