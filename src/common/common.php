<?php

class Common
{
  public static function getPath()
  {
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
      $path = "https";
    } else {
      $path = "http";
    }
    $path .= "://{$_SERVER['HTTP_HOST']}/smi/";
    echo $path;
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
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
      $path = "https";
    } else {
      $path = "http";
    }
    $path .= "://{$_SERVER['HTTP_HOST']}/smi/src/view/login";
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
}
