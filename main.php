<html>
	<head>
		<link rel="stylesheet" href="style.css">
		<title>PHC</title>
	</head>
	<body>
		<div class="center-title center">
			<h2>C LEXER AND SYNTAX HIGHLIGHT</h2>
			<h2>Made with PHP 8 with love <3 </h2>
		</div>
		<?php
			require_once "token.php";
			require_once "scanner.php";
			require_once "colors.php";
		
			if ($argc < 2) {
				echo "Please provide a C source file\n";
				exit(420);
			}
			$file_name = $argv[1];
			$scanner = new Scanner($file_name);
			$scanner -> scan();
		?>
	<div class="container">
		<!-- INFO  TABLE -->
		<table>
			<tr>
				<th>TYPE</th>
				<th>INFO</th>
			</tr>
			<?php
			foreach ($scanner -> tokens as $token) {
				echo '<tr><th>' . $token -> type -> name 
					. '</th><th>LINE: '. $token -> line  
					. ' LEXEM: ' . $token -> lexem . '</th></tr>';
			}
			?>
		</table>

		<!-- CODE -->
		<div class="bible">
		<?php
		foreach ($scanner -> tokens as $token) {
			if ($token -> type == TokenType::EOL) {
				echo '<br>';
			} else if ($token -> type == TokenType::TAB) {
				echo '&emsp;&emsp;&emsp;&emsp;';
			} else {
				echo '<span style="color:' .
				       getColor($token -> type)	
					. '">' . $token -> lexem . '</span> ';
			}
		}
		?>
		<div>
	</div>
	</body>
</html>
