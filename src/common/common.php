<?php

class Common
{
    public static function path()
    {
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            $path = "https";
        } else {
            $path = "http";
        }
        $path .= "://{$_SERVER['HTTP_HOST']}/smi/";
        return $path;
    }

    public static function getPath()
    {
        echo Common::path();
    }

    public static function is_logged_in()
    {
        if (isset($_COOKIE["is_login"]) && $_COOKIE["is_login"]) {
            return true;
        } else {
            return false;
        }
    }

    public static function redirect_login_page()
    {
        $path = Common::path() . "/src/view/login";
        header("location:$path");
        exit;
    }

    public static function authen()
    {
        if (!Common::is_logged_in()) {
            Common::redirect_login_page();
        }
    }

    public static function authen_get_data()
    {
        if (!Common::is_logged_in()) {
            throw new Exception("Forbidden! You don't have permission to access this resource.");
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
