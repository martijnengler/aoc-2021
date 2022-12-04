<?php
$input_filename = dirname($argv[0]) . DIRECTORY_SEPARATOR . '/';
$input_filename .= (defined('TEST_MODE') && TEST_MODE) ? 'test' : 'input';
$lines = file($input_filename, FILE_IGNORE_NEW_LINES);
