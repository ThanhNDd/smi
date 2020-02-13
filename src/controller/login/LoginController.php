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
    $uid = $_POST["username"];
    $pwd = $_POST["password"];

    $result = $userDao->find_user($uid, $pwd);
    $url = Common::getPath();
    if ($result == "error") {
        $url .= "src/view/login";
    }
    $name = 'is_login';
    $value = true;
    $expire = time()+3600;
    $path = '/';
    setcookie($name, $value,$expire ,$path);
    header('location:' . $url);
    exit;
}
