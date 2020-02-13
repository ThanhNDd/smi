<?php include("common.php");

class Authen
{
  public static function authen()
  {
    if (isset($_COOKIE["is_login"]) && $_COOKIE["is_login"]) {
      echo "logged";
      header('location:' . Common::getPath());
      exit;
    } else {
      echo "not login";
      $url = Common::getPath() . "src/view/login";
      header('location:' . $url);
      exit;
    }
  }
}
