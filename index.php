<?php
session_start();
try {
    require_once 'autoload.php';

    $page = new Controller();
    $page->render();

} catch (\Exception $e) {
    echo $e->getMessage();
    exit();
}