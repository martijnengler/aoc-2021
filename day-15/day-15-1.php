#!/Users/martijnengler/.bin/php
<?php
// https://adventofcode.com/2021/day/15
define("TEST_MODE", true);
require_once __DIR__ . '/../init.php';

class AocNode
{
	public $value;

	public function __construct($value)
	{
		$this->value = $value;
	}

	public function connect(AocNode $node)
	{

	}
}

// convert the numbers into AocNode
foreach($lines as &$val)
{
	$val = array_map(fn($x) => new AocNode($x), str_split($val));
}
