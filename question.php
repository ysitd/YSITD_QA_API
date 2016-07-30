<?php
//POST DATA
$tguser = (INT)$_POST['user'];
$token = $_POST['token'];

//Variables
$config = include('config.php');
$hosttoken = $config['token'];
$db_host = $config['db_host'];
$db_name = $config['db_name'];
$db_user = $config['db_user'];
$db_password = $config['db_password'];

//Check Token
if (!$token = $hosttoken){
    echo("Auth Fail");
    die("Auth Fail");
}

//Database
$db = new PDO('mysql:host='.$db_host.';dbname='.$db_name.';charset=utf8', $db_user, $db_password);

//get data
$qalist = $db->prepare("SELECT user, list, now, next FROM qalist WHERE user = :user");
$qalist->bindParam(':user',$tguser, PDO::PARAM_INT);
$qalist->execute();
$obj = $qalist->fetchObject();

$userquestion = $obj->now;
$qa = JSON_Decode($obj->list);
$qnumber = $qa[$userquestion] + 0;

$qalist1 = $db->prepare("SELECT id, question, author, answers FROM question WHERE id = :id");
$qalist1->bindParam(':id',$qnumber, PDO::PARAM_INT);
$qalist1->execute();
$obj2 = $qalist1->fetchObject();
$tempArr = JSON_Decode($obj2->answers);
$obj2->answers = $tempArr;
echo JSON_Encode($obj2);
?>
