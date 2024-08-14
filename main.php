<html>
	<head>
		<link rel="stylesheet" href="style.css">
		<title>PHC</title>
	</head>
	<body>
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
				echo '<tr><th>' . $token -> type -> name . '</th><th>'. $token -> toString() . '</th></tr>';
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
				echo '<span>' . $token -> lexem . '</span> ';
			}
		}
		?>
		<div>
	</div>
	</body>
</html>
