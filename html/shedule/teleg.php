<?php
include_once "var.php";

if ($proxy>0){
$aContext = array(
    'http' => array(
        'proxy' => 'tcp://10.0.54.52:3128',
        'request_fulluri' => true,
    ),
);
$cxContext = stream_context_create($aContext);
}
  $apiToken = $token;
  
  $data = [
      'chat_id' => $caller,
	  'text' => $data1,
	'reply_markup' => json_encode(array('keyboard' => array(array(array('text' => 'Питание','url' => 'food',),array('text' => 'расписание','url' => 'shedule',),
      )),
    'one_time_keyboard' => TRUE,
    'resize_keyboard' => TRUE,
  )),
  ];
  var_dump ($data);
  if ($proxy>0){
  $response = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" . http_build_query($data),False, $cxContext );
  }else{
	$response = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" . http_build_query($data));  
  }
 // var_dump ($response);
 // echo "<br>";
?>