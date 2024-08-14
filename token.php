<?php
enum TokenType
{
	case LEFT_PAREN;
	case RIGHT_PAREN;
	case LEFT_BRACE;
	case RIGHT_BRACE;
	case COMMA;
	case DOT;
	case MINUS;
	case PLUS;
	case SEMICOLON;
	case SLASH;
	case STAR;
	// One or two character tokens.
	case BANG;
	case BANG_EQUAL;
	case EQUAL;
	case EQUAL_EQUAL;
	case GREATER;
	case GREATER_EQUAL;
	case LESS;
	case LESS_EQUAL;
	// Literals.
	case IDENTIFIER;
	case STRING;
	case NUMBER;
	// Keywords.
	case AND;
	case ELSE;
	case FUN;
	case FOR;
	case IF;
	case NULL;
	case OR;
	case PRINT;
	case RETURN;
	case VAR;
	case WHILE;
	case EOF;
}

class Token
{
	public readonly TokenType	$type;
	public readonly string		$lexem;
	public readonly mixed		$literal;
	public readonly int		$line;

	public function __construct(TokenType $type, string $lexem, mixed $literal, int $line) {
		$this -> type = $type;
		$this -> lexem = $lexem;
		$this -> literal = $literal;
		$this -> line = $line;
	}

	public function toString() {
		return "Type: " . $this -> type -> name 
			. " Lex: " . $this -> lexem 
			. " Lit: " . $this -> literal 
			. " Line: " . $this -> line . "\n";
	}
}
?>
