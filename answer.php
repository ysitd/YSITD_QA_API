<?php
//POST DATA
$tguser      = (INT)$_POST['user'];//Telegram User ID
$token       = $_POST['token'];
$QuestionID  = (INT)$_POST['question_id'];
$correct     = (INT)$_POST['correct'];

//Variables
$config      = include('config.php');
$hosttoken   = $config['token'];
$db_host     = $config['db_host'];
$db_name     = $config['db_name'];
$db_user     = $config['db_user'];
$db_password = $config['db_password'];
$PDONumber   = "1";

//Check POST DATA

if ($QuestionID = null or $correct = null or $token = null or $tguser =null){
    echo("Not correct POST Data")
    die;
}

//Check token
if ($token != $hosttoken ){
 die("AUTH_FAILED");
}

//Database Connection
$db = new PDO('mysql:host='.$db_host.';dbname='.$db_name.';charset=utf8', $db_user, $db_password);

//Read qalist table  to get user's correct question
$qalist                    = $db->prepare("SELECT user, list, now, next FROM qalist WHERE user = :user");
$qalist->bindParam(':user',$tguser,PDO::PARAM_INT);
$qalist->execute();

$Object                    = $qalist->fetchObject(); //get data
$UserCorrectQuestionNumber = $Object->now - 1 ;
$QuestionQueue             = JSON_Decode($Object->list);
$qnumber                   = $QuestionQueue[$UserCorrectQuestionNumber] + 0;

//if no more question
if ($userquestion == $config[questions]){
    die("No_more_question");
}

//if database question id != user question id
if ($qnumber != $QuestionID){
    die("question_id_not_correct");
}

if ($correct == 0){
    $updateuser = $db->prepare("UPDATE user SET wronganswer = wronganswer + :1 WHERE user=:user");
    $updateuser->bindParam(':1',$PDONumber,PDO::PARAM_INT);
    $updateuser->bindParam(':user',$tguser,PDO::PARAM_INT);
    $updateuser->execute();

    $updatenow = $db->prepare("UPDATE qalist SET now = now + :1 WHERE user=:user");
    $updatenow->bindParam(':1',$PDONumber,PDO::PARAM_INT);
    $updatenow->bindParam(':user',$tguser,PDO::PARAM_INT);
    $updatenow->execute();

    $updatenext = $db->prepare("UPDATE qalist SET next = next + :1 WHERE user=:user");
    $updatenext->bindParam(':1',$PDONumber,PDO::PARAM_INT);
    $updatenext->bindParam(':user',$tguser,PDO::PARAM_INT);
    $updatenext->execute();
}

if ($correct == 1){
    $updateuser = $db->prepare("UPDATE user SET rightanswer = rightanswer + :1 WHERE user=:user");
    $updateuser->bindParam(':1',$PDONumber,PDO::PARAM_INT);
    $updateuser->bindParam(':user',$tguser,PDO::PARAM_INT);
    $updateuser->execute();

    $updatenow = $db->prepare("UPDATE qalist SET now = now + :1 WHERE user=:user");
    $updatenow->bindParam(':1',$PDONumber,PDO::PARAM_INT);
    $updatenow->bindParam(':user',$tguser,PDO::PARAM_INT);
    $updatenow->execute();

    $updatenext = $db->prepare("UPDATE qalist SET next = next + :1 WHERE user=:user");
    $updatenext->bindParam(':1',$PDONumber,PDO::PARAM_INT);
    $updatenext->bindParam(':user',$tguser,PDO::PARAM_INT);
    $updatenext->execute();
}

?>
