<?php
include "inc.php";
ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);

global $link;
$loginp="portal"; // логин для доступа к базе
$passp="wildgitar07"; //пароль для доступа к базе
$hostp="localhost";
$day=array("Понедельник","Вторник","Среда","Четверг","Пятница","Суббота","Воскресенье");
$link = mysqli_connect($hostp,$loginp,$passp);     
if (!$link) {
   printf("Невозможно подключиться к базе данных. Код ошибки: %s\n", mysqli_connect_error());
   echo "если вы еще не зашли в админку, перейдите по ссылке и создайте новые базы<a href='admin'>Администрирование</a>";
   exit;
}
$sql="Select * from teacherinfo.teacher where teacher=1";
$result=mysqli_query($link, $sql);

echo "Список учителей,  какое расписание меняем и  отсутствующие.<br><form action=sheded.php  method=post>";
for ($week=0; $week<7; $week++){
	echo "<input name=w".$week." type=checkbox>".$day[$week]."<br>";
}
echo "<table border=1><tr><td>Фио</td><td>Отсутствует</td></tr>";
while($row = mysqli_fetch_assoc($result)){
echo "<tr><td>".$row['famylya']." ".mb_substr($row['ima'],0,1).".".mb_substr($row['otchestvo'],0,1)."</td><td><input name=".$row['nomer']." type=checkbox> </td></tr>";
}
echo "</table><input type=submit value=Сохранить>";