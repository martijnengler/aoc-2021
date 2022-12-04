#!/Users/martijnengler/.bin/php
<?php
// https://adventofcode.com/2021/day/10
define("TEST_MODE", false);
require_once __DIR__ . '/../init.php';

function isLineComplete($str)
{
	$chars = str_split($str);
	asort($chars);

	if(in_array('{', $chars) && !in_array('}', $chars))
	{
		return false;
	}

	if(in_array('[', $chars) && !in_array(']', $chars))
	{
		return false;
	}

	if(in_array('(', $chars) && !in_array(')', $chars))
	{
		return false;
	}

	if(in_array('<', $chars) && !in_array('>', $chars))
	{
		return false;
	}

	return true;
	//print_r(array_count_values($chars));
}

$openers = [
	'{' => 0,
	'[' => 0,
	'(' => 0,
	'<' => 0,
];

$closers = [
	'}' => '{',
	']' => '[',
	')' => '(',
	'>' => '<',
];

$score = [
	")" => 3,
	"]" => 57,
	"}" => 1197,
	">" => 25137,
];

$stack = [];
$incomplete_lines = [];
$total = 0;
foreach($lines as $key => $str)
{
	$chars = str_split($str);
	foreach($chars as $char)
	{
		if(in_array($char, array_keys($openers)))
		{
			$stack[] = $char;
		}
		else
		{
			$popped = array_pop($stack);
			if($popped !== $closers[$char])
			{
				continue 2;
			}
		}
	}

	$incomplete_lines[] = $str;
}

$results = [];
$score = 0;
$total = 0;
$score_map = array_flip(['', ')', ']', '}', '>']);
print_r($score_map);
foreach($incomplete_lines as $key => $str)
{
	$total = 0;
	$stack = [];
	$chars = str_split($str);
	foreach($chars as $char)
	{
		if(in_array($char, array_keys($openers)))
		{
			$stack[] = $char;
		}
		else
		{
			$popped = array_pop($stack);
		}
	}
	$reversed = array_reverse($stack);
	$closed = array_map(fn($x) => array_flip($closers)[$x], $reversed);
	$score = 0;
	foreach($closed as $val)
	{
		$score = $score_map[$val];
		$total *= 5;
		$total += $score;
	}

	$results[] = $total;
}

$cnt = count($results);

natsort($results);
print_r($results);
print_r(array_slice($results, floor($cnt/2), 1));
