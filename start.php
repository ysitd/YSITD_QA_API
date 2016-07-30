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
$config     = require_once __DIR__ . '/db.php';
$hosttoken  = $config['token'];
$question   = $config['questions'];
$PDONumber0 = (INT)"0";
$PDONumber1 = (INT)"1";
$PDONumber2 = (INT)"2";

//database
$db = $config['db'];

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
$userInsert = $db->prepare("INSERT IGNORE INTO `user` (user,rightanswer,wronganswer) VALUES (:user,:ra,:wa)");
$userInsert->bindParam(':user', $tguser, \PDO::PARAM_INT);
$userInsert->bindParam(':ra',$a, \PDO::PARAM_INT);
$userInsert->bindParam(':wa',$a, \PDO::PARAM_INT);
$userInsert->execute();

//INSERT qalist
$qaarray = array_combine(range(1, $question), range(1, $question));
shuffle($qaarray);
$encodearray=JSON_Encode($qaarray);
$userqalist = $db->prepare("INSERT IGNORE INTO `qalist` (user,list,now,next) VALUES (:user,:array,:c,:n)");
$userqalist->bindParam(':user', $tguser, PDO::PARAM_INT);
$userqalist->bindParam(':array', $encodearray, PDO::PARAM_STR);
$userqalist->bindParam(':c',$b, PDO::PARAM_INT);
$userqalist->bindParam(':n',$c, PDO::PARAM_INT);
$userqalist->execute();
?>
