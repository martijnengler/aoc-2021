#!/Users/martijnengler/.bin/php
<?php
// https://adventofcode.com/2021/day/11
define("TEST_MODE", true);
require_once __DIR__ . '/../init.php';

class Octopus
{
	public int $energy_level;
	public bool $flashed = false;

	public function __construct(int $i)
	{
		$this->energy_level = $i;
	}

	public function increase()
	{
		$this->energy_level++;
		if($this->energy_level > 9)
		{
			$this->flash();
		}
	}

	public function flash()
	{
		$this->energy_level = 0;
		$this->flashed = true;
	}
}

function step(&$octopi)
{
	foreach($octopi as &$row)
	{
		foreach($row as &$fish)
		{
			$fish->increase();
		}
	}
}

$octopi = [];
foreach($lines as $key => $val)
{
	$octopi[] = array_map(fn($x) => new Octopus($x), str_split($val));
}

print_r($octopi);
