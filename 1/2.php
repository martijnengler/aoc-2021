<?php
$input = file('input', FILE_IGNORE_NEW_LINES);

define("GROUP_SIZE", 3);
define("ARR_LENGTH", count($input));

for($i = 0, $output = 0; $i <= ARR_LENGTH - GROUP_SIZE; $i++)
{
	$current_window = array_sum(array_slice($input, $i, GROUP_SIZE));
	if(isset($previous_window) && $current_window > $previous_window)
		$output++;
	$previous_window = $current_window;
}
printf("%d\n", $output);
