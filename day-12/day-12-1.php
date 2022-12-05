#!/Users/martijnengler/.bin/php
<?php
// https://adventofcode.com/2021/day/12
define("TEST_MODE", true);
require_once __DIR__ . '/../init.php';

class Cave
{
	protected bool $small;
	protected bool $large;
	protected string $identifier;
	protected array $exits  = [];
	protected bool $visited = false;
	protected bool $start   = false;
	protected bool $end     = false;

	public function __construct($s)
	{
		$this->identifier = $s;
		$this->small      = (strtolower($s) === $s);
		$this->large      = !($this->small);
		$this->start      = ($this->identifier === 'start');
		$this->end        = ($this->identifier === 'end');
	}

	public function canBeVisited()
	{
		return ($this->large || !$this->visited);
	}

	public function addPathWay(Cave &$exit, bool $add_two_way = true)
	{
		$this->exits[] = $exit;
		if($add_two_way)
		{
			$exit->addPathWay($this, false);
		}
	}

	public function __toString()
	{
		return $this->identifier;
	}
}

function addCave(&$caves, $a)
{
	$identifiers = array_map(fn($x) => (String)$x, $caves);
	if(!in_array($a, $identifiers))
	{
		$caves[] = new Cave($a);
	}
}
// first look for all the identifiers and create caves
$lines_split_by_dashes = array_map(fn($x) => explode('-', $x), $lines);

$caves = [];
foreach($lines_split_by_dashes as $line)
{
	list($a, $b) = $line;

	addCave($caves, $a);
	addCave($caves, $b);
}

// next, add the exits between the caves
foreach($lines_split_by_dashes as $line)
{
	$cave_idx = array_search($line[0], $caves);
	print $caves[$cave_idx] . PHP_EOL;
}
