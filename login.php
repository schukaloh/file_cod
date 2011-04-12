<?php

session_start();

include('config.php');

if (isset($_GET['logout']))
{
	if (isset($_SESSION['user_id']))
		unset($_SESSION['user_id']);
		
	header('Location: index.php');
	exit;
}

if (isset($_SESSION['user_id']))
{
	
	header('Location: index.php');
	exit;

}



if (isset($_POST['login']) && isset($_POST['password']))
{
    $login = mysql_real_escape_string($_POST['login']);
    $password = mysql_real_escape_string($_POST['password']);
    	if (strlen($password) < 8)
	{
		echo 'Длина пароля должна быть не менее 8 символов.<br />';
	}
    // и ищем юзера с таким логином и паролем

    $query = "SELECT `id`
            FROM `users`
            WHERE `login`='{$login}' AND `password`='{$password}'
            LIMIT 1";
    $sql = mysql_query($query) or die(mysql_error());

    // если такой нашелся
    if (mysql_num_rows($sql) == 1) {
        // то мы ставим об этом метку в сессии  ID 

        $row = mysql_fetch_assoc($sql);
        $_SESSION['user_id'] = $row['id'];
		
		header('Location: private.php');
		exit;

    }
    else {
		echo "<br> <a href=index.php >Вернуться к списку файлов </a>";
        die('Такой логин с паролем не найдены в базе данных. .');
    }
}

?>

<form action= "<?php $_SERVER['PHP_SELF']; ?>" method="post">
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
            <td><input type="submit" value="Войти" /></td>
        </tr>
    </table>
</form>


