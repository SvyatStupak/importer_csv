<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

try {
    require_once 'autoload.php';

    $page = new Controller();
    $page->render();

} catch (\Exception $e) {
    echo $e->getMessage();
    exit();
}