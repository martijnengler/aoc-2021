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
		$this->small      = strtolower($s) === $s;
		$this->large      = !$this->small;
		$this->start      = $this->identifier === 'start';
		$this->end        = $this->identifier === 'end';
	}

	public function canBeVisited()
	{
		return ($this->large || !$this->visited);
	}

	public function addPathWay(Cave $exit, bool $add_two_way = true)
	{
		$this->exits[] = $exit;
		if($add_two_way)
		{
			$exit->addPathWay(&$this, false);
		}
	}
}
