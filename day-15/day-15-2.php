#!/Users/martijnengler/.bin/php
<?php
ini_set('memory_limit', '4096M');

// https://adventofcode.com/2021/day/15
define("TEST_MODE",       true);
define('AOC_INPUT_FILE',  "");
define('SPLIT_CHARACTER', '');

require_once __DIR__ . '/../init.php';
use MartijnEngler\Pathfinding\Node as Node;
use MartijnEngler\Pathfinding\GridWithWeights as GridWithWeights;

function copyRow($row)
{
	return array_map(function($x){
		$range = range(1,9);
		return wrapAround($range, $step = 1, $index = $x - 1);
	}, $row);
}

foreach($lines as &$line)
{
	$copies = [];
	$copy_line = $line;

	for($i = 0; $i < 4; $i++)
	{
		$copy_line = copyRow($copy_line);
		$copies[] = $copy_line;
	}

	$line =  array_merge($line, arrayFlatten($copies));
}

// TODO: this assumed we start with a 10x10 grid,
// but for real input we start with a 100x100
//
// so we need to actually do the work to expand this the right way
$original_count = count($lines);

reset($lines);
for($i = 0; $i < 4; $i++)
{
	// do not call $something $line because of the by ref above
	foreach(array_slice($lines, $i * $original_count, $original_count) as $something)
	{
		$copy_line = copyRow($something);
		$lines[] = $copy_line;
	}
}

$grid = buildGridFromArray($lines);

$start = new Node(0,0);
$goal  = new Node(count($grid->grid) - 1, count($grid->grid) - 1);

list($came_from, $cost_so_far) = dijkstra_search($grid, $start, $goal);
printf("%d\n", array_pop($cost_so_far));
