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
    echo("Not correct POST Data")
    die;
}

//Check Token
if (!$token = $hosttoken){
    echo("Auth Fail");
    die("Auth Fail");
}

//Database Connection
$GLOBALS['DB'] = new MysqliDb ($db_host, $db_user, $db_password, $db_name);

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
?>
