<?php
 session_start();
// create database AAA DEFAULT CHARACTER SET cp1251 COLLATE cp1251_bin; 
//create table charset_test (str varchar(20) ) DEFAULT CHARACTER SET  cp1251 COLLATE cp1251_bin;
// В PHP 4.1.0 и более ранних версиях следует использовать $HTTP_POST_FILES 
// вместо $_FILES.
//$uploaddir = '/var/www/uploads/';
include('config.php');

$uploadfile = basename($_FILES['userfile']['name']);

$sql = "SELECT * FROM downloads  WHERE filename='$uploadfile'";
$result = mysql_query($sql, $db);
if(!$myrow = mysql_fetch_array($result)) 
{
print "<pre>";
$upload_path = dirname (__FILE__).'/'.$upload_dir.'/';
if (move_uploaded_file($_FILES['userfile']['tmp_name'],$upload_path.$uploadfile)) {
    print "File is valid, and was successfully uploaded. ";
	$browser=$_SERVER['HTTP_USER_AGENT'];
	$ip_a=$_SERVER['REMOTE_ADDR'];
	$user_id=$_SESSION['user_id'];
	$sql = "INSERT INTO downloads (filename,ver_br,ip,user_id,aval_comm) VALUES('$uploadfile','$browser','$ip_a','$user_id','$_POST[check]')";
	$result = mysql_query($sql, $db);
	if($result){
		$cod=rawurlencode("$uploadfile");
		echo "<br> <a href=$upload_dir/$cod>$uploadfile</a>";}
	else {echo "can't INSERT file in DB ";}

	
} else {
    echo "Ошибка, не удалось загрузить файл на сервер";
}
print "</pre>";

}
else echo  " <br>Такой файл уже существует ";



if($_GET['noop']==1)
{echo "<br> <a href=index.php >Вернуться к списку файлов </a>";
}
else {echo "<br> <a href=private.php >Вернуться к списку файлов </a>";}
?> 
