<?php
$input = file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES);
$spots = array_fill(0, 1000, array_fill(0, 1000, '0'));

function addVentSpot(array &$spots, int $a, int $b, int $other_point, string $direction): void
{
	for($i = min($a,$b); $i <= max($a, $b); $i++)
		($direction === 'vertical') ? $spots[$i][$other_point]++ : $spots[$other_point][$i]++;
}

foreach($input as $line)
{
	preg_match('/^(?<a_x>\d+),(?<a_y>\d+) -> (?<b_x>\d+),(?<b_y>\d+)/', $line, $matches);
	$coordinates = array_map(fn(string $x) => (int)$x, array_filter($matches, fn(int|string $x) => is_string($x), ARRAY_FILTER_USE_KEY));

	// living on the edge
	extract($coordinates);

	($a_x !== $b_x ^ $a_y !== $b_y) && (($a_x === $b_x) ? addVentSpot($spots, $a_y, $b_y, $a_x, 'vertical') : addVentSpot($spots, $a_x, $b_x, $a_y, 'horizontal'));
}

printf("%d\n", array_reduce($spots, fn($a,$b) => $a + count(array_filter($b, fn(int $x) => $x>=2), 0)));
