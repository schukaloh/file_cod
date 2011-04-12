<?php

session_start();

include('config.php');



if (empty($_POST))
{
	?>
	
	<h3>Введи Ваши данные</h3>
	
	<form action="register.php" method="post">
		<table>
			<tr>
				<td>E-mail:</td>
				<td><input type="text" name="login" /></td>
			</tr>
			<tr>
				<td>pass:</td>
				<td><input type="password" name="password" /></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" value="Зарегистрироваться" /></td>
			</tr>
		</table>
	</form>
	
	
	<?php
}
else
{
	
	$login = (isset($_POST['login'])) ? mysql_real_escape_string($_POST['login']) : '';
	$password = (isset($_POST['password'])) ? mysql_real_escape_string($_POST['password']) : '';
	
	
	// проверка на ошибки ( длина   пароля и совпадения)
	
	$error = false;
	$errort = '';
	

	if (strlen($password) < 8)
	{
		$error = true;
		$errort .= 'Длина пароля должна быть не менее 8 символов.<br />';
	}
	
	$query = "SELECT `id`
				FROM `users`
				WHERE `login`='{$login}'
				LIMIT 1";
	$sql = mysql_query($query) or die(mysql_error());
	if (mysql_num_rows($sql)==1)
	{
		$error = true;
		$errort .= 'Пользователь с таким логином уже существует в базе данных, введите другой.<br />';
	}
	
	
	if (!$error)
	{
		$query= "INSERT INTO `users` (login,password) VALUES('$login','$password')";
		$sql = mysql_query($query) or die(mysql_error());
		
		
		print '<h4>Поздравляем, Вы успешно зарегистрированы!</h4><a href="login.php">Авторизоваться</a>';
	}
	else
	{
		print '<h4>Возникли следующие ошибки</h4>' . $errort;
		echo" <br> <a href=index.php >Вернуться к списку файлов </a> ";
	}
}

?>