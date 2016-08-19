<?php

//Variables
$config = require_once __DIR__ . '/db.php';
//Database
$db = $config['db'];

//add table user for recode user's info (id,rightanswe,wronganswer)
$userTableCreate = "CREATE TABLE IF NOT EXISTS `user` (
             id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
             user INT NOT NULL,
             rightanswer INT NOT NULL,
             wronganswer INT NOT NULL,
             createdate TIMESTAMP
             )";

$db->exec($userTableCreate);

//create question for record data
$questionTableCreate = "CREATE TABLE IF NOT EXISTS `question` (
             id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
             question TEXT NOT NULL,
             author TEXT NOT NULL,
             answers TEXT NOT NULL
             )";

$db->exec($questionTableCreate);

//create qalist for recode user question queue list
$qalist = "CREATE TABLE IF NOT EXISTS `qalist` (
           user INT NOT NULL,
           list TEXT NOT NULL,
           now INT NOT NULL,
           next INT NOT NULL
           )";
$db->exec($qalist);

//setup uuid for get data
$setupuuid="ALTER TABLE user ADD UNIQUE (user);
            ALTER TABLE question ADD UNIQUE (id);
            ALTER TABLE qalist ADD UNIQUE (user);";
$db->exec($setupuuid);
