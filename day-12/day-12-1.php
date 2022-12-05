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
var_dump(implode(",", calculateExits($start, [], $exits_tried)));
var_dump(implode(",", calculateExits($start, [], $exits_tried)));

$i = 0;
function calculateExits($cave, $chain = [], &$exits_tried = [])
{
	global $i;
	$i++;

	if($i > 100)
	{
		print $i;
		exit;
	}

	$chain[] = (String)$cave;

	$exits = $cave->exits;

	// we hit "END"
	if($cave->identifier === "end")
	{
		return $chain;
	}

	// or we can't "visit"
	if(!$cave->canBeVisited() && $cave->identifier !== 'start')
	{
		return $chain;
	}

	$exits = array_filter($exits, fn($x) => !in_array($x, $exits_tried), ARRAY_FILTER_USE_KEY);
	$idx = array_keys($exits)[0];
	$exits_tried[] = $idx;

	$cave->visited = true;
	return calculateExits($exits[$idx], $chain, $exits_tried);
}
