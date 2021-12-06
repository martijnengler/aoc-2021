<?php
$input = trim(file_get_contents(__DIR__ . '/test'));
$list = array_map(fn($x) => (int)$x, explode(",", $input));
define('NUMBER_OF_DAYS', 4);
$counter = (array_fill(0, 9, 0));

foreach($list as $current_fish)
	$counter[$current_fish]++;

for($i = 1; $i <= NUMBER_OF_DAYS; $i++)
{
	$move_this = array_shift($counter);
	$counter[6] += $move_this;
	$counter[] = $move_this;
}

printf("%d\n", array_sum($counter));
