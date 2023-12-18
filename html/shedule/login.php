<?php
include_once "bases.php";
include_once "var.php";
if (isset($_POST['pass'])) {
   

    
    $password = $_POST['pass'] ?? '';

  
      
        setcookie('passt', $password, 0, '/');
        header('Location: index.php');
		//echo $password;
    
}
?>
<html>
<head>
<style>
 html, body {
                height : 100%;
                width : 100%;
                overflow : hidden;
            }
.wrapper {
                height : 100%;
                width : 100%;
                padding: 20px;
}
 .content {
             
Position:absolute;
top:50%;
left:50%;
transform:translate(-50%,-50%); 
            }

</style>
    <title>Форма авторизации</title>
</head>
<body>
<span style="color: red;">
 
</span>

<form  method="post">
<div class="wrapper">
 <div class="content">

    
    <tr><td><label for="password">Пароль: </label><input type="password" name="pass" id="password"></td></tr>

    <tr><td><input type="submit" value="Войти"></td></tr></table></div>
	</div>
</form>
</body>
</html>
