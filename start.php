<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.0 405 Method Not Allow');
    header('Allow: POST');
    exit(1);
}

//POST DATA
$tguser = intval($_POST["user"]); //Telegram User ID
$token = $_POST["token"];

//Variables
$config      = include('config.php');
$hosttoken   = $config['token'];
$question    = $config['questions'];
$PDONumber0  = (INT)"0";
$PDONumber1  = (INT)"1";
$PDONumber2  = (INT)"2";
$db_host     = $config['db_host'];
$db_name     = $config['db_name'];
$db_user     = $config['db_user'];
$db_password = $config['db_password'];

//database
$GLOBALS['DB'] = new MysqliDb ($db_host, $db_user, $db_password, $db_name);

//Check POST Data
if ($token = null or $tguser =null){
    echo("Not correct POST Data")
    die;
}

//check token
if (!$token = $hosttoken) {
    echo("Auth Fail");
    die("Auth Fail");
}

//INSERT user Table
$userInsert = $GLOBALS['DB']->insert('user', ['user'        => $tguser,
                                              'rightanswer' => $a,
                                              'wronganswer' => $a]);

//INSERT qalist
$qaarray = array_combine(range(1, $question), range(1, $question));
shuffle($qaarray);
$encodearray=JSON_Encode($qaarray);
$userqalist = $GLOBALS['DB']->insert('qalist', ['user'  => $tguser,
                                                'list'  => $encodearray,
                                                'now'   => "1",
                                                'next'  => "2"]);
?>
