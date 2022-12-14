#!/Users/martijnengler/.bin/php
<?php
// https://adventofcode.com/2021/day/15
define("TEST_MODE",       true);
define('AOC_INPUT_FILE',  "");
define('SPLIT_CHARACTER', '');

require_once __DIR__ . '/../init.php';
use MartijnEngler\Pathfinding\Node as Node;
use MartijnEngler\Pathfinding\GridWithWeights as GridWithWeights;

$grid = buildGridFromArray($lines);

$start = new Node(0,0);
$goal  = new Node(count($grid->grid) - 1, count($grid->grid) - 1);

list($came_from, $cost_so_far) = dijkstra_search($grid, $start, $goal);
printf("%d\n", array_pop($cost_so_far));
exit;

draw_grid(
	$grid,
	[
		'path' => reconstruct_path($came_from, $start, $goal)
	]
);
