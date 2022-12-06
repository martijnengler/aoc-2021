#!/Users/martijnengler/.bin/php
<?php
// https://adventofcode.com/2021/day/12
define("TEST_MODE", true);
require_once __DIR__ . '/../init.php';

class Cave
{
	public bool $small;
	public bool $large;
	public string $identifier;
	public array $exits  = [];
	public bool $visited = false;
	public bool $start   = false;
	public bool $end     = false;

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
		return ($this->large || $this->end || !$this->visited);
	}

	public function addPathWay(Cave &$exit)
	{
		// never go back to start
		if($exit->identifier === 'start')
		{
			return;
		}
		$this->exits[$this->identifier . '_' . $exit->identifier] = $exit;
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

function findCave($caves, $identifier)
{
	$cave_idx = array_search($identifier, $caves);
	return $caves[$cave_idx];
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
	$a = findCave($caves, $line[0]);
	$b = findCave($caves, $line[1]);
	$a->addPathWay($b);
	$b->addPathWay($a);
}

$start = findCave($caves, 'start');

$exits_tried = [];

$output = [];
for($j = 0; $j < 10; $j++)
{
	$output[] = (implode(",", calculateExits($start, [], $exits_tried)));
	foreach($caves as $c)
	{
		$c->visited = false;
	}
}

print implode(PHP_EOL, array_filter($output, function($x){
	return str_ends_with($x, ',end');
}));


function calculateExits($cave, $chain = [], &$exits_tried = [])
{
	$chain[] = (String)$cave;

	$exits = $cave->exits;

	// we hit "END"
	if($cave->identifier === "end")
	{
		return $chain;
	}

	$exits = array_filter(
		$exits,
		fn($val, $key) => !in_array($key, $exits_tried) && $val->canBeVisited(),
		ARRAY_FILTER_USE_BOTH
	);

	if(empty($exits))
	{
		return $chain;
	}
	$idx = array_keys($exits)[0];
	$exits_tried[] = $idx;

	$cave->visited = true;
	return calculateExits($exits[$idx], $chain, $exits_tried);
}