<?php
	require_once "token.php";
	require_once "scanner.php";

	if ($argc < 2) {
		echo "Please provide a C source file\n";
		exit(420);
	}
	$file_name = $argv[1];
	$handle = fopen($file_name, "rb") or die("Unable to locate the file!\n");
	$source = fread($handle, filesize($file_name));
	$scanner = new Scanner($source);
	$scanner -> pushToken(new Token(TokenType::LEFT_PAREN, ')',')', 10));
	echo $scanner -> tokens[0] -> toString();
?>
