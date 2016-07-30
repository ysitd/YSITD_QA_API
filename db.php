<?php
ob_start();
function init() {
    $config = require __DIR__ . '/config.php';
    $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8', $config['db_host'], $config['db_name']);
    $pdo = new \PDO($dsn, $config['db_user'], $config['db_password']);
    $config['db'] = $pdo;
}

return init();
