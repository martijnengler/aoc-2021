<?php
$input = file('input', FILE_IGNORE_NEW_LINES);

$input = array_map(fn($x) => str_split($x), $input);
$half_size = count($input)/2;
	$binary_length = count($input[0]);
$gamma = '';
$epsilon = '';

for($i = 0; $i < $binary_length; $i++)
{
	$most_common_bit = (array_sum(array_column($input, $i)) > $half_size);
	$gamma .= $most_common_bit;
	$epsilon .= (int)!$most_common_bit;
}

printf("%d\n", bindec($gamma) * bindec($epsilon));
