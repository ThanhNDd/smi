<?php
session_start();
include("../../common/common.php");
include("../../common/DBConnection.php");
include("../../model/user/User.php");
include("../../dao/UserDAO.php");

$db = new DBConnect();
$userDao = new UserDAO();
$userDao->setConn($db->getConn());

if (isset($_POST["submit"])) {

//  $pass = $userDao->generate_password('In@682018');
//  echo $pass;
//  echo "<br>";
    $uid = $_POST["username"];
    $pwd = $_POST["password"];

    $result = $userDao->find_user($uid, $pwd);

    if ($result == "error") {
      Common::redirect_login_page();
    }
    $url = Common::path();
    $name = 'is_login';
    $value = true;
    $expire = time()+3600*24;
    $path = '/';
    setcookie($name, $value,$expire ,$path);
    header('location:' . $url);
    exit;
}

if (isset($_GET["logout"])) {
  $name = 'is_login';
  $value = true;
  $expire = time()-3600;
  $path = '/';
  setcookie($name, $value,$expire ,$path);
  Common::redirect_login_page();
}
