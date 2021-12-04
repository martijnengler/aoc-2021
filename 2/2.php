<?php
$input = file('input', FILE_IGNORE_NEW_LINES);
$position = ['h' => 0, 'v' => 0];
$aim = 0;
foreach($input as $line)
{
	list($direction, $steps) = explode(' ', $line);
	switch($direction)
	{
		case 'forward':
			$position['h'] += $steps;
			$position['v'] += $steps * $aim;
			break;
		case 'down':
			$aim += $steps;
			break;
		case 'up':
			$aim -= $steps;
			break;
	}
}

printf("%d\n", array_product($position));
