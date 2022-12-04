#!/Users/martijnengler/.bin/php
<?php
// https://adventofcode.com/2021/day/11
define("TEST_MODE", false);
require_once __DIR__ . '/../init.php';

$total_flashes = 0;

class Octopus
{
	public int $energy_level;
	public bool $flashed = false;
	public int $row;
	public int $col;

	public function __construct(int $level, int $row, int $col)
	{
		$this->energy_level = $level;
		$this->row = $row;
		$this->col = $col;
	}

	public function increase()
	{
		$this->energy_level++;
	}

	public function flash()
	{
		$this->flashed = true;
	}

	public function try_flash()
	{
		if($this->energy_level > 9 && !$this->flashed)
		{
			$this->flash();
			return true;
		}
		return false;
	}

	public function cleanup()
	{
		$this->flashed = false;
		if($this->energy_level > 9)
			$this->energy_level = 0;
	}

	public function __toString()
	{
		return (String)$this->energy_level;
	}
}

// quickly transform an array into something to output
// e.g. input:
//
// [
// 	[1, 2, 3]
// 	[4, 5, 6]
// ]
//
// output:
//
// 123
// 456
//
// or with separator "*"
// 1*2*3
// 4*5*6
function showMatrix(array $arr, string $separator = '')
{
	$output = '';
	foreach($arr as $v)
	{
		$output .= implode($separator, $v) . PHP_EOL;
	}
	return $output;
}

function adjacentInArray(
	array $arr,
	int $row_idx,
	int $col_idx,
	bool $vertical    = true,
	bool $horizontal  = true,
	bool $diagonal    = true,
	bool $wrap_around = false
)
{
	$options = [];

	$vertical_directions = [
		// vertical up
		[1, 0],
		// vertical down
		[-1, 0],
	];

	$horizontal_directions = [
		// horizontal right
		[0, 1],
		// horizontal left
		[0, -1],
	];

	$diagonal_directions = [
		// diagonal up right
		[1, 1],
		// diagonal up left
		[1, -1],
		// diagonal down right
		[-1, 1],
		// diagonal down left
		[-1, -1]
	];

	if($vertical)
	{
		$options = array_merge($options, $vertical_directions);
	}

	if($horizontal)
	{
		$options = array_merge($options, $horizontal_directions);
	}

	if($diagonal)
	{
		$options = array_merge($options, $diagonal_directions);
	}

	$output = [];
	foreach($options as $d)
	{
		$try_row_idx = $row_idx + $d[0];
		$try_col_idx = $col_idx + $d[1];
		if(isset($arr[$try_row_idx]) && isset($arr[$try_row_idx][$try_col_idx]))
		{
			$output[] = $arr[$try_row_idx][$try_col_idx];
		}
	}

	return $output;
}

function step($octopi)
{
	$total_flashes = 0;

	$flashers = [];

	// First, the energy level of each octopus increases by 1.
	foreach($octopi as $row)
	{
		foreach($row as $fish)
		{
			$fish->increase();
			if($fish->energy_level > 9 && !$fish->flashed)
			{
				$flashers[] = $fish;
			}
		}
	}

	while(count($flashers) > 0)
	{
		$fish = array_shift($flashers);
		if($fish->try_flash())
		{
			$total_flashes++;

			// This increases the energy level of all adjacent octopuses by 1,
			// including octopuses that are diagonally adjacent.
			$adjacent = adjacentInArray($octopi, $fish->row, $fish->col);
			foreach($adjacent as $adj_fish)
			{
				$adj_fish->increase();
				// If this causes an octopus to have an energy level greater than 9,
				// it also flashes.
				if($adj_fish->energy_level > 9)
				{
					$flashers[] = $adj_fish;
				}
			}
		}
	}
	// This process continues as long as new octopuses keep having their energy
	// level increased beyond 9.
	//
	// An octopus can only flash at most once per step.

	// Finally, any octopus that flashed during this step has its energy level
	// set to 0, as it used all of its energy to flash.
	foreach($octopi as &$row)
	{
		foreach($row as $fish)
		{
			$fish->cleanup();
		}
	}

	return $total_flashes;
}

$octopi = [];
foreach($lines as $row => $val)
{
	$octopi[] = array_map(
		fn($col, $level) => new Octopus($level, $row, $col),
		array_keys(str_split($val)),
		array_values(str_split($val))
	);
}

$how_many_steps = 999999;
for($i = 0; $i < $how_many_steps; $i++)
{
	if(step($octopi) === 100)
	{
		printf("%d\n", ($i+1));
		exit;
	}
}
