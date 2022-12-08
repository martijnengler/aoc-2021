<?php
// https://www.redblobgames.com/pathfinding/a-star/introduction.html
// https://www.redblobgames.com/pathfinding/a-star/implementation.html

use Ds\Queue;
use Ds\PriorityQueue;
use Ds\Set;

require_once 'day-15-1.php';

function graphcost($a, $b)
{
	return $a->value + $b->value;
}

$start = $lines[0][0];
$frontier = new PriorityQueue();
$frontier->push($lines[0][0], 0);
$came_from = [];
$cost_so_far = [];
$came_from[$lines[0][0]->asArrayKey()] = null;
$cost_so_far[$start->asArrayKey()] = 0;
$goal = $lines[3][3];

while(!empty($frontier->toArray()))
{
	$current = $frontier->pop();

	if($current == $goal)
		break;

	// only horizontal / vertical, not diagonal
	// might need to make that the default actually
	$adj = adjacentInArray($lines, $current->row, $current->col, true, true, false);
	foreach($adj as $next)
	{
		$new_cost = $cost_so_far[$current->asArrayKey()] + graphcost($current, $next);
		if(
			!in_array($next->asArrayKey(), array_keys($cost_so_far))
			|| $new_cost < $cost_so_far[$next->asArrayKey()]
		)
		{
			$cost_so_far[$next->asArrayKey()] = $new_cost;
			$priority = $new_cost;
			$frontier->push($next, $priority);
			$came_from[$next->asArrayKey()] = $current;
		}
	}
}

$current = $goal;
$path = [];
while($current != $start)
{
	$path[] = $current;
	$current = $came_from[$current->asArrayKey()];
}
$path[] = $start;
print implode(" => \n", array_reverse($path));
exit;
# optional

/*
frontier = PriorityQueue()
frontier.put(start, 0)
came_from = dict()
cost_so_far = dict()
came_from[start] = None
cost_so_far[start] = 0

while not frontier.empty():
   current = frontier.get()

   if current == goal:
      break

   for next in graph.neighbors(current):
      new_cost = cost_so_far[current] + graph.cost(current, next)
      if next not in cost_so_far or new_cost < cost_so_far[next]:
         cost_so_far[next] = new_cost
         priority = new_cost
         frontier.put(next, priority)
         came_from[next] = current
*/

$original_lines = file($input_filename, FILE_IGNORE_NEW_LINES);
foreach($original_lines as &$val)
{
	$val = str_split($val);
}

/*
	Should have read this part before trying to debug:

	This loop is the essence of the graph search algorithms on this page, including A*. But how do we find the shortest path? The loop doesn’t actually construct the paths; it only tells us how to visit everything on the map.
 */
foreach($came_from as $x)
{
	if($x === null)
		continue;

	$copyLines = $original_lines;
	$o = $copyLines[$x->row][$x->col];
	$copyLines[$x->row][$x->col] = 'X';
	print_r($copyLines);
	$copyLines[$x->row][$x->col] = $o;
}
