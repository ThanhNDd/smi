<?php

include 'Constant.php';
date_default_timezone_set('Asia/Ho_Chi_Minh');
class Common
{
    public static function isAdmin() {
        if(isset($_COOKIE["is_admin"]) && $_COOKIE["is_admin"] == 1) {
            return "true";
        };
        return "false";
    }

    public static function isAdminRole()
    {
        return filter_var(Common::isAdmin(), FILTER_VALIDATE_BOOLEAN);
    }

    public static function path()
    {
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            $path = "https";
        } else {
            $path = "http";
        }
        $path .= "://{$_SERVER['HTTP_HOST']}/online/";
        return $path;
    }

    public static function getPath()
    {
        echo Common::path();
    }

    public static function check_logged() {
        if (isset($_COOKIE[Constant::COOKIE_NAME]) && $_COOKIE[Constant::COOKIE_NAME]) {
            $check = crypt(Constant::COOKIE_NAME, $_COOKIE[Constant::COOKIE_NAME]);
            return hash_equals($check, $_COOKIE[Constant::COOKIE_NAME]);
        }
        return false;
    }

    public static function get_user() {
        if (isset($_COOKIE["UID"]) && $_COOKIE["UID"]) {
            return $_COOKIE["UID"];
        }
        return 1;
    }

    public static function set_cookie($time = 1, $user) {
        $expire = time()+3600*24*$time;
        $path = '/';
        $salt = strtr(base64_encode(date("ddMMyyyy")), '+', '.');
        $salt = sprintf("$2y$%02d$", 10) . $salt;
        $value = crypt(Constant::COOKIE_NAME, $salt);
        setcookie(Constant::COOKIE_NAME, $value, $expire ,$path);
        // set cookie user id
        setcookie("UID", $user['id'], $expire ,$path);
        setcookie("display_name", $user['display_name'], $expire ,$path);
        setcookie("is_admin", $user['is_admin'], $expire ,$path);
        setcookie("acc", $user['username'], $expire ,$path);
    }

    public static function redirect_login_page()
    {
        $path = Common::path() . "/src/view/login";
        header("location:$path");
        exit;
    }

    public static function authen()
    {
        if (!Common::check_logged()) {
            Common::redirect_login_page();
        }
    }

    public static function authenIsNotAdminRole()
    {
        if (!Common::check_logged()) {
            Common::redirect_login_page();
        }
    }

    public static function authen_get_data()
    {
        if (!Common::check_logged()) {
            throw new Exception("403");
        }
    }

    public static function image_error()
    {
        echo Common::path() . "dist/img/img_err.jpg";
    }

    public static function no_avatar()
    {
      echo Common::path() . "dist/img/img_err.jpg";
    }

    public static function path_img()
    {
        echo Common::path() . "dist/uploads/";
    }
    public static function dir_upload_img()
    {
        return '../../../dist/uploads/';
    }
    public static function path_avatar()
    {
      echo Common::path() . "dist/avatars/";
    }
    public static function dir_upload_avatar()
    {
      return '../../../dist/avatars/';
    }
}
