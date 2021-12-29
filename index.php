<?php
if (isset($_GET['logout']) && $_GET['logout']) {
    session_start();
    if (isset($_SESSION['user'])) {
        unset($_SESSION['user']);
    }
    header('Location: .');
    die();
}
include_once($_SERVER['DOCUMENT_ROOT'] . '/views/index.php');
