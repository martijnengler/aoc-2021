<?php
// https://www.redblobgames.com/pathfinding/a-star/introduction.html
// https://www.redblobgames.com/pathfinding/a-star/implementation.html

use Ds\Queue;
use Ds\PriorityQueue;

/*
frontier = Queue()
frontier.put(start )
reached = set()
reached.add(start)

while not frontier.empty():
	current = frontier.get()
	for next in graph.neighbors(current):
		if next not in reached:
			frontier.put(next)
			reached.add(next)
 */

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
