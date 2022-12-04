#!/Users/martijnengler/.bin/php
<?php
// https://adventofcode.com/2021/day/11
define("TEST_MODE", true);
//define("INPUT_FILE", "small-test");
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
	global $total_flashes;

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

$how_many_steps = 100;
for($i = 0; $i < $how_many_steps; $i++)
{
	step($octopi);
}

$output = [];
foreach($octopi as $row)
{
	$row = array_map(function($x) {
		return $x->energy_level;
	}, $row);
	$output[] = implode("", $row);
}

$test_outputs =
[
	// 0 steps
	<<<'STR'
	5483143223
	2745854711
	5264556173
	6141336146
	6357385478
	4167524645
	2176841721
	6882881134
	4846848554
	5283751526
	STR,
	// 1 steps
	<<<'STR'
	6594254334
	3856965822
	6375667284
	7252447257
	7468496589
	5278635756
	3287952832
	7993992245
	5957959665
	6394862637
	STR,
	// 2 steps
	<<<'STR'
	8807476555
	5089087054
	8597889608
	8485769600
	8700908800
	6600088989
	6800005943
	0000007456
	9000000876
	8700006848
	STR,
	// 3 steps
	<<<'STR'
	0050900866
	8500800575
	9900000039
	9700000041
	9935080063
	7712300000
	7911250009
	2211130000
	0421125000
	0021119000
	STR,
];

if(count($test_outputs) >= $how_many_steps)
{
	$test_output = $test_outputs[$how_many_steps];
	$test_output = explode("\n", $test_output);

	printf("%s\n", $output[0]);
	printf("%s\n", $test_output[0]);

	foreach($output as $k => $v)
	{
		printf("%d: %s\n", $k, $output[$k] === $test_output[$k] ? "OK" : "FAIL");
	}
}

printf("%d\n", $total_flashes);
