<?php
include_once "bases.php";
include_once "var.php";
   

$nobase=0;
$ord=0;
$nopass=1;





	





if (!isset($_COOKIE["passt"])){
	include ("login.php");
	exit;
}
if (!password_verify($admpass,$_COOKIE["passt"]){
	//if ($_COOKIE["passt"]!=$admpass){
		include ("login.php");
	exit;
}
	
?>

<!DOCTYPE html>
<style type="text/css">
        .err{ 
 
    color: #FF0000; 
    font-size: 32pt;
   }
   </style> 
<div id="teach" style="font-size: 22px;">Портал службы расписаний </div>

<table border=1 width="100%"><tr><td>Список служебных ссылок</td><td>Сегодня :<div id="current_date_time_block2" style="font-size: 22px;">10:41:45<br>9-4-2023<br>Воскресенье</div></td>
</tr><tr><td></a><br><a href='permanent.php' >Замена постоянного расписания</a><br><a href='tempus.php' >Добавление временного расписания</a></td></tr></table>


<script type="text/javascript">
    
    /* каждую секунду получаем текущую дату и время */
    /* и вставляем значение в блок с id "current_date_time_block2" */
    setInterval(function () {
let workd=["Воскресенье","Понедельник","Вторник","Среда","Четверг","Пятница","Суббота"];
	let date =  new Date();
let hour=date.getHours();
let minu=date.getMinutes();
let sec=date. getSeconds();
let day=date.getDate();
let mouns=date.getMonth()+1;
let workday=date.getDay();
let Year=date.getFullYear();
 
	
if (hour<10) hour="0"+hour;
if (minu<10) minu="0"+minu;
if (sec<10) sec="0"+sec;
        document.getElementById('current_date_time_block2').innerHTML = hour+':'+minu+':'+sec+"<br>"+day+"-"+mouns+"-"+Year+"<br>"+workd[workday];
    }, 1000);
</script>
