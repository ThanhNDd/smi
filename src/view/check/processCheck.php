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
            <a class="btn btn-secondary btn-flat" href="<?php Common::getPath() ?>src/view/check/index.php">
                <i class="fas fa-chevron-circle-left"></i> Quay lại
            </a>
        </section>
    </div>
    <div class="row mt-2 mb-2">
        <div class="col-md-4">
            <input class="form-control" id="productId" type="text" autofocus="autofocus" style="border-color: #28a745"
                   autocomplete="off">
        </div>
        <span class="text-secondary hidden saving"><i class="fa fa-spinner fa-spin"></i> Đang lưu ...</span>
        <span class="text-success hidden saved_success"><i class="fa fa-check-circle"></i> Lưu thành công</span>
    </div>
    <div class="row">
        <div class="col-md-9">
            <div class="card card-outline card-danger">
                <div class="card-header">
                    <h3 class="card-title">Danh sách sản phẩm</h3>
                </div>
                <div class="card-body" style="min-height: 615px;">
                    <input type="hidden" id="noRow" value="0">
                    <table class="table table-striped" id="tableProd"
                           style="max-height: 575px !important;overflow: auto;display: block;width: 100%">
                        <thead>
                        <tr>
                            <th class="w10">#</th>
                            <th class="w70">ID</th>
<!--                            <th class="w100">Hành động</th>-->
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
                            <td class="right">Tổng số sản phẩm</td>
                            <td class="right"><h1 id="totalQty" style="color: red;">0</h1></td>
                        </tr>
<!--                        <tr>-->
<!--                            <td class="right w110">Tổng tiền</td>-->
<!--                            <td class="right">-->
<!--                                <h2 id="totalMoney" style="color: red;">0-->
<!--                                    <small> đ</small>-->
<!--                                </h2>-->
<!--                            </td>-->
<!--                        </tr>-->
                        </tbody>
                    </table>
                    <div class="row">
                        <button type="button" class="btn btn-success form-control" id="review_check"
                                title="Cập nhật">
                            Tiếp theo <i class="fas fa-chevron-circle-right"></i>
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

        table = $('#tableProd').DataTable({
            order: [[0, 'desc']]
        });

        let seq = "<?php echo $_GET["seq"]; ?>";
        let url = window.location.href;
        find_by_id(Number(seq));

        input_product();

        $("#review_check").click(function () {
            window.location.href = "<?php Common::getPath() ?>src/view/check/reviews.php?id=8&seq=2";
        });

    });


    function input_product() {
        $("#productId").change(function () {
            let sku = $(this).val();
            skus.push(sku);
            total_products++;
            $("#totalQty").text(total_products);
            $(this).val("").focus();
            save_temp_sku(sku);
            norow++;
            append_new_data_in_table_list(norow, sku);
        });
    }
    function save_temp_sku(sku) {
        $.ajax({
            dataType: 'TEXT',
            url: '<?php Common::getPath() ?>src/controller/Check/CheckController.php',
            data: {
                method: "save_check_tmp",
                sku: sku
            },
            type: 'POST',
            success: function (response) {
                console.log(response);
                // toastr.success("lưu thành công");
                $(".saving").addClass('hidden');
                $(".saved_success").removeClass('hidden');
                setTimeout(function () {
                    $(".saved_success").addClass('hidden');
                },5000);
            },
            error: function (data, errorThrown) {
                console.log(data.responseText);
                console.log(errorThrown);
                Swal.fire({
                    type: 'error',
                    title: 'Đã xảy ra lỗi',
                    text: "Vui lòng liên hệ quản trị hệ thống để khắc phục"
                }).then((result) => {
                    if (result.value) {
                        // enabled_input_product();
                    }
                });
            }
        });
    }

    function find_product(sku) {
        disabled_input_product();
        $.ajax({
            dataType: 'TEXT',
            url: '<?php Common::getPath() ?>src/controller/Check/CheckController.php',
            data: {
                method: "save_check_tmp",
                sku: sku
            },
            type: 'POST',
            success: function (response) {
                console.log(response);
                console.log("save success. ID = "+response.id);
                append_new_data_in_table_list(response.id, sku);
                enabled_input_product();
            },
            error: function (data, errorThrown) {
                console.log(data.responseText);
                console.log(errorThrown);
                Swal.fire({
                    type: 'error',
                    title: 'Đã xảy ra lỗi',
                    text: "Vui lòng liên hệ quản trị hệ thống để khắc phục"
                }).then((result) => {
                    if (result.value) {
                        enabled_input_product();
                    }
                });
            }
        });
    }
    function append_new_data_in_table_list(norow, sku) {
        table.row.add( [
            norow,
            sku
        ] ).draw( false );
    }

    function number_row() {
        let noRow = $("#noRow").val();
        noRow = Number(noRow);
        noRow++;
        $("#noRow").val(noRow);
        return noRow;
    }
    function disabled_input_product() {
        $("#productId").prop("disabled", true);
    }
    function enabled_input_product() {
        $("#productId").prop("disabled", "");
    }

    function checking_finish() {
        let seq = "<?php echo $_GET['seq']; ?>";
        let id = "<?php echo $_GET['id']; ?>";
        $.ajax({
            url: '<?php Common::getPath() ?>src/controller/Check/CheckController.php',
            type: "POST",
            dataType: "json",
            data: {
                method: "checking_finish",
                seq: seq
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

    function validateProdId(prodId) {
        let count = 0;
        $.each($("#tableProd tbody").find("input[name=sku]"), function (k, v) {
            if (v["value"] === prodId) {
                count++;
                let noId = v["id"];
                noId = noId.split("_")[1];
                let qty = $("[id=qty_" + noId + "]").val();
                qty = Number(qty);
                qty++;
                $("[id=qty_" + noId + "]").val(qty);
                calculateTotal();
                let product = {};
                product["sku"] = $("[id=sku_" + noId + "]").val();
                save(product);
                return;
            }
        });
        if (count == 0) {
            if (typeof find_product === 'function') {
                find_product(prodId, 1);
            }
            if (typeof calculateTotal === 'function') {
                calculateTotal();
            }
        }
    }

    function find_by_id(seq) {
        $.ajax({
            url: '<?php Common::getPath() ?>src/controller/Check/CheckController.php',
            type: "POST",
            dataType: "json",
            data: {
                method: "find_detail",
                seq: seq
            },
            success: function (response) {
                $("#tableProd tbody").html("");
                $("#noRow").val(0);
                console.log(JSON.stringify(response));
                let res = response.data;
                if (res.length > 0) {
                    for (let i = 0; i < res.length; i++) {
                        total_products++;
                        $("#totalQty").text(total_products);
                        norow++;
                        table.row.add( [
                            norow,
                            res[i].sku
                        ] ).draw( false );
                    }
                }
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
