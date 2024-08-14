<?php
require_once "token.php";

$Colors = array(
	TokenType::FUNCTION -> name => "FF5C67",
	TokenType::STRING -> name => "FFEF3F",
	TokenType::PRE -> name => "55D6C2",
	TokenType::NUMBER -> name => "3FFF89",
	TokenType::RETURN -> name => "DFB2F4",
	TokenType::INT -> name => "52A9FF"
);

function getColor(TokenType $type)
{
	global $Colors;

	if (array_key_exists($type -> name, $Colors)) {
		return ($Colors[$type -> name]);
	} else {
		return '#FFFFFF';
	}
}
?>
