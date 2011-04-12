<?php session_start(); ?>
<link href="css_st.css" rel="stylesheet" type="text/css" />
<form enctype="multipart/form-data" action="fileserv.php?noop=1" method="post">
  <p class="stil">Отправить этот файл: <input name="userfile" type="file" />
    <input type="submit" value="Send File" /><br>
    <input type="checkbox" name="check" value="1" /> Разрешить комментирование для неавторизованных пользователей 
  </p>
</form>
<?php
$key=$_GET['key'];
$fir=$_GET['fir'];
include('config.php');
if (!isset($_SESSION['user_id']))
{
	print '<a href="login.php">Авторизация</a><br />';
	print '<a href="register.php">Регистрация</a><br />';
}
else
{
	print '<a href="login.php?logout">Выход</a><br />';
	print '<a href="private.php">Мои файлы</a><br />';
}

$type=$_POST['type'];
//for pages
$per_page=25;
if(!$_GET['page_id']) {$page_start=0;}  
else 
{ 
$page_start=$per_page*$_GET['page_id']-$per_page;
}
//echo "page_start $page_start <br>";


 $res=mysql_query("SELECT COUNT(*) FROM downloads ");
 $num_temp= mysql_fetch_row($res);
 $num=$num_temp[0];

 if (! isset($key)) $key = "date";

// Сортировка по убыванию столбца $key





//	$sql="DELETE FROM `downloads` WHERE `file_id` = 169";
//	$result = mysql_query($sql, $db);
//for sort
if($fir==0){
$query = "SELECT *  FROM downloads ORDER BY $key DESC LIMIT $page_start,$per_page";
$fir=1;
}
else{
$query = "SELECT *  FROM downloads ORDER BY $key ASC LIMIT $page_start,$per_page";
$fir=0;
}
print "<table border = 1>";
print "<tr>
<th><a href=index.php?key=filename&fir=$fir> file Name    </a></th>
<th><a href=index.php?key=date&fir=$fir> дата добавления </a></th>
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

	
	if ($myrow = mysql_fetch_array($result))
		{// display list if there are records to display
			do
			{
			$f_n=$myrow["filename"];
			$f_d=$myrow["date"];
			$aval_c=$myrow["aval_comm"];
			$cod=rawurlencode("$f_n");
			echo "  <tr>  <td >    <a href=downl.php?f1=$cod&noop=1&av_comm=$aval_c>  $f_n</a> </td><td> $f_d </td> </tr> " ;
			}
			while ($myrow = mysql_fetch_array($result));echo "<br><br>";
		}
	else	{
			echo "Sorry, no records were found!";
		}
print "</table>";


//for page
 echo "Страница       ";
 for($i=1;$i<=$pages;$i++)
{
   if($i==$_GET['page_id'])
   {echo "<a href='index.php?page_id=$i'> <b>$i</b> </a>";}
   else{
  echo "<a href='index.php?page_id=$i'>$i </a>";}
}  
?>
