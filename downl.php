<?php
session_start();
include('config.php');

$f1=$_GET['f1'];
$noop=$_GET['noop'];
$av_comm=$_GET['av_comm'];
$answer=$_GET['answer'];
$level=$_GET['level'];
$ida=$_GET['ida'];
$id=$_GET['id'];


$cod=rawurlencode("$f1");
echo "Скачать файл <a href=$upload_dir/$cod>$f1</a>";
if($noop==1)
{echo "<br> <a href=index.php >Вернуться к списку файлов </a> ";
}
else {echo "<br> <a href=private.php >Вернуться к списку файлов </a>";}
$name=$_POST['name'];
$content=$_POST['content'];
echo "<link href='css_st.css' rel='stylesheet' type='text/css' />";



if (isset($_POST))
{
     if ($_POST['name'] &&  $_POST['content'])
     {
        if($level==0)
        {  $id++;
            $sql = "INSERT INTO comments (file,name,comm,comm_l,id_tree) VALUES('$f1','$name','$content',$level,$id)";
        }
        else{
        $sql = "INSERT INTO comments (file,name,comm,comm_l,id_tree) VALUES('$f1','$name','$content','$level','$ida')";}
	$result = mysql_query($sql, $db);
        
     }
     else "Заполните все поля";
}

//from base




print "<table border = 1 class='com'>";
$sql = "SELECT * FROM comments   WHERE file='$f1'  ORDER BY id_tree,id  ASC";
$result = mysql_query($sql, $db); 
	if ($myrow = mysql_fetch_array($result))
		{// display list if there are records to display
			do
			{
			$name=$myrow["name"];
			$comm=$myrow["comm"];
                        $idak=$myrow["id_tree"];
                        $id=$myrow["id"];
                        $comm_l=$myrow["comm_l"]+1;
			$cod=rawurlencode("$f_n");
                        $com_url="downl.php?f1=$f1&noop=$noop&av_comm=$av_comm&answer=$name&level=$comm_l&ida=$idak";
                        $shift='';
                        for($i=1;$i<$comm_l;$i++)
                            {
                            $shift+=70;
                            }
			echo "  <tr>  <td  style=\"padding:0px 0px 0px $shift;\">  <font color=\"#CC0000\">$name </font> <br>  $comm </td><td> <input type='button' value='Ответить' onclick=\"location.href='$com_url'\" />  </td> </tr>  " ;
			}
			while ($myrow = mysql_fetch_array($result));echo "<br><br>";
		}
	else	{
			echo "Кометариев нет";
		}
print "</table>";

echo "<br><br> Добавить комментарий <br>";


if ($av_comm ||isset($_SESSION['user_id']))
{ 
    if($answer)
    {
        echo " Вы отвечаете пользователю  $answer уровень комментирования $level id_tree $ida ";
    }
    else {$level=0;}

echo "
<form action=\"downl.php?f1=$f1&noop=$noop&av_comm=$av_comm&level=$level&id=$id&ida=$ida\" method=post>

Ваше имя:<br>
<input type=text name='name' value=\"\" size=\"40\" maxlength=\"20\"><br><br>

Ваш комментарий:<br>
<textarea rows=7 cols=40 name=\"content\"></textarea><br><br>
<input type=submit value=\"ОК\"> 

</form> ";
}
else {echo "Вы не можете оставлять коментарии";}

?>
