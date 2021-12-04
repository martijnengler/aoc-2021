<?php
$input = array_map(fn($x) => str_split($x), file('input', FILE_IGNORE_NEW_LINES));

function mostCommonBitInColumn(int $i, array $arr): int
{
	return array_sum(array_column($arr, $i)) >= count($arr)/2;
}

function getRating(array $input, bool $flip_bit): string
{
	$binary_length = count(reset($input));
	for($i = 0; count($input) !== 1; $i++)
	{
		$i %= $binary_length;
		$input = array_filter(
			$input,
			fn($x) => $x[$i] == (mostCommonBitInColumn($i, $input) ^ !$flip_bit)
		);

		if(count($input) === 1)
			return bindec(implode("", reset($input)));
	}
}

printf("%s\n", getRating($input, true) * getRating($input, false));
