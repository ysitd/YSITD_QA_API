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
$GLOBALS['DB'] = new MysqliDb ($db_host, $db_user, $db_password, $db_name);

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
$userinfo = $GLOBALS['DB']->where('user', $tguser)
                          ->get(['rightanswer', 'wronganswer']);
echo JSON_Encode($userinfo);

?>
