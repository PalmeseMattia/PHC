<?php
require_once "token.php";
class Scanner
{
	public readonly string	$source;
	private	int		$tok_count = 0; 
	public array 		$tokens = array();

	public function __construct(string $source) {
		$this -> source = $source;
	}

	public function addToken(Token $token) {
		$this -> tokens[$this -> tok_count] = $token;
		$this -> tok_count += 1;
	}

	private function scanToken(string $token) {
		switch($token) {
			case '(': addToken(LEFT_PAREN); break;
			case ')': addToken(RIGHT_PAREN); break;
			case '{': addToken(LEFT_BRACE); break;
			case '}': addToken(RIGHT_BRACE); break;
			case ',': addToken(COMMA); break;
			case '.': addToken(DOT); break;
			case '-': addToken(MINUS); break;
			case '+': addToken(PLUS); break;
			case ';': addToken(SEMICOLON); break;
			case '*': addToken(STAR); break; 
		}
	}

	public function scan() {
		$curr = 0;
		$line = 1;
		$start = $curr;
		$len = strlen($this -> source);
		while ($curr != $len) {
			echo $this -> source[$curr];
			$curr += 1;

		}
		$this -> addToken(new Token(TokenType::EOF, "", null, $line));
	}
}
?>
