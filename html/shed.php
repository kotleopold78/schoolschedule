<?php
include_once "./schedule/bases.php";
include_once "./schedule/var.php";
$times=localtime();
//$times[2]=14;
//$times[6]=3;
//var_dump ($times);
$zam=0;
$zam1=0;
$redline=0;
mysqli_select_db($link, 'uroki');
//$result = mysqli_query($link, 'SELECT timer,mnog FROM urok');
$week=array("Понедельник","Вторник","Среда","Четверг","Пятница","Суббота","Воскресенье");

echo "<table rules=cols width='100%'><tr>";
$tr=0;
for ($coclass=$clasbeg;$coclass<=$clasend; $coclass++){
if ($tr==1){
echo "<td bgcolor=#FFDEAD>".$coclass. "класс</td>";	
$tr=0;
}else{
	echo "<td>".$coclass. "класс</td>";	
	$tr=1;
}

}
//echo "<tr><td>1 класс</td><td bgcolor=#FFDEAD>2 класс</td><td>3 класс</td><td bgcolor=#FFDEAD>4 класс</td><td>5 класс</td><td bgcolor=#FFDEAD>6 класс</td><td>7 класс</td><td bgcolor=#FFDEAD>8 класс</td><td>9 класс</td></tr>";	
echo "</tr>";
for ($workday=1; $workday<=7; $workday++){
	$zam=0;
	if ($workday<$times[6]) {
		$dob=7;
	}else{
	$dob=0;
	}
	$dates=date("y").date("m").date("d",mktime(0, 0, 0, date("m")  , (date("d")-$times[6]+$workday+$dob), date("Y")));
	//echo $dates;
	//echo "<br>";
	$sql='SELECT * FROM `peremen` where begin='.$dates;
//echo $sql;
$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result)!=0){
$zam=1;
$redline=1;
}
	$sql="SELECT * FROM `raspisanie` where `day`=".$workday;
	$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result)!=0){
	if ($workday==$times[6]){
		echo "<tr bgcolor=00ffff><td> </td><td> </td><td> </td><td> </td><td  align='center' > ";
	}else{
		echo "<tr bgcolor=#90EE90><td> </td><td> </td><td> </td><td> </td><td  align='center' bgcolor=#90EE90 > ";
	}
echo $week[$workday-1];
echo "</td><td>".date("d",mktime(0, 0, 0, date("m")  , (date("d")-$times[6]+$workday+$dob), date("Y")))."-".date("m")."-".date('y')."</td><td> </td><td> </td><td></td></tr>";//<table rules=cols width='100%'>";

for ($line=1; $line<=$lessonend; $line++){
	$sql="SELECT * FROM `raspisanie` where `day`=".$workday." And lesson=".$line;
	$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result)!=0){
echo "<tr>";
$co=0;	
for ($column=$clasbeg; $column<=$clasend; $column++){	
if ($co>=1){
//echo "<td bgcolor=#FFDEAD>";
if ($zam>0){
	echo "<td bgcolor=#FF4500>";
}else{
	echo "<td bgcolor=#FFDEAD>";
}
$co=0;
}else{
echo "<td>";
$co=1;	
}
if ($zam==0) {
$sql="SELECT * FROM `raspisanie` where `day`=".$workday." And lesson=".$line." and class=".$column;
//echo $sql;
//echo "<br>";
}else{
$sql='SELECT * FROM `peremen` where  `class`='.$column.' And lesson='.$line.' AND begin='.$dates;
//echo $sql;
}
//echo $sql;
$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result)!=0){
   $row = mysqli_fetch_assoc($result);
  echo $row['predmet'];
}
echo "</td>";
}
echo "</tr>";	
}
}
//echo "</table></td></tr>";
echo "</td></tr>";
}
}
echo "</table><br>";
If ($redline>0) echo "<div class=warning1>Внимание, временное расписание</div>";









?>
