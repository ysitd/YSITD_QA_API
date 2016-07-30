<?php
//POST DATA
$tguser    = (INT)$_POST['user'];
$token     = $_POST['token'];
$qid       = (INT)$_POST['question_id'];
$correct   = (INT)$_POST['correct'];

//Variables
$config      = include('config.php');
$hosttoken   = $config['token'];
$db_host     = $config['db_host'];
$db_name     = $config['db_name'];
$db_user     = $config['db_user'];
$db_password = $config['db_password'];
$a           = "1";
//Check token
if ($token != $hosttoken ){
 echo("Auth Fail");
 die("Auth Fail");
}

//Database
$db = new PDO('mysql:host='.$db_host.';dbname='.$db_name.';charset=utf8', $db_user, $db_password);

$qalist = $db->prepare("SELECT user, list, now, next FROM qalist WHERE user = :user");
$qalist->bindParam(':user',$tguser, PDO::PARAM_INT);
$qalist->execute();
$obj = $qalist->fetchObject();
$userquestion = $obj->now - 1 ;
$qa = JSON_Decode($obj->list);
$qnumber = $qa[$userquestion] + 0;
if ($userquestion == $config[questions]){
    die("No_more_question");
}
if ($qnumber != $qid){
    die("question_id_not_correct");
}

if ($correct == 0){
    $updateuser = $db->prepare("UPDATE user SET wronganswer = wronganswer + :1 WHERE user=:user");
    $updateuser->bindParam(':1',$a, PDO::PARAM_INT);
    $updateuser->bindParam(':user',$tguser, PDO::PARAM_INT);
    $updateuser->execute();

    $updatenow = $db->prepare("UPDATE qalist SET now = now + :1 WHERE user=:user");
    $updatenow->bindParam(':1',$a, PDO::PARAM_INT);
    $updatenow->bindParam(':user',$tguser, PDO::PARAM_INT);
    $updatenow->execute();

    $updatenext = $db->prepare("UPDATE qalist SET next = next + :1 WHERE user=:user");
    $updatenext->bindParam(':1',$a, PDO::PARAM_INT);
    $updatenext->bindParam(':user',$tguser, PDO::PARAM_INT);
    $updatenext->execute();
}

if ($correct == 1){
    $updateuser = $db->prepare("UPDATE user SET rightanswer = rightanswer + :1 WHERE user=:user");
    $updateuser->bindParam(':1',$a, PDO::PARAM_INT);
    $updateuser->bindParam(':user',$tguser, PDO::PARAM_INT);
    $updateuser->execute();

    $updatenow = $db->prepare("UPDATE qalist SET now = now + :1 WHERE user=:user");
    $updatenow->bindParam(':1',$a, PDO::PARAM_INT);
    $updatenow->bindParam(':user',$tguser, PDO::PARAM_INT);
    $updatenow->execute();

    $updatenext = $db->prepare("UPDATE qalist SET next = next + :1 WHERE user=:user");
    $updatenext->bindParam(':1',$a, PDO::PARAM_INT);
    $updatenext->bindParam(':user',$tguser, PDO::PARAM_INT);
    $updatenext->execute();
}

?>
