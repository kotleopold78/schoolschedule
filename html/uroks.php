<?php
include_once "./schedule/bases.php";
include_once "./schedule/var.php";
$times=localtime();
//$times[2]=14;
//$times[1]=55;
$zam=0;
$zam1=0;
mysqli_select_db($link, 'uroki');
$result = mysqli_query($link, 'SELECT timer,mnog FROM urok');

for($i=0;$i<=($lessonend*2); $i++){
$row = mysqli_fetch_assoc($result);
$itog[$i]=$row['mnog'];
if ($itog[$i]>900){
$itog[$i]=900;
}
}


$itog1=$times[2]*60+$times[1];

for($i=0;$i<($lessonend*2); $i++){

if ($itog[$i]<=$itog1){
if ($itog[$i+1]>=$itog1){
break;
}}
}

if ($times[6]>0 && $times[6]<($shoolday+1)){
	
if ($i<16){
if($i%2==0){
echo "Перемена ";
$rtr=(int)($i/2);
echo $rtr;
}else{
echo "Урок ";
$rtr=(int)($i/2);
echo $rtr+1;
}
$ti=$itog[$i+1]-$itog1;

if ($ti>0){
echo ", до звонка : ";
echo $ti;
$timod=($ti%10);
if (($timod>4)||($timod==0)) echo " Минут";
if (($timod<5)&&($timod>1)) echo " Минуты";
if ($timod==1) echo " Минута";
}else{
	echo " Звонок";
}
$sql='SELECT * FROM `peremen` where begin='.date("y").date("m").date("d");
//echo $sql;
$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result)!=0){
$zam=1;
}
//$urk=(int)($i/2)+1;

}else{
	$rtr=8;
if ($times[6]!=$shoolday){
	echo" Уроки закончены, до завтра!";
} else{
echo "До свидания, увидимся в понедельник! Муа ха ха";
}
}
}else{
	$rtr=8;
echo "До свидания, увидимся в понедельник! Муа ха ха";
}

$uroku=$rtr+1;
$countclass=array("Нет урока","Нет урока","Нет урока","Нет урока","Нет урока","Нет урока","Нет урока","Нет урока","Нет урока");
echo "|<table border=5 width=100%><tr>";
for ($cla=$clasbeg; $cla<=$clasend; $cla++){
if ($zam==0) {
$sql="SELECT * FROM `raspisanie` where `day`=".date('N')." AND `class`=".$cla;
}else{
$sql='SELECT * FROM `peremen` where  `class`='.$cla.'  AND begin='.date("y").date("m").date("d");
}
//echo $sql;
$tex='';
$nomuroc=1;	
$result = mysqli_query($link, $sql);

  while( $row = mysqli_fetch_assoc($result) ){
        
  if ($nomuroc!=$uroku){
  $tex=$tex.$row['predmet']."<br>";
  }else{
	$tex=$tex."<font color=blue>".$row['predmet']."</font><br>";  
  }
  $nomuroc++;
  }
  if ($uroku<=($nomuroc-1)){
  $countclass[$cla-1]=$tex;
  }else{
	$countclass[$cla-1]="Нет урока";  
  }
  //echo $tex;
}
  for ($ttr=($clasbeg-1); $ttr<$clasend; $ttr++){


if (mb_stripos($countclass[$ttr], "Нет урока")===false){
if ($zam<1){
echo "<td><div class= 'lesson'>".$countclass[$ttr]."</div></td>";
}else{
echo "<td><div class= 'zamena'>".$countclass[$ttr]."</div></td>";	
}
if (($ttr+1)%3==0) echo "</tr><tr>";
}else{
	$dat=date('N')+1;
	//echo $dat."<br>";
	if ($dat>$shoolday) $dat=1;
	$o1=1;
	$datefut=9;
	$tomorrow=0;
	while ($datefut>$shoolday){
	$tomorrow = mktime(0,0,0,date("m"),(date("d")+$o1), date("Y"));

$datefut=date("N", $tomorrow);
//echo "dd=".$datefut." - ";
	
	$sql1='SELECT * FROM `peremen` where begin='.date("ymd",$tomorrow);
//echo $sql1;
$result1 = mysqli_query($link, $sql1);
if (mysqli_num_rows($result1)!=0){
$zam1=1;

}
if ($zam1>0) break;
$o1++;
	}
//echo $zam1;
	//$sql1="SELECT * FROM `raspisanie` where `day`=".$dat." AND `class`=".($ttr+1);
	if ($zam1==0) {
$sql1="SELECT * FROM `raspisanie` where `day`=".$dat." AND `class`=".($ttr+1);
}else{
$sql1='SELECT * FROM `peremen` where  `class`='.($ttr+1).' AND begin='.date("ymd",$tomorrow);
}
//echo $sql1;
$result1 = mysqli_query($link, $sql1);

if ($zam1==0){
echo "<td><div  class = 'lessons'>Класс ".($ttr+1)."<br>Уроки на ". date("d-m-Y",$tomorrow)."<br>";
}else{
	echo "<td><div  class = 'lessons1'>Класс ".($ttr+1)."<br>Уроки на ". date("d-m-Y",$tomorrow)."<br>";
}
while( $row1 = mysqli_fetch_assoc($result1) ){
echo $row1['predmet']."<br>";

//echo $sql1;
}
$zam1=0;
echo "</div></td>";
if (($ttr+1)%3==0) echo "</tr><tr>";
}
  
} 
echo"</table>";




?>
