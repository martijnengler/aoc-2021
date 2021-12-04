<?php
$input = file('input', FILE_IGNORE_NEW_LINES);
$position = ['h' => 0, 'v' => 0];
foreach($input as $line)
{
	list($direction, $steps) = explode(' ', $line);
	switch($direction)
	{
		case 'forward':
			$position['h'] += $steps;
			break;
		case 'down':
			$position['v'] += $steps;
			break;
		case 'up':
			$position['v'] -= $steps;
			break;
	}
}

printf("%d\n", array_product($position));
