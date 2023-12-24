#!/Users/martijnengler/.bin/php
<?php
// https://adventofcode.com/2021/day/13
define("TEST_MODE",       true);
define('AOC_INPUT_FILE',  "");
define('SPLIT_CHARACTER', ',');

require_once __DIR__ . '/../init.php';

function parseInput($lines)
{
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
			// note that col/row is reversed from what I usually do!
			$dots[] = ['col' => $line[0], 'row' => $line[1]];
		}

		else
		{
			$parts = explode('=', $line[0]);
			$axis  = substr($parts[0], -1);
			$value = $parts[1];
			$folds[] = ['axis' => $axis, 'value' => $value];
		}
	}

	return [$dots, $folds];
}

function buildBasicMatrix($dots)
{
	$matrix = [];
	// +1 to account for zero indexing
	$row_count = max(array_column($dots, 'row')) + 1;
	$col_count = max(array_column($dots, 'col')) + 1;

	$sample_row = array_fill(0, $col_count, '.');
	for($i = 0; $i < $row_count; $i++)
	{
		$matrix[] = $sample_row;
	}

	return $matrix;
}

function makeDots($matrix, $dots)
{
	foreach($dots as $d)
	{
		$matrix[$d['row']][$d['col']] = '#';
	}
	return $matrix;
}

function mergeLine(array $a, array $b)
{
	foreach($a as $k => &$v)
	{
		if($v === '#' || $b[$k] === '#')
		{
			$v = '#';
		}
	}
	return $a;
}

function fold_y($matrix, $line_index)
{
	$bottom = array_splice($matrix, $line_index);
	// remove the top line, that's the fold line
	array_pop($bottom);

	$i = 0;
	while($line = array_pop($bottom))
	{
		$matrix[$i] = mergeLine($line, $matrix[$i]);
		$i++;
	}

	return [$matrix, $bottom];
}

function fold_x($matrix, $col_index){}

function fold($matrix, $fold)
{
	if($fold['axis'] === 'y')
	{
		return fold_y($matrix, $fold['value']);
	}
	return fold_x($matrix, $fold['value']);
}

[$dots, $folds] = parseInput($lines);
$matrix = buildBasicMatrix($dots);
$matrix = makeDots($matrix, $dots);
[$matrix, $bottom] = fold($matrix, $folds[0]);

showMatrix($matrix);
