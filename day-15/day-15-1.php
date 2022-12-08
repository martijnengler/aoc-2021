#!/Users/martijnengler/.bin/php
<?php
// https://adventofcode.com/2021/day/15
define("TEST_MODE", true);
require_once __DIR__ . '/../init.php';

class AocNode
{
	public $value;
	public $row;
	public $col;

	public function __construct($value, $row, $col)
	{
		$this->value = $value;
		$this->row = $row;
		$this->col = $col;
	}

	public function connect(AocNode $node)
	{

	}
}

// convert the numbers into AocNode
foreach($lines as $row => &$val)
{
	$a = str_split($val);
	$val = array_map(fn($x, $col) => new AocNode($x, $row, $col), $a, array_keys($a));
}
