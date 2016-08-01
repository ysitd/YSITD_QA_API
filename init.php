<?php

//Variables
$config= include('config.php');
//Database
$GLOBALS['DB'] = new MysqliDb ($db_host, $db_user, $db_password, $db_name);

//add table user for recode user's info (id,rightanswe,wronganswer)

$GLOBALS['DB']->column('id')          ->INT()->AUTO_INCREMENT()->UNIQUE()
              ->column('user')        ->INT()
              ->column('rightanswer') ->INT()
              ->column('wronganswer') ->INT()
              ->column('createdate')  ->INT()->TIMESTAMP()
              -create('user');

//create question for record data
$GLOBALS['DB']->column('id')      ->INT()->AUTO_INCREMENT()->UNIQUE()
              ->column('question')->TEXT()
              ->column('author')  ->TEXT()
              ->column('answers') ->TEXT()
              -create('question');

//create qalist for recode user question queue list
$GLOBALS['DB']->column('user')->INT()->UNIQUE()
              ->column('list')->TEXT()
              ->column('now') ->INT()
              ->column('next')->INT()
              -create('qalist');

?>
