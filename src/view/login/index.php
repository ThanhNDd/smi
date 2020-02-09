<?php //require_once("../../common/common.php");
//$name = 'is_login';
//$value = true;
//$expire = time()-3600;
//$path = '/';
//setcookie($name, $value,$expire ,$path);
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo __PATH__ ?>dist/img/icon.png"/>
    <title>Đăng nhập</title>
    <?php require('../../common/css.php'); ?>
    <?php require('../../common/js.php'); ?>
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <img src="<?php echo __PATH__ ?>dist/img/icon.png" width="100px">
        <span style="display: block;">Shop Mẹ Ỉn</span>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Đăng nhập</p>
            <form action="<?php echo __PATH__ . 'src/controller/login/LoginController.php'?>" method="post">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="username" placeholder="Tên đăng nhập" autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="password" placeholder="Mật khẩu">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-5">
                        <button type="submit" class="btn btn-primary btn-block btn-flat" name="submit">
                            <i class="fas fa-sign-in-alt"></i> Đăng nhập
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
