<?php
include "inc.php";
ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);

global $link;


mysqli_select_db($link, 'uroki');
require_once 'SimpleXLSX.php';
$day=array("ПОНЕДЕЛЬНИК","Вторник","Среда","Четверг","Пятница","Суббота","Воскресенье");
$mou=array("января","февраля","марта","апреля","мая","июня","июля","августа","сентября","октября","ноября","декабря");
$lesson=array("1","2","3","4","5","6","7","8");
echo '<h1>Внесение временного расписания. Файл должен быть правильно отформатирован, уроки обязательно обозначены номером, вносится только лист расписания с рабочего листа - для печати. внутри должно быть обозначение  - временное расписание</h1>';
$yea=date("y");
$dayles=0;
$lele=0;
$mounts=0;
$datbeg1=0;
$empty=0;
$varrs=0;
$newws=0;
$obnow=0;
$daysob=0;
$last=-1;
$str0=0;
$dayobn=0;
if (isset($_FILES['file'])) {
	$uploaddir = "/var/www/html/schedule/schedule/".date('ymd').".xlsx";
	//if (move_uploaded_file($_FILES['file']['tmp_name'], $uploaddir)) {
		echo $uploaddir;
	if ( $xlsx = SimpleXLSX::parse( $_FILES['file']['tmp_name'] ) ) {
//$sql="truncate table uroki.peremen";
//$result=mysqli_query($link, $sql); 
		echo '<h2>Разбор файла</h2>';
		//echo '<table border="1" cellpadding="3" style="border-collapse: collapse">';
//$last=count($xlsx->sheetNames())-1;
$ll=count($xlsx->sheetNames());
	 for($i=0; $i<$ll;$i++){
		 
		$tex= $xlsx->sheetName($i);
		//echo 'Sheet Name 2 = '.$xlsx->sheetName($i)."<br>";
		$vremos=mb_stripos($tex, "ля печати");
		 if($vremos!==false) $last=$i;
	 }
//echo $last;
if ($last<0) {
	echo "не найдено расписание";
	//break;
}
		$dim = $xlsx->dimension();
		$cols = $dim[0];

		foreach ( $xlsx->rows($last) as $k => $r ) {
			//		if ($k == 0) continue; // skip first row
			//echo '<tr>';
			$str0++;
			//echo "<font color=red>новая линия ". $str0."<font color=black><br>";
			if ($dayobn>0) $lele++;
			for ( $i = 0; $i < $cols; $i ++ ) {
				if ($i==0){
					if ( $r[ $i ]=="") {
						$empty++;
					}else{
					$empty=0;	
				}}
					
				//echo '<td>' . ( isset( $r[ $i ] ) ? $r[ $i ] : '&nbsp;' ) . '</td>';
				if (isset( $r[ $i ] )){
					//echo $r[ $i ];
					//echo "<br>";
					if ($varrs!=1){
					$vrem=(mb_stripos($r[ $i ], "временное расписание"));
					if ($vrem!==false){
						$vrem=(mb_stripos($r[ $i ], " на "));
						echo "найдено временное<br>";
						for ($co=0; $co<12; $co++){
						$vrem1=(mb_stripos($r[ $i ], $mou[$co]));
						if ($vrem1!==false){
							$mounts=$co+1;
							break;
						}	
						}
						//echo $vrem1;
						$datbeg= mb_substr($r[ $i ], ($vrem+4),($vrem1-$vrem-5));
						echo "<br>Даты ".$datbeg;
						$vrem2=(mb_stripos($datbeg, "-"));
						if ($vrem2!==false){
							//echo "<br>".$vrem2."<br>";
						$datbeg1=mb_substr($datbeg, 0,($vrem2));	
						}else{
						$datbeg1=$datbeg;	
						}
						echo "<br><div style='font-size: 22px;'>начало цикла ".$datbeg1. " месяц № ".$mounts."</div>";
						
						$varrs=1;
					//echo "переход на следующую строку";
					break;
					}
					}
					for ($da=0;$da<7; $da++){
						if (mb_stripos($r[ $i ], $day[$da])!==false){
							echo "<br><br>";
							echo $r[ $i ];
					echo "<br>";
							echo "день недели найден ";
							$dayles++;
							$newws=0;
						$dayobn=1;
							echo $dayles;
							echo "<br>";
							$lele=0;
							$dates=date("N",mktime(0, 0, 0, $mounts  , $datbeg1+$dayles-1, date("Y")))-1;
							echo "День недели по вычисленному". $dates. " день недели по дате". $da;
							if ($dates!=$da) echo "<div class=err>Внимание, несовпадение даты и дня недели, проверьте правильность файла</div>";
							//echo "выход из дней недели:<br>";
							break 2;
					}
					}
					if ($dayles>0){
						echo "номер урока ".$lele."<br>";
					if (($lele>0)&&($r[$i]!="")&&($i!=0)){
							
						//$sql="INSERT INTO uroki.peremen (`day`, `class`, `lesson`, `predmet`) VALUES (".($datbeg1+$dayles-1).",".$i.",".$lele.",'".$r[$i]."')";
						
						$data=date("ymd",mktime(0, 0, 0, $mounts  , $datbeg1+$dayles-1, date("Y")));
						//echo $data1;
						if ($newws==0){
						$sql="Select * from peremen where begin=".$data;
						//echo $sql."<br>";
						$result=mysqli_query($link, $sql);
						if (mysqli_num_rows($result)!=0){
						$obnow=1;	
						echo "<br><br>происходит обновление расписания<br><br>";	
						}
						$newws=1;
						}
						if (($obnow==1)&&($dayobn==1)){
							$sql= "delete from peremen where begin=".$data;
							//echo $sql."<br>";
							//$sql = mysqli_real_escape_string($link, $sql);
							$result=mysqli_query($link, $sql);
							$obnow=0;
						}
						$sql="INSERT INTO peremen(`class`, `lesson`, `predmet`, `begin`) VALUES (".$i.",".$lele.",'".$r[$i]."',".$data.")";
						
						if ($varrs==1){
							//$sql = mysqli_real_escape_string($link, $sql);
							//echo $sql."<br>";
						$result=mysqli_query($link, $sql);
						}else{
						echo "<br>Внимание, ошибка, это не временное расписание, запись не производится";	
						}
					}
					/*for ($le=0;$le<8; $le++){
						if (mb_stripos($r[ $i ], $lesson[$le])===0){
							echo "<br>Урок найден ";
							echo $le+1;
							$lele=$le+1;
							break;
						} 
							
					}*/
					
					 
						
				}
				}
			}
			//echo "empty".$empty;
			if ($empty>2) break;
			//echo '</tr>';
			
		}
		//echo '</table>';
	} else {
		echo SimpleXLSX::parseError();
	}
	move_uploaded_file($_FILES['file']['tmp_name'], $uploaddir);
}
echo '<h2>Загрузка файла расписания</h2>
<form method="post" enctype="multipart/form-data">
*.XLSX <input type="file" accept=".xlsx" name="file"  />&nbsp;&nbsp;<input type="submit" value="Прочитать" />
</form>';
include "end.php";
?>
