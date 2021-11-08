<?php
if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['status']) || !$_GET['status']) {
    header('HTTP/1.0 404 Not Found');
    header('Location: /error.php?status=404');
    die();
}
if ($_GET['status']=='404'){
    include('error/404.html');
    die();
}else{
    header('HTTP/1.0 404 Not Found');
    header('Location: /error.php?status=404');
    die();
}
