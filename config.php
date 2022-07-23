<?php
// константи для подключения к базе данных
define('HOST', 'localhost');
define('DB', 'csv_import');
define('USER', 'root');
define('PASSWORD', 'root');

// игнорировать первую строку(название коллонок) с таблицы импорта 
define('PASS_FIRST', TRUE);

// массив полей в который будем осуществлять импорт
$fields = [
    'UID' => 'User id',
    'Name' => 'User name',
    'Age' => 'User age',
    'Email' => 'User email',
    'Phone' => 'User phone',
    'Gender' => 'User gender',
];


