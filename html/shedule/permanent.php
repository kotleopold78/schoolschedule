<?php
include "inc.php";
ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);

global $link;

require_once 'SimpleXLSX.php';
$day=array("ПОНЕДЕЛЬНИК","Вторник","Среда","Четверг","Пятница","Суббота","Воскресенье");
$lesson=array("1","2","3","4","5","6","7","8");
echo '<h1>Внесение постоянного расписания. Файл должен быть правильно отформатирован, уроки обязательно обозначены номером.</h1>';
$dayles=0;
$lele=0;
if (isset($_FILES['file'])) {
	
	if ( $xlsx = SimpleXLSX::parse( $_FILES['file']['tmp_name'] ) ) {
$sql="truncate table uroki.raspisanie";
$result=mysqli_query($link, $sql); 
		echo '<h2>Parsing Result</h2>';
		echo '<table border="1" cellpadding="3" style="border-collapse: collapse">';

		$dim = $xlsx->dimension();
		$cols = $dim[0];

		foreach ( $xlsx->rows() as $k => $r ) {
			//		if ($k == 0) continue; // skip first row
			echo '<tr>';
			for ( $i = 0; $i < $cols; $i ++ ) {
				//echo '<td>' . ( isset( $r[ $i ] ) ? $r[ $i ] : '&nbsp;' ) . '</td>';
				if (isset( $r[ $i ] )){
					//echo $r[ $i ];
					//echo "<br>";
					for ($da=0;$da<7; $da++){
						if (mb_stripos($r[ $i ], $day[$da])!==false){
							echo $r[ $i ];
					echo "<br>";
							echo "день недели найден ";
							$dayles=$da+1;
							echo $dayles;
							echo "<br>";
							$lele=0;
							break;
					}
					}
					if ($dayles>0){
					if (($lele>0)&&($r[$i]!="")&&($i!=0)){
							
						$sql="INSERT INTO uroki.raspisanie (`day`, `class`, `lesson`, `predmet`) VALUES (".$dayles.",".$i.",".$lele.",'".$r[$i]."')";
						echo $sql."<br>";
						$result=mysqli_query($link, $sql);
					}
					for ($le=0;$le<8; $le++){
						if (mb_stripos($r[ $i ], $lesson[$le])===0){
							echo "Урок найден ";
							echo $le+1;
							$lele=$le+1;
							break;
						}
							
					}
					
					 
						
				}
				}
			}
			echo '</tr>';
		}
		echo '</table>';
	} else {
		echo SimpleXLSX::parseError();
	}
}
echo '<h2>Загрузка файла расписания</h2>
<form method="post" enctype="multipart/form-data">
*.XLSX <input type="file" accept=".xlsx" name="file"  />&nbsp;&nbsp;<input type="submit" value="Прочитать" />
</form>';

include "end.php";
?>