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
		fseek($this -> handle, -1, SEEK_CUR);
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
				$directive = $directive . $this -> advance();
			}
			$this -> addToken(new Token(TokenType::PRE, $directive, null, $this -> line));
			break;
			
		// We should add support to Less Equal, Greater Equal ecc....
		// If the last token is a preprocess directive, we should take the name of the lib included
		case '<':
			// If i have a < bracket and the last token is a preprocessor directive
			// we take the name of the library as a string
			if ($this -> tokens[$this -> tok_count - 1] -> type == TokenType::PRE) {
				$regex = '/<[A-Za-z]+\\.[A-Za-z]>/i';
				$char = $this -> advance();
				$lib = $token . $char;
				while(!preg_match($regex, $lib)) {
					$lib= $lib . $this -> advance();
				}
				$this -> addToken(new Token(TokenType::STRING, $lib, null, $this -> line));
				break;
			} else {
				$this -> addToken(new Token(TokenType::LESS, $token, null, $this -> line)); break;
			}
		case '>':
			$this -> addToken(new Token(TokenType::GREATER, $token, null, $this -> line)); break;
		case "\n":
			$this -> addToken(new Token(TokenType::EOL, $token, null, $this -> line)); break;
			$this -> line += 1;
			break;
		case "\t":
			$this -> addToken(new Token(TokenType::TAB, $token, null, $this -> line)); break;
			break;
		case "\r":
			echo "carriage found\n";
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
			// Literal numbers
			if (is_numeric($token)) {
				$num = $token;
				$next = $this -> peek();
				while(is_numeric($next) or $next == '.') {
					$num = $num . $next;
					$this -> advance();
					$next = $this -> peek();
				}
				$this -> addToken(new Token(TokenType::NUMBER, $num, null, $this -> line));
			// Reserved keyword or variables/macros
			} else if (preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $token)) {
				$regex = '/^[a-zA-Z_][a-zA-Z0-9_]*$/';
				$word = $token;
				$next = $this -> peek();
				while(preg_match($regex, $word . $next)) {
					$word .= $next;
					$this -> advance();
					$next = $this -> peek();
				}
				// TODO: implement control over keywords
				$this -> addToken(new Token(TokenType::STRING, $word, null, $this -> line));
			} else {
				echo("Unexpected character " . $token . "  at line: " . $this -> line . "!\n");
			}
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
