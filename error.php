<?php
header('HTTP/1.0 404 Not Found');
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['uri'])) {
    $arr = explode('.', $_GET['uri']);
    $ext = end($arr);
    if ($ext === 'php' || $ext === 'html' || $ext === 'htm') {
        @include('error/404.html');
    }
}
