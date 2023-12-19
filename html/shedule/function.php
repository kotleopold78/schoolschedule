<?php
include"bases.php";
function food(){
	global $link, $data1;
		$result = mysqli_query($link,'SELECT * FROM portal.classkod');
$resu=0;
	while($row = mysqli_fetch_assoc($result)){
$kl[$row['nomer']]=$row['klass'];
$ko[$row['nomer']]=$row['kod'];
$resu++;
}
$data1 = "Информация для сведенья :\n";
for ($klass=1; $klass<=$resu;$klass++){
		$result = mysqli_query($link, 'SELECT * FROM portal.bazapit  where class='.$ko[$klass].' AND data='.date("y").date("m").date("d"));
	If (mysqli_num_rows($result)==0) {
	$rr=1;
	}else{
	$rr=0;
	}
$result = mysqli_query($link, 'SELECT * FROM portal.bazapit  where class='.$ko[$klass].' AND pitanie=1 AND data='.date("y").date("m").date("d"));
	 
		 
		 if ($rr==0){
		 $data1=$data1. " В классе ". $kl[$klass]. " питаются ".mysqli_num_rows($result)."\n";
	}else{
		 $data1=$data1. " Класс ". $kl[$klass]. " Незаполнен\n";
	}
}
//$caller=$cook;
		 $data1=$data1. " Я подумала, что это может быть интересно...\n\n";
}
function shedule(){
	global $link, $data1;
			$zam1=0;
		mysqli_select_db($link, 'uroki');
	$dat=date('N')+1;
	//echo $dat."<br>";
	if ($dat>5) $dat=1;
	$o1=1;
	$datefut=9;
	$tomorrow=0;
	while ($datefut>5){
	$tomorrow = mktime(0,0,0,date("m"),(date("d")+$o1), date("Y"));

$datefut=date("N", $tomorrow);
//echo "dd=".$datefut." - ";
	
	$sql1='SELECT * FROM peremen where begin='.date("ymd",$tomorrow);
//echo $sql1;
$result1 = mysqli_query($link, $sql1);
if (mysqli_num_rows($result1)!=0){
$zam1=1;
//echo "peremen";
}
if ($zam1>0) break;
$o1++;
	}
		//if ($zam1==1) {

//$sql1='SELECT * FROM `peremen` where  `class`='.($ttr+1).' AND begin='.date("ymd",$tomorrow);
//$result1 = mysqli_query($link, $sql1);
//}
//echo $sql1;

if ($zam1==0){
	$data1="Внимание, на ". date("d-m-Y",$tomorrow)." изменений в работу испытательных камер я не внесла\n";
//echo "<div  class = 'lessons'>Уроки на ". date("d-m-Y",$tomorrow)."<br>";
}else{
	$data1="Внимание, на ". date("d-m-Y",$tomorrow)." я внесла следующие изменения в работу испытательных камер, согласно уровням сложности\n";
	//echo $data1;
}
//echo $data1;

		if ($zam1==1) {
for ($i=1;$i<=9; $i++){
	
	$data1=$data1."\n Уровень ".$i."\n";
$sql1='SELECT * FROM `peremen` where  `class`='.($i).' AND begin='.date("ymd",$tomorrow);
$result1 = mysqli_query($link, $sql1);

while( $row1 = mysqli_fetch_assoc($result1) ){
//echo $row1['predmet']."<br>";
$data1=$data1.$row1['predmet']."\n";

}


		}
		}
$zam1=0;
}
function teach($fio){
	global $link, $data1;
	$zam1=0;
	$data1="Расписание на следующий рабочий день\n";
	mysqli_select_db($link, 'uroki');
		$dat=date('N')+1;
	//echo $dat."<br>";
	if ($dat>5) $dat=1;
	$o1=1;
	$datefut=9;
	$tomorrow=0;
	while ($datefut>5){
	$tomorrow = mktime(0,0,0,date("m"),(date("d")+$o1), date("Y"));

$datefut=date("N", $tomorrow);
echo "dd=".$datefut." - ";
	
	$sql1='SELECT * FROM peremen where begin='.date("ymd",$tomorrow);
//echo $sql1;
$result1 = mysqli_query($link, $sql1);
if (mysqli_num_rows($result1)!=0){
$zam1=1;

}
if ($zam1>0) break;
$o1++;
	}
//cho "zamena".$zam1;



$result = mysqli_query($link, 'SELECT * FROM teacher where fio="'.$fio.'"');

while( $row = mysqli_fetch_assoc($result) ){
if ($zam1==1){
$sql1="SELECT * FROM peremen where begin=".date('ymd',$tomorrow)." and predmet like'".$row['lesson']."%' and class=".$row['class'];
}else{
$sql1="SELECT * FROM raspisanie where day=".date('N',$tomorrow)." and predmet like'".$row['lesson']."%' and class=".$row['class'];	
}
//echo $sql1."<br>";
$result1 = mysqli_query($link, $sql1);
while( $row1 = mysqli_fetch_assoc($result1) ){
	$ur[$row1['lesson']]=$row1['predmet'];
	$cl[$row1['lesson']]=$row1['class'];
	//$data1=$data1."Урок ".$row1['lesson']." предмет ". $row1['predmet']." класс ". $row1['class']."\n";
	//echo "Урок ".$row1['lesson']." предмет ". $row1['predmet']." класс ". $row1['class']."<br>";
}

}
for ($i=1;$i<=8; $i++){
if (empty($ur[$i])){
$data1=$data1. "Урок ".$i. " Пусто\n";
	
}else{
	$data1=$data1."Урок ". $i."-".$ur[$i]. "-". " класс ".$cl[$i]."\n";
}
}
}
		 ?>