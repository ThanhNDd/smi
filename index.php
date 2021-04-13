<?php
require_once("src/common/common.php");
Common::authen();

header("Location: ".Common::path()."src/view/orders/online.php");
die();
