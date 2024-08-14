<?php
require_once "token.php";
class Scanner
{
	public readonly string	$source;
	private			$handle;
	private	int		$tok_count = 0; 
	public array 		$tokens = array();
	private int		$curr = 0;
	private int		$line = 1;
	private int		$start = 0;

	public function __construct(string $source) {
		$this -> source = $source;
		$this -> handle = fopen($source, "rb");
	}

	private function addToken(Token $token) {
		$this -> tokens[$this -> tok_count] = $token;
		$this -> tok_count += 1;
	}

	private function advance() {
		$this -> curr += 1;
		return fgetc($this -> handle);
	}

	private function peek() {
		$char = fgetc($this -> handle);
		fseek($this -> handle, -1, SEEK_CURR);
		return $char;
	}

	private function scanToken(string $token) {
		switch($token) {
		// One character Simple stuff
		case '(':
			$this -> addToken(new Token(TokenType::LEFT_PAREN, $token, null, $this -> line)) ;break;
		case ')': 
			$this -> addToken(new Token(TokenType::RIGHT_PAREN, $token, null, $this -> line)) ;break;
		case '{':
			$this -> addToken(new Token(TokenType::LEFT_BRACE, $token, null, $this -> line)); break;
		case '}':
			$this -> addToken(new Token(TokenType::RIGHT_BRACE, $token, null, $this -> line)); break;
		case ',':
			$this -> addToken(new Token(TokenType::COMMA, $token, null, $this -> line)); break;
		case '.':
			$this -> addToken(new Token(TokenType::DOT, $token, null, $this -> line)); break;
		case '-':
			$this -> addToken(new Token(TokenType::MINUS, $token, null, $this -> line)); break;
		case '+':
			$this -> addToken(new Token(TokenType::PLUS, $token, null, $this -> line)); break;
		case ';':
			$this -> addToken(new Token(TokenType::SEMICOLON, $token, null, $this -> line)); break;
		case '*':
			$this -> addToken(new Token(TokenType::STAR, $token, null, $this -> line)); break;
		
		// Preprocessor directives
		case '#':
			$directive = $token;
			$regex = '/^#[a-zA-Z]+$/';
			$directive = $directive . $this -> advance();
			while(preg_match($regex, $directive)) {
				echo $directive;
				$directive = $directive . $this -> advance();
			}
			$this -> addToken(new Token(TokenType::PRE, $directive, null, $this -> line));
			break;
			
		// We should add support to Less Equal, Greater Equal ecc....
		// If the last token is a preprocess directive, we should take the name of the lib included
		case '<':

			$this -> addToken(new Token(TokenType::LESS, $token, null, $this -> line)); break;
		case '>':
			$this -> addToken(new Token(TokenType::GREATER, $token, null, $this -> line)); break;
		case '\\':
			$char = $this -> advance();
			switch($char) {
			case 'n':
				$this -> addToken(new Token(TokenType::EOL, "\\n", null, $this -> line));
				$this -> line += 1; break;
			case 't':
				$this -> addToken(new Token(TokenType::TAB, "\\t", null, $this -> line));
				$this -> line += 1; break;
			case 'r':
				$this -> addToken(new Token(TokenType::TAB, "\\r", null, $this -> line));
				$this -> line += 1; break;
			default:
				break;
			}
			break;

		// String Literals
		case '"':
			$regex = '/"[^"]*"/i';
			$literal = $token;
			$char = $this -> advance();
			$literal = $token . $char;
			while(!preg_match($regex, $literal)) {
				$literal = $literal . $this -> advance();
			}
			$this -> addToken(new Token(TokenType::STRING, $literal, null, $this -> line));
			break;
		case ' ':
			break;
		default: 
			echo("Unexpected character " . $token . "  at line: " . $this -> line . "!\n");
		}
	}

	public function scan() {
		while (!feof($this -> handle)) {
			$char = $this -> advance();
			$this -> scanToken($char);

		}
		$this -> addToken(new Token(TokenType::EOF, "", null, $this -> line));
	}
}
?>
