<?php
// WARNING
//
// Please, do not actually write code like this.
// I'm just having some fun, but don't do this for real code, okay?
// (this goes for the whole repo actually)

$input = file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES);
$spots = array_fill(0, 1000, array_fill(0, 1000, '0'));

function addVentSpot(array &$spots, int $a, int $b, int $other_point, string $direction): void
{
	for($i = min($a,$b); $i <= max($a, $b); $i++)
		($direction === 'vertical') ? $spots[$i][$other_point]++ : $spots[$other_point][$i]++;
}

function diagonal(array &$spots, $coordinates): void
{
	extract($coordinates);

	list($diff_x, $diff_y) = array_map(fn($x) => $coordinates['a_'.$x] - $coordinates['b_'.$x], ['x', 'y']);
	list($x_dir, $y_dir) = array_map(fn(int $x) => $x > 0 ? -1 : 1, [$diff_x, $diff_y]);

	for($i = 0; $i <= abs($diff_x); $i++)
	{
		$spots[$a_y][$a_x]++;
		$a_x += $x_dir;
		$a_y += $y_dir;
	}
}

foreach($input as $line)
{
	preg_match('/^(?<a_x>\d+),(?<a_y>\d+) -> (?<b_x>\d+),(?<b_y>\d+)/', $line, $matches);
	$coordinates = array_map(fn(string $x) => (int)$x, array_filter($matches, fn(int|string $x) => is_string($x), ARRAY_FILTER_USE_KEY));

	// living on the edge
	extract($coordinates);

	($a_x !== $b_x && $a_y !== $b_y)
		 ? diagonal($spots, $coordinates)
		:	(($a_x === $b_x) ? addVentSpot($spots, $a_y, $b_y, $a_x, 'vertical') : addVentSpot($spots, $a_x, $b_x, $a_y, 'horizontal'));
}

printf("%d\n", array_reduce($spots, fn($a,$b) => $a + count(array_filter($b, fn(int $x) => $x>=2), 0)));
