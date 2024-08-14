<?php
require_once "token.php";
class Scanner
{
	public readonly string	$source;
	private	int		$count = 0; 
	public array 		$tokens = array();

	public function __construct(string $source) {
		$this -> source = $source;
	}

	public function pushToken(Token $token) {
		$this -> tokens[$this -> count] = $token;
		$this -> count += 1;
	}
}
?>
