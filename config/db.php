<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=expert',
    'charset' => 'utf8',
];

$pass2 = require(__DIR__ . '/passdb.php');
$db = $db+$pass2;
return $db;