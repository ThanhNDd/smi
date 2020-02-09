<?php
if (!defined('__PATH__')) define('__PATH__', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}/smi/");

if (isset($_COOKIE["is_login"]) && $_COOKIE["is_login"]) {
    echo "logged";
    header('location:' . __PATH__);
    exit;
} else {
    echo "not login";
    $url = __PATH__ . "src/view/login";
    header('location:' . $url);
    exit;
}