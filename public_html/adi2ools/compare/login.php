<html>
	<head>
		<style>
			fieldset {
				width: 300px;
			}
			
			label, legend, td {
				margin-left: 3px;
				padding-top: 2px;
				text-shadow: 2px 2px 3px rgba(150, 150, 150, 0.75);
				font-family: Verdana, Geneva, sans-serif;
				font-size: .9em;
			}
			
			.err {
				color: red;
				text-shadow: 2px 2px 3px rgba(255, 150, 150, 0.75)
			}
		</style>
	</head>
<body>

<fieldset>
	<legend>Enter Information</legend>
	<form method="post">
		<table cellpadding="8">
			<?php if ($error = app()->getErrorMessage()): ?>
				<tr>
					<td colspan='2' class='err'><?= $error ?></td>
				</tr>
			<?php endif ?>
			<tr>
				<td>Username:</td>
				<td><input type="text" name="username"></td>
			</tr>
			<tr>
				<td>Password:</td>
				<td><input type="password" name="password"></td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="submit" value="Compare">
				</td>
			</tr>
		</table>
	</form>
</fieldset>
</body>
</html>