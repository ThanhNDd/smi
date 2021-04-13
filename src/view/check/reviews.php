<?php
require_once("../../common/common.php");
Common::authen();
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/x-icon" href="<?php Common::getPath() ?>dist/img/icon.png"/>
    <title>Kiểm hàng</title>
    <?php require_once('../../common/css.php'); ?>
    <?php require_once('../../common/js.php'); ?>
</head>
<?php require_once('../../common/header.php'); ?>
<?php require_once('../../common/menu.php'); ?>
<section class="content">
    <input type="hidden" value="<?php echo $_GET["seq"]; ?>" id="check_id">
    <div class="row col-12" style="display: inline-block;">
        <section class="ml-1" style="display: inline-block;float: left;padding-top: 1.25rem;">
          <button class="btn btn-secondary btn-flat" id="back">
            <i class="fas fa-chevron-circle-left"></i> Quay lại
          </button>
        </section>
    </div>
<!--    <div class="row mt-2 mb-2">-->
<!--        <div class="col-md-4">-->
<!--            <input class="form-control" id="productId" type="text" autofocus="autofocus" style="border-color: #28a745"-->
<!--                   autocomplete="off">-->
<!--        </div>-->
<!--        <span class="text-secondary hidden saving"><i class="fa fa-spinner fa-spin"></i> Đang lưu ...</span>-->
<!--        <span class="text-success hidden saved_success"><i class="fa fa-check-circle"></i> Lưu thành công</span>-->
<!--    </div>-->
    <div class="row">
        <div class="col-md-9">
            <div class="card card-outline card-danger">
                <div class="card-header">
                    <h3 class="card-title">Danh sách sản phẩm</h3>
                </div>
                <div class="card-body" style="min-height: 615px;">
                    <table class="table table-hover" id="tableProd">
                        <thead>
                        <tr>
                            <th class="w40">Hình ảnh</th>
                            <th class="w100">Tên sản phẩm</th>
                            <th class="w100">Màu</th>
                            <th class="w100">Size</th>
                            <th class="w50">SKU</th>
                            <th class="w70">Giá nhập</th>
                            <th class="w30">SL</th>
                            <th class="w70">Tổng</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <div class="col-md-3">
            <div class="card card-outline card-warning">
                <div class="card-header">
                    <h3 class="card-title">Tổng số</h3>
                </div>
                <div class="card-body" style="min-height: 615px;">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <td class="right" style="vertical-align: middle;">Tổng số sản phẩm</td>
                            <td class="right"><h1 id="totalQty" style="color: red;">0</h1></td>
                        </tr>
                        <tr>
                          <td class="right" style="vertical-align: middle;">Tổng tiền</td>
                          <td class="right"><h3 id="totalMoney" style="color: red;">0</h3></td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <button type="button" class="btn btn-success form-control" id="checking_finish">
                          <i class="fas fa-check-circle"></i> Hoàn thành
                        </button>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</section>
<div class="iframeArea hidden">
</div>
<?php require_once('../../common/footer.php'); ?>
<script type="text/javascript">

    var table;
    let total_products = 0;
    let skus = [];
    let norow = 0;
    $(document).ready(function () {
        set_title("Kiểm hàng");

        let id = "<?php echo $_GET["id"]; ?>";
        let seq = "<?php echo $_GET["seq"]; ?>";
        reviews_check();

        $("#review_check").click(function () {
            let url = window.location.href;
            url += "&reviews";
            window.location.href = url;
        });

        $("#back").click(function () {
            window.location.href = "<?php Common::getPath() ?>src/view/check/processCheck.php?id="+id+"&seq="+seq;
        });

        $("#checking_finish").click(function () {
            let length = table.data().length;
            if(length === 0) {
                Swal.fire({
                    type: 'error',
                    title: 'Đã xảy ra lỗi',
                    text: "Chưa có sản phẩm nào được kiểm"
                });
                return;
            }
            Swal.fire({
                title: 'Xác nhận',
                text: "Hành động này sẽ cập nhật tất cả sản phẩm có trên hệ thống theo số lượng mới. Những sản phẩm không có trong danh sách sẽ được cập nhật số lượng là 0",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ok'
            }).then((result) => {
                if (result.value) {
                    checking_finish();
                }
            });

        });
    });

    function reviews_check() {
        table = $('#tableProd').DataTable({
            'ajax': {
                "type": "POST",
                "url": '<?php Common::getPath() ?>src/controller/Check/CheckController.php',
                "data": function (d) {
                    d.method = 'reviews_check'
                }
            },
            initComplete: function() {
                $('#totalQty').text( this.api().data().length );
                // let length = this.api().data().length;
                calculate_total();
            },
            ordering: false,
            select: "single",
            deferRender: true,
            rowId: 'extn',
            rowsGroup : [0,1,2],
            "columns": [
                {
                    "data": format_image,
                    "orderable": false,
                    width: "40px"
                },
                {
                    "data": "name",
                    "orderable": false,
                    width: "40px"
                },
                {
                    "data": "color",
                    "orderable": false,
                    width: "150px"
                },
                {
                    "data": "size",
                    "orderable": false,
                    width: "350px"
                },
                {
                    "data": "sku",
                    "orderable": false,
                    width: "50px"
                },
                {
                    "data": "price",
                    "orderable": false,
                    width: "50px"
                },
                {
                    "data": format_quantity,
                    "orderable": false,
                    width: "50px"
                },
                {
                    "data": "total",
                    "orderable": false,
                    width: "50px"
                }
            ],
            "lengthMenu": [[50, 100, -1], [50, 100, "All"]]
        });

        $('#tableProd tbody').on('click change', '.quantity', function () {
            let quantity = $(this).val();
            let tr = $(this).closest('tr');
            let row = table.row(tr);
            let price = Number(replaceComma(row.data().price));

            // console.log(row.data());
            row.data().quantity = quantity;
            row.data().total = formatNumber(price * quantity);
            table.row(tr).data(row.data()).draw();

            // let length = table.data().length;
            // console.log(length);
            calculate_total();
        });

    }

    function calculate_total() {
        let total_money = 0;
        let length_data = table.data().length;
        for(let i =0; i<length_data; i++) {
            let d = table.data()[i];
            total_money += Number(replaceComma(d.total));
        }
        $("#totalMoney").text(formatNumber(total_money));
    }

    function format_quantity(data) {
        let quantity = data.quantity;
        return "<input type='number' class='form-control quantity' value='"+quantity+"' min='0'>";
    }

    function format_image(data) {
        if (data.image) {
            let avatar = data.image;
            return "<a href='" + avatar + "' target='_blank' data-img='" + avatar + "' data-toggle=\"popover-hover\">" +
                "<img src='" + avatar + "' width='40px' class=\"img-circle img-fluid\" onerror='this.onerror=null;this.src=\"<?php Common::image_error()?>\"'></a>";
        } else {
            return '<span style="width: 40px;height: 40px;display: inline-block;background: #c5c5c563;border-radius: 50%;"><i class="fas fa-user" style="font-size: 25px;margin-top: 6px;margin-left: 10px;color: #b1b1b18a;"></i></span>';
        }
    }

    function checking_finish() {
        let seq = "<?php echo $_GET['seq']; ?>";

        let data = [];
        let length_data = table.data().length;
        for(let i =0; i<length_data; i++) {
            let d = table.data()[i];
            let json = {};
            json["sku"] = d.sku;
            json["qty"] = d.quantity;
            data.push(json);
        }
        $.ajax({
            url: '<?php Common::getPath() ?>src/controller/Check/CheckController.php',
            type: "POST",
            dataType: "json",
            data: {
                method: "checking_finish",
                seq: seq,
                data: JSON.stringify(data)
            },
            success: function (response) {
                console.log(JSON.stringify(response));
                Swal.fire({
                    type: 'success',
                    title: 'Hoàn thành',
                    text: "Đã hoàn thành kiểm hàng lần thứ #" + seq
                }).then((result) => {
                    if (result.value) {
                        window.location.href = "<?php Common::getPath() ?>src/view/check/index.php";
                    }
                });
            },
            error: function (data, errorThrown) {
                console.log(data.responseText);
                console.log(errorThrown);
                Swal.fire({
                    type: 'error',
                    title: 'Đã xảy ra lỗi',
                    text: "Vui lòng liên hệ quản trị hệ thống để khắc phục"
                })
            }
        });
    }

</script>
</body>
</html>
