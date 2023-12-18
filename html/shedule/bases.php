<?php
include_once "var.php";
global $link;

$link = mysqli_connect($hostp,$loginp,$passp);     
if (!$link) {
   printf("Невозможно подключиться к базе данных. Код ошибки: %s\n", mysqli_connect_error());
   echo "если вы еще не зашли в админку, перейдите по ссылке и создайте новые базы<a href='admin'>Администрирование</a>";
   exit;
}
  ?>