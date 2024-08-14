<?php
require_once "token.php";

$Colors = array(
	TokenType::FUNCTION -> name => "C0BDA5",
	TokenType::STRING -> name => "DBFE87",
	TokenType::PRE -> name => "03B5AA",
	TokenType::NUMBER -> name => "FF3864",
	TokenType::RETURN -> name => "DFB2F4"
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
