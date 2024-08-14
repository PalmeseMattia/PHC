<?php
	require_once "token.php";
	require_once "scanner.php";

	if ($argc < 2) {
		echo "Please provide a C source file\n";
		exit(420);
	}
	$file_name = $argv[1];
	$scanner = new Scanner($file_name);
	$scanner -> scan();
	foreach ($scanner -> tokens as $token) {
		echo $token -> toString();
	}
	foreach ($scanner -> tokens as $token) {
		echo $token -> lexem;
		if ($token -> type != TokenType::EOL and $token -> type != TokenType::EOF) {
			echo ' ';
		}
	}
?>
