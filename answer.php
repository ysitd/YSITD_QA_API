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
 echo("Auth Fail");
 die;
}

//Database Connection
$GLOBALS['DB'] = new MysqliDb ($db_host, $db_user, $db_password, $db_name);

//if no more question
if ($userquestion == $config[questions]){
    die("No_more_question");
}

//if database question id != user question id
if ($qnumber != $QuestionID){
    die("question_id_not_correct");
}


$QuesrionQueueList = $GLOBALS['DB']->where('qalist', $tguser)
                                   ->get('user', ['list', 'now']);
$UserQuestionID    = $QuesrionQueueList->now;
$UserQuestionQueue = JSON_Decode($QuesrionQueueList->list);
$QuestionID        = $UserQuestionQueue[$UserQuestionID] + 0;
$QuesrionList = $GLOBALS['DB']->where('question', $QuestionID)
                                   ->get(['id', 'question', 'author','answers']);
$TempArray    = JSON_Decode($QuesrionList->answers);
$QuesrionList->answers = $TempArray;
echo JSON_Encode($QuesrionList);


if ($correct == 0){
    $updateuser = $GLOBALS['DB']->update('user', 'wronganswer' => $GLOBALS['DB']->inc(1)]);
    $updatenow  = $GLOBALS['DB']->update('qalist', 'now' => $GLOBALS['DB']->inc(1)]);
    $updatenext = $GLOBALS['DB']->update('qalist', 'next' => $GLOBALS['DB']->inc(1)]);
}

if ($correct == 1){
    $updateuser = $GLOBALS['DB']->update('user', 'rightanswer' => $GLOBALS['DB']->inc(1)]);
    $updatenow  = $GLOBALS['DB']->update('qalist', 'now' => $GLOBALS['DB']->inc(1)]);
    $updatenext = $GLOBALS['DB']->update('qalist', 'next' => $GLOBALS['DB']->inc(1)]);
}


?>
