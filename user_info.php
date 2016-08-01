<?php
//POST DATA
$token = $_POST['token'];
$tguser = (INT)$_POST['user']; //Telegram User ID

//Variables
$config = include('config.php');
$hosttoken = $config['token'];
$db_host = $config['db_host'];
$db_name = $config['db_name'];
$db_user = $config['db_user'];
$db_password = $config['db_password'];

//Database
$db = new PDO('mysql:host='.$db_host.';dbname='.$db_name.';charset=utf8', $db_user, $db_password);

//Check POST Data
if ($token = null or $tguser =null){
    echo("Not correct POST Data")
    die;
}

//check token
if($token != $hosttoken){
    echo("Auth Fail");
    die;
}

//Get User info
$UserInfo = $db->prepare("SELECT rightanswer, wronganswer FROM user WHERE user = :user");
$UserInfo->bindParam(':user',$tguser, PDO::PARAM_INT);
$UserInfo->execute();
$Object = $UserInfo->fetchObject();
echo JSON_Encode($Object);

?>
