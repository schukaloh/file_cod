<?php

session_start();
if (isset($_SESSION['user_id']))
{
?>
<link href="css_st.css" rel="stylesheet" type="text/css" />

	<form enctype="multipart/form-data" action="fileserv.php" method="post">
      <p class="stil">Отправить этот файл: <input name="userfile" type="file" />
        <input type="submit" value="Send File" /><br>
        <input type="checkbox" name="check" value="1" /> Разрешить комментирование для неавторизованных пользователей
      </p>
</form>
<?php
$key=$_GET['key'];
$fir=$_GET['fir'];
include('config.php');

	print '<a href="login.php?logout">Выход</a><br />';


$type=$_POST['type'];
$user_id=$_SESSION['user_id'];



//for pages
$per_page=25;
if(!$_GET['page_id']) {$page_start=0;}  
else 
{ 
$page_start=$per_page*$_GET['page_id']-$per_page;
}
//echo "page_start $page_start <br>";





	echo "список файлов";

	 $res=mysql_query("SELECT COUNT(*) FROM downloads WHERE user_id='$user_id' ");
 $num_temp= mysql_fetch_row($res);
 $num=$num_temp[0];
 
 
 
 
	 if (! isset($key)) $key = "date";

// Сортировка по убыванию столбца $key
	if(!empty($type))
{	
	foreach($type as $val)
	{
		$sql="DELETE FROM downloads WHERE filename ='$val'";
			if(!mysql_query($sql,$db))
			{
			echo mysql_error()."<br>";
			}
		 $upload_path = dirname (__FILE__).'/'.$upload_dir.'/';
		 unlink($upload_path.$val); 	
	}
}
//	$sql="DELETE FROM `downloads` WHERE `file_id` = 169";
//	$result = mysql_query($sql, $db);
if($fir==0){
$query = "SELECT *  FROM downloads WHERE user_id='$user_id' ORDER BY $key DESC LIMIT $page_start,$per_page";
$fir=1;
}
else{
$query = "SELECT *  FROM downloads WHERE user_id='$user_id' ORDER BY $key ASC LIMIT $page_start,$per_page";
$fir=0;
}
print "<table border = 1>";
print "<tr>
<th><a href=private.php?key=file_id&fir=$fir> file_id </a></th>
<th> delete </a></th>
<th><a href=private.php?key=filename&fir=$fir> filename </a></th>
<th><a href=private.php?key=date&fir=$fir> date</a></th>
<th> url </a></th>
</tr>";
$result = mysql_query($query);




//for page
//echo"num $num <br> ";
$pages = $num/$per_page;
if (is_double($pages))
{ 
$pages = (int) $pages; 
$pages = $pages + 1; 
}
if ($pages == 0)
{ 
$pages = 1; 
}
//echo"pages $pages";


	
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>"  method="post">

<?php

	if ($myrow = mysql_fetch_array($result))
		{// display list if there are records to display
			do
			{
			$f_id=$myrow["file_id"];
			$f_n=$myrow["filename"];
			$f_d=$myrow["date"];
			$aval_c=$myrow["aval_comm"];
			//$f_s=$myrow["file_save"];
			//$expl=explode(".", $f_n);
			//$exl_str=$f_n.$expl[strlen($expl)-1];
			$cod=rawurlencode("$f_n");
			$dcod="http://".$_SERVER['SERVER_NAME'].dirname($_SERVER['PHP_SELF']).''.$upload_dir.'/';
			echo " <tr>  <td > $f_id </td><td> <input type=\"checkbox\" name=\"type[]\" value=\"$f_n\" /> </td><td>   <a href=downl.php?f1=$cod&av_comm=$aval_c>$f_n </a> </td><td> $f_d  </td><td> <a href=$upload_dir/$cod>$dcod$f_n</a> </td> </tr> " ;
			}
			while ($myrow = mysql_fetch_array($result));
			echo "<br><br>";
		}
	else	{
			echo "Sorry, no records were found!";
			}
			print "</table>";
			//for page
 echo "<input type='submit' value='Удалить' />
</form> <br> Страница       ";
 for($i=1;$i<=$pages;$i++)
{
   if($i==$_GET['page_id'])
   {echo "<a href='private.php?page_id=$i'> <b>$i</b> </a>";}
   else{
  echo "<a href='private.php?page_id=$i'>$i </a>";}
}  
			

	print '<h1>
	<p><a href="index.php">Перейти на главную</a></p>';
}
else
{
	die('Доступ закрыт. — <a href="login.php">Авторизоваться</a>');
}

?>