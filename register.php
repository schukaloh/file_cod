<?php

session_start();

include('config.php');



if (empty($_POST))
{
	?>
	
	<h3>����� ���� ������</h3>
	
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
				<td><input type="submit" value="������������������" /></td>
			</tr>
		</table>
	</form>
	
	
	<?php
}
else
{
	
	$login = (isset($_POST['login'])) ? mysql_real_escape_string($_POST['login']) : '';
	$password = (isset($_POST['password'])) ? mysql_real_escape_string($_POST['password']) : '';
	
	
	// �������� �� ������ ( �����   ������ � ����������)
	
	$error = false;
	$errort = '';
	

	if (strlen($password) < 8)
	{
		$error = true;
		$errort .= '����� ������ ������ ���� �� ����� 8 ��������.<br />';
	}
	
	$query = "SELECT `id`
				FROM `users`
				WHERE `login`='{$login}'
				LIMIT 1";
	$sql = mysql_query($query) or die(mysql_error());
	if (mysql_num_rows($sql)==1)
	{
		$error = true;
		$errort .= '������������ � ����� ������� ��� ���������� � ���� ������, ������� ������.<br />';
	}
	
	
	if (!$error)
	{
		$query= "INSERT INTO `users` (login,password) VALUES('$login','$password')";
		$sql = mysql_query($query) or die(mysql_error());
		
		
		print '<h4>�����������, �� ������� ����������������!</h4><a href="login.php">��������������</a>';
	}
	else
	{
		print '<h4>�������� ��������� ������</h4>' . $errort;
		echo" <br> <a href=index.php >��������� � ������ ������ </a> ";
	}
}

?>