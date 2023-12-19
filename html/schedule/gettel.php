<?php
include_once "var.php";
include"bases.php";
include"function.php";
$ra=0;
$nom=0;
$proxy=1;
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
 
	  echo "begin";
	  echo "https://api.telegram.org/bot$apiToken/getupdates?offset=".($nom+1);
	  while(1){

	$response = file_get_contents("https://api.telegram.org/bot$apiToken/getupdates?offset=".($nom+1),False, $cxContext);  
  
  
  $response=json_decode($response,true);
 //var_dump($response);
 $data1="я вас услышала... ";
  
 if (!empty($response['result'][0]['message'])) {
	 echo "start";
   $textc=count ($response['result']);
   echo "all ".$textc."\n";
   for ($i=0;$i<$textc; $i++){
   echo "input ".$i."\n";
	   $tex=$response['result'][$i]['message']['text'];
	  
  echo $response['result'][$i]['message']['text']."\n";
 $nom=$response['result'][$i]['update_id'];
  echo $response['result'][$i]['update_id']."\n";

  echo $response['result'][$i]['message']['chat']['id']."<br>";
  $cll=$response['result'][$i]['message']['chat']['id'];
 
   if ((mb_stripos($tex, "расписание")!==false)||(mb_stripos($tex, "shedule")!==false)){
		 echo "запрос расписания";
$ra=1;
shedule();	
//$data1="Расписание будет здесь";	 
	   
   }
    if ((mb_stripos($tex, "питание")!==false)||(mb_stripos($tex, "food")!==false)){
		 echo "запрос питания";
$ra=1;	
food();
//$data1="питание будет здесь";	 
	   
   }
       if (mb_stripos($tex, "учитель")!==false){
		 echo "запрос расписания преподоателя";
$ra=1;
$fi=explode(" ",$tex);
var_dump($fi);
teach ($fi[1]);	
//$data1="список занятий будет здесь";	 
	   
   }
 }
 }
   if ($ra>0){
 $caller=$cll;
 include "teleg.php";
 $ra=0;
   }
   sleep (5);
  }
?>