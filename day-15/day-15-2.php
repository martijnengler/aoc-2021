#!/Users/martijnengler/.bin/php
<?php
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


$blocks = [];

foreach($lines as &$line)
{
	$copies = [];
	$copy_line = $line;

	$copy_line = copyRow($copy_line);
	$copies[] = $copy_line;
	$copy_line = copyRow($copy_line);
	$copies[] = $copy_line;
	$copy_line = copyRow($copy_line);
	$copies[] = $copy_line;
	$copy_line = copyRow($copy_line);
	$copies[] = $copy_line;

	$line =  array_merge($line, arrayFlatten($copies));
}

$current_block = $lines;
foreach($current_block as $row)
{
	$copy_line = copyRow($row);
	$new_block[] = $copy_line;
}
$current_block = array_merge($current_block, $new_block);

showMatrix($current_block);

exit;

$grid = buildGridFromArray($lines);

$start = new Node(0,0);
$goal  = new Node(count($grid->grid) - 1, count($grid->grid) - 1);

list($came_from, $cost_so_far) = dijkstra_search($grid, $start, $goal);

draw_grid(
	$grid,
	[
		'path' => reconstruct_path($came_from, $start, $goal)
	]
);
