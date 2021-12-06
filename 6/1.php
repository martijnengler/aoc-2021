<?php
define('NUMBER_OF_DAYS', 80);
$input = trim(file_get_contents(__DIR__ . '/input'));

class Lanternfish
{
	public int $timer;

	public function __construct(int $timer = 8)
	{
		$this->timer = $timer;
	}

	protected function giveBirth(): void
	{
		// might solve this another way later, for now this is fine
		global $list;
		$list[] = new Lanternfish();
	}

	public function next(): void
	{
		if($this->timer === 0)
		{
			$this->timer = 7;
			$this->giveBirth();
		}

		$this->timer--;
	}
}

$list = array_map(fn($x) => new Lanternfish((int)$x), explode(",", $input));

for($i = 1; $i <= NUMBER_OF_DAYS; $i++)
	foreach($list as $fish)
		$fish->next();

printf("%d fish", count($list));
