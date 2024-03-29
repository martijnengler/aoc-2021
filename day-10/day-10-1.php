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
				$total += $score[$char];
				printf("%s\n", $score[$char]);
				continue 2;
			}
		}
	}
}

printf("%d\n", $total);
