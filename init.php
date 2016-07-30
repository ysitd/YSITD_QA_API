<?php

//Variables
$config = require_once __DIR__ . '/db.php';
//Database
$db = $config['db'];

//add table if not exist
$userTableCreate = "CREATE TABLE IF NOT EXISTS `user` (
             id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
             user INT NOT NULL,
             rightanswer INT NOT NULL,
             wronganswer INT NOT NULL,
             createdate TIMESTAMP
             )";

$db->exec($userTableCreate);

$questionTableCreate = "CREATE TABLE IF NOT EXISTS `question` (
             id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
             question TEXT NOT NULL,
             author TEXT NOT NULL,
             answers TEXT NOT NULL
             )";

$db->exec($questionTableCreate);

$qalist = "CREATE TABLE IF NOT EXISTS `qalist` (
           user INT NOT NULL,
           list TEXT NOT NULL,
           now INT NOT NULL,
           next INT NOT NULL
           )";
$db->exec($qalist);

//setup uuid
$setupuuid="ALTER TABLE user ADD UNIQUE (user);
            ALTER TABLE question ADD UNIQUE (id);
            ALTER TABLE qalist ADD UNIQUE (user);";
$db->exec($setupuuid);

?>
