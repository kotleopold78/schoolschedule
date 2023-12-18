<?php
$times=localtime();


echo "До нового года ";
//echo 364-$times[7];
//echo " дня <br><img src='http://192.168.0.7/img/2.jpg'>";
echo mktime(0,0,0,12,31,2023);//-time();//-mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
//echo date("z",mktime(0,0,0,5,23,2022))-$times[7];
//echo "много много";
//echo " дня";
//echo "С новым учебным годом!  ";
//echo date("z",mktime(0,0,0,5,25,2022))-$times[7];
echo " секунд";


?>