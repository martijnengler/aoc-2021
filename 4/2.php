<?php
$input = file('input', FILE_IGNORE_NEW_LINES);

// I miss this from JS
function array_every(array $arr, string|int $val): bool
{
	foreach($arr as $v)
		if($v !== $val)
			return false;

	return true;
}

class Board
{
	protected array $rows;

	public function addRow(string $row): void
	{
		$numbers = array_filter(explode(" ", $row), fn($x) => strlen($x) > 0);
		$this->rows[] = array_map(fn($x) => 0, array_flip($numbers));
	}

	public function markNumber(int $n): void
	{
		foreach($this->rows as &$row)
			if(isset($row[$n]))
				$row[$n] = 1;
	}

	protected function rowBingo(): bool
	{
		foreach($this->rows as $row)
			if(array_every($row, 1)) return true;

		return false;
	}

	protected function columnBingo(): bool
	{
		$row_length = count(reset($this->rows));
		for($i = 0; $i < $row_length; $i++)
		{
			$flat = array_map(fn($x) => array_values($x), $this->rows);
			$column = array_column($flat, $i);
			if(array_every($column, 1)) return true;
		}
		return false;
	}

	public function hasBingo(): bool
	{
		return $this->rowBingo() || $this->columnBingo();
	}

	public function calculateScore(int $multiplier): int
	{
		$sum = 0;
		foreach($this->rows as $row)
			$sum += array_sum(array_keys(array_filter($row, fn($y) => $y===0)));

		return $sum * $multiplier;
	}
}

$called_numbers = explode(',', array_shift($input));

foreach($input as $line)
{
	if(!empty(trim($line)))
	{
		$board->addRow($line);
		continue;
	}

	if(isset($board))
		$all_boards[] = $board;

	$board = new Board();
}
// don't forget to add the last board
$all_boards[] = $board;

foreach($called_numbers as $n)
{
	foreach($all_boards as $b)
	{
		$b->markNumber($n);
		if($b->hasBingo() && count($all_boards) === 1)
			printf("%d\n", $b->calculateScore($n));
	}

	$all_boards = array_filter($all_boards, fn($x) => !$x->hasBingo());
}
