<?php require_once("../../common/common.php") ?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo __PATH__?>dist/img/icon.png"/>
  <title>Bán hàng</title>
  	<?php require_once ('../../common/css.php'); ?>
  	<?php require_once ('../../common/js.php'); ?>
        
        <style type="text/css">
            @page bigger { sheet-size: 58mm 100mm; }
            #barcode {font-weight: normal; font-style: normal; line-height:normal; font-family: sans-serif; font-size: 12pt}
            .center {
                text-align: center;
            }
            .left {
                text-align: left;
                padding-left: 3px;
            }
            .right {
                text-align: right;
                padding-right: 3px;
            }
            p, h3 {
                margin: 5px;
            }
            .container, table {
                width: 300px;
                font-size: 13px;
                font-family: sans-serif;
            }
            .custom-font {
                font-size: 13px !important;
                font-family: sans-serif !important;
            }
            table {
                width: 100%;
                border-collapse: collapse;
            }
            td {
                border: 1px solid;
                padding: 4px 0;
            }
            table thead {
                font-weight: bold;
            }
            @media print {
                body {transform: scale(.7);}
                table {page-break-inside: avoid;}
            }
        </style>
    </head>
    <body>
        <div class="container p-0 float-left">
            <div class="header row">
                <div class="center col-12 p-0 m-0">
                    <h4>SHOP MẸ ỈN</h4>
                    <p>Thời trang trẻ em cao cấp</p>
                    <span>* * * * * * * * * * * *</span>
                    <p style="margin: 5px 0;">Đ/c: 227 Phố Huyện - Thị Trấn Quốc Oai - Hà Nội</p>
                    <p>Hotline: 0962.926.302</p>
                    <p>Website: www.shopmein.net</p>
                    <p>Facebook: Shop Mẹ Ỉn</p>
                    <span>* * * * * * * * * * * *</span>
                    <h4>HÓA ĐƠN THANH TOÁN</h4>
                    <barcode code="0000000000168" type="C128A" class="barcode" />
                    <p>0000000000168</p>
                    <span>
                        <span class="float-left">Ngày tháng:</span>
                        <span class="float-right mr-2">26/12/2019 - 16:26:08</span>
                    </span>
                </div>
            </div>
            <div class="body center">
                <table class="center">
                    <thead>
                        <tr>
                            <td class="center" style="width: 30px;">Stt</td>
                            <td colspan="4" class="left">Tên sản phẩm</td>
                        </tr>
                        <tr>
                            <td class="left"></td>
                            <td class="center" style="width: 30px;">SL</td>
                            <td class="center" style="width: 65px;">Giá</td>
                            <td class="center" style="width: 40px;">%</td>
                            <td class="center" style="width: 65px;">Thành tiền</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="center">1</td>
                            <td colspan="4" class="left">Áo Khoác dễ thương</td>
                        </tr>
                        <tr>
                            <td class="left"></td>
                            <td class="center">1</td>
                            <td class="right">250,000</td>
                            <td class="right"></td>
                            <td class="right">250,000</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="right">Tổng tiền</td>
                            <td class="right">250,000</td>
                        </tr>
                        <!-- <tr>
                            <td colspan="4" class="right">Giảm trên tổng đơn</td>
                            <td class="right">0%</td>
                        </tr> -->
                        <tr>
                            <td colspan="4" class="right">Tổng Giảm trừ</td>
                            <td class="right">0</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="right">Tổng thanh toán</td>
                            <td class="right">250,000</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="right">Khách thanh toán</td>
                            <td class="right">250,000</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="right">Trả lại</td>
                            <td class="right">0</td>
                        </tr>
                    </tfoot>
                </table>
            <p class="center">Xin cám ơn Quý khách</p>
            <p class="center">Hẹn gặp lại</p>
        </div>
    </div>
</body>
</html>