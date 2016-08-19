<?php
//POST DATA
$tguser       = (INT)$_POST['user']; //Telegram User ID
$token        = $_POST['token'];

//Variables
$config       = include('config.php');
$hosttoken    = $config['token'];
$db_host      = $config['db_host'];
$db_name      = $config['db_name'];
$db_user      = $config['db_user'];
$db_password  = $config['db_password'];

if ($token = null or $tguser =null){
    die("NOT_CORRECT_POST_DATA");
}

//Check Token
if (!$token = $hosttoken){
    die("Auth_Failed");
}

//Database Connection
$db = new PDO('mysql:host='.$db_host.';dbname='.$db_name.';charset=utf8', $db_user, $db_password);

//get user question queue data
$QuesrionQueueList = $db->prepare("SELECT user, list, now, next FROM qalist WHERE user = :user");
$QuesrionQueueList->bindParam(':user',$tguser,PDO::PARAM_INT);
$QuesrionQueueList->execute();
$Object = $QuesrionQueueList->fetchObject();

$UserQuestionID    = $Object->now;
$UserQuestionQueue = JSON_Decode($Object->list);
$QuestionID        = $UserQuestionQueue[$UserQuestionID] + 0;

$QuestionList = $db->prepare("SELECT id, question, author, answers FROM question WHERE id = :id");
$QuestionList->bindParam(':id',$QuestionID,PDO::PARAM_INT);
$QuestionList->execute();
$Object2      = $QuestionList->fetchObject();
$TempArray    = JSON_Decode($Object2->answers);
$Object2->answers = $TempArray;
echo JSON_Encode($Object2);
