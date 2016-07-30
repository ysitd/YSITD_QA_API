<?php
//POST DATA
$token = $_POST['token'];
$tguser = (INT)$_POST['user'];

//Variables
$config = include('config.php');
$hosttoken = $config['token'];
$db_host = $config['db_host'];
$db_name = $config['db_name'];
$db_user = $config['db_user'];
$db_password = $config['db_password'];

//Database
$db = new PDO('mysql:host='.$db_host.';dbname='.$db_name.';charset=utf8', $db_user, $db_password);

//check token
if($token != $hosttoken){
    echo("Auth Fail");
    die("Auth Fail");
}

$userinfo = $db->prepare("SELECT rightanswer, wronganswer FROM user WHERE user = :user");
$userinfo->bindParam(':user',$tguser, PDO::PARAM_INT);
$userinfo->execute();
$obj2 = $userinfo->fetchObject();
echo JSON_Encode($obj2);

?>
