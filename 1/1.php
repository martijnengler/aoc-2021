<?php
$input = file('input', FILE_IGNORE_NEW_LINES);
$i = 0;
foreach($input as $one_line)
{
	if(isset($prev) && $one_line > $prev)
		$i++;
	$prev = $one_line;
}

print $i;
