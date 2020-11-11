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
    </div>
    <div class="row">
        <div class="col-md-9">
            <div class="card card-outline card-danger">
                <div class="card-header">
                    <h3 class="card-title">Danh sách sản phẩm</h3>
                </div>
                <div class="card-body" style="min-height: 615px;">
                    <input type="hidden" id="noRow" value="0">
                    <table class="table table-bordered table-head-fixed" id="tableProd"
                           style="max-height: 575px !important;overflow: auto;display: block;">
                        <thead>
                        <tr>
                            <th class="w10">#</th>
                            <th class="w70">ID</th>
                            <th class="w100">Hành động</th>
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
                        <button type="button" class="btn btn-success form-control" id="checking_finish"
                                title="Cập nhật">
                            <i class="far fa-check-circle"></i> Hoàn thành
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
    $(document).ready(function () {
        set_title("Kiểm hàng");
        input_product();


        //let seq = "<?php //echo $_GET["seq"]; ?>//";
        //if (seq != "") {
        //    find_by_id(Number(seq));
        //    get_status(Number(seq));
        //}
        //
        //$("#checking_finish").click(function () {
        //    checking_finish();
        //});
        // end document ready
    });

    let total_products = 0;
    let skus = [];
    let norow = 0;
    function input_product() {
        $("#productId").change(function () {
            let sku = $(this).val();
            skus.push(sku);
            total_products++;
            $("#totalQty").text(total_products);
            // find_product(sku);
            $(this).val("");
            if(skus.length === 10) {
                console.log("save temp sku");
                let sku = skus;
                save_temp_sku(sku);
                skus = [];
            }
            norow++;
            append_new_data_in_table_list(norow, sku);
            // setTimeout(function () {
            //     if(skus.length > 0) {
            //         let sku = skus;
            //         save_temp_sku(sku);
            //         skus = [];
            //     }
            // },300000); //5 minute
        });
    }
    function save_temp_sku(sku) {
        $.ajax({
            dataType: 'TEXT',
            url: '<?php Common::getPath() ?>src/controller/Check/CheckController.php',
            data: {
                method: "save_check_tmp",
                skus: sku
            },
            type: 'POST',
            success: function (response) {
                console.log(response);
                toastr.success("lưu thành công");
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
        // let noRow = number_row();
        $("#tableProd tbody").prepend('<tr id="product-' + norow + '">'
            + '<td>' + norow + '</td>'
            + '<td>' + sku + '</td>'
            + '<td><a href="javascript:void(0)" onclick="del_sku(sku)"><i class="fa fa-trash text-danger"></i></a></td>'
            + '</tr>');
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
        let product_checked = $("#totalQty").text();
        let money_checked = replaceComma($("#totalMoney").text());
        $.ajax({
            url: '<?php Common::getPath() ?>src/controller/Check/CheckController.php',
            type: "POST",
            dataType: "json",
            data: {
                method: "checking_finish",
                id: id,
                product_checked: product_checked,
                money_checked: money_checked
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
                        let noRow = $("#noRow").val();
                        noRow = Number(noRow);
                        noRow++;
                        $("#noRow").val(noRow);
                        $("#tableProd tbody").prepend('<tr id="product-' + noRow + '">'
                            + '<td>' + noRow + '</td>'
                            + '<td class="hidden"><input type="hidden" name="prodId" id="prodId_' + noRow + '" class="form-control" value="' + res[i].product_id + '"></td>'
                            + '<td class="hidden"><input type="hidden" name="variantId" id="variantId_' + noRow + '" class="form-control" value="' + res[i].variation_id + '"></td>'
                            + '<td class="hidden"><input type="hidden" name="sku" id="sku_' + noRow + '" class="form-control" value="' + res[i].sku + '"></td>'
                            + '<td>' + res[i].sku + '</td>'
                            + '<td><span class="product-name" id="name_' + noRow + '">' + res[i].name + '</span></td>'
                            + '<td><span class="size" id="size_' + noRow + '">' + res[i].size + '</span></td>'
                            + '<td><span class="color" id="color_' + noRow + '">' + res[i].color + '</span></td>'
                            + '<td><span class="price" id="price_' + noRow + '">' + res[i].price + '</span><span> đ</span></td>'
                            + '<td><input type="number" name="qty" id="qty_' + noRow + '" class="form-control" min="1" value="' + res[i].quantity + '"  onchange="onchange_qty(this,' + seq + ',' + res[i].sku  + ');"></td>'
                            + '<td><button type="button" id="delete_product_' + noRow + '" class="btn btn-danger" onclick="del_prod(' + seq + ',' + res[i].sku  + ')"><i class="fas fa-trash-alt"></i> Xóa</button></td>'
                            + '</tr>');
                    }
                    calculateTotal();
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



    function del_prod(seq,sku) {
        $.ajax({
            dataType: 'json',
            url: '<?php Common::getPath() ?>src/controller/Check/CheckController.php',
            data: {
                method: "delete_product",
                seq: seq,
                sku: sku
            },
            type: 'POST',
            success: function () {
                toastr.success("xóa sản phẩm #"+sku+" thành công");
                let seq = "<?php echo $_GET["seq"]; ?>";
                find_by_id(seq);
            },
            error: function (data, errorThrown) {
                console.log(data.responseText);
                console.log(errorThrown);
                Swal.fire({
                    type: 'error',
                    title: 'Đã xảy ra lỗi',
                    text: "Vui lòng liên hệ quản trị hệ thống để khắc phục"
                });
            }
        });
    }

    //function save(product) {
    //    console.log(JSON.stringify(product));
    //    $.ajax({
    //        dataType: 'json',
    //        url: '<?php //Common::getPath() ?>//src/controller/Check/CheckController.php',
    //        data: {
    //            method: "save_check_detail",
    //            data: JSON.stringify(product)
    //        },
    //        type: 'POST',
    //        success: function () {
    //            console.log("save success");
    //        },
    //        error: function (data, errorThrown) {
    //            console.log(data.responseText);
    //            console.log(errorThrown);
    //            Swal.fire({
    //                type: 'error',
    //                title: 'Đã xảy ra lỗi',
    //                text: "Vui lòng liên hệ quản trị hệ thống để khắc phục"
    //            }).then((result) => {
    //                if (result.value) {
    //
    //                }
    //            });
    //        }
    //    });
    //}



    //function save_result_check() {
    //    let $total_qty = replaceComma($("#totalQty").text());
    //    let $total_money = replaceComma($("#totalMoney").text());
    //    let data = {};
    //    data["total_qty"] = $total_qty;
    //    data["total_money"] = $total_money;
    //    $.ajax({
    //        dataType: 'json',
    //        url: '<?php //Common::getPath() ?>//src/controller/Check/CheckController.php',
    //        data: {
    //            method: "save_result_check",
    //            data: JSON.stringify(data)
    //        },
    //        type: 'POST',
    //        success: function () {
    //            toastr.success('Kết quả kiểm hàng đã được lưu thành công.');
    //        },
    //        error: function (data, errorThrown) {
    //            console.log(data.responseText);
    //            console.log(errorThrown);
    //            Swal.fire({
    //                type: 'error',
    //                title: 'Đã xảy ra lỗi',
    //                text: "Vui lòng liên hệ quản trị hệ thống để khắc phục"
    //            }).then((result) => {
    //                if (result.value) {
    //
    //                }
    //            });
    //        }
    //    });
    //}

    // function formatNumber(num) {
    //     return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    // }
    //
    // function replaceComma(value) {
    //     value = value.trim();
    //     return value.replace(/,/g, '');
    // }
</script>
</body>
</html>
