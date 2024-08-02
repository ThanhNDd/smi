<?php
$root = dirname(__FILE__, 3);
require_once($root."/common/common.php");
Common::authen();

// if ($_SERVER['REQUEST_URI'] != '/index.php') {
//     $url = Common::path()."src/view/system/products.php";
//     header("Location: $url");
// } elseif ($_SERVER['REQUEST_URI'] != '/customers.php') {
//   $url = Common::path()."src/view/system/customers.php";
//     header("Location: $url");
// }
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Xuất dữ liệu hệ thống</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?php Common::getPath() ?>dist/img/icon.png"/>
    <?php require_once($root.'/common/css.php'); ?>
    <?php require_once($root.'/common/js.php'); ?>
    <style>

    </style>
</head>
<?php require($root.'/common/header.php'); ?>	
<?php require($root.'/common/menu.php'); ?>
<section class="content pt-3">
	<div class="card">
		<div class="m-3 p-0">
      <ul class="nav nav-pills">
        <li class="nav-item">
          <!-- <a class="nav-link active" data-toggle="tab" href="#products">Sản phẩm</a> -->
          <a href="<?php Common::getPath() ?>src/view/system/products.php" class="nav-link">
            Sản phẩm
          </a>
        </li>
        <li class="nav-item">
          <!-- <a class="nav-link" data-toggle="tab" href="#orders">Đơn hàng</a> -->
          <a href="<?php Common::getPath() ?>src/view/system/orders.php" class="nav-link">
            Đơn hàng
          </a>
        </li>
        <li class="nav-item">
          <!-- <a class="nav-link" data-toggle="tab" href="#customers">Khách hàng</a> -->
          <a href="<?php Common::getPath() ?>src/view/system/customers.php" class="nav-link">
            Khách hàng
          </a>
        </li>
      </ul>
    </div>  
    </div>     
           <!--  <div class=" col-md-12 tab-content mt-3 m-0 w-100 p-0">
              <div class="tab-pane  active " id="products">
                <?php //require_once ('./products.php'); ?>
              </div>
              <div class="tab-pane  fade" id="orders">
                <?php //require_once ('./orders.php'); ?>
              </div>
              <div class="tab-pane  fade" id="customers">
                <?php //require_once ('./customers.php'); ?>
              </div>
            </div> -->
	    
	
</section>
<?php require_once ($root.'/common/footer.php'); ?>

<script>
    $(document).ready(function () {
        set_title("Xuất dữ liệu hệ thống");
    });

    // const source = new EventSource('http://localhost/online/src/controller/webhook/WebhookController.php');
    // source.addEventListener('message', (e) => {
    //   console.log(e.data);
    // });

    // source.addEventListener('open', (e) => {
    //   // Connection was opened.
    // });

    // source.addEventListener('error', (e) => {
    //   if (e.readyState == EventSource.CLOSED) {
    //     // Connection was closed.
    //   }
    // });

    
</script>