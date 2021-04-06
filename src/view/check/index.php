<?php
  require_once("../../common/common.php");
  Common::authen();
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Kiểm hàng</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?php Common::getPath() ?>dist/img/icon.png"/>
    <?php require_once('../../common/css.php'); ?>
    <?php require_once('../../common/js.php'); ?>
    <style>

        td.details-control {
            text-align: center;
            color: forestgreen;
            cursor: pointer;
        }

        tr.shown td.details-control {
            text-align: center;
            color: red;
        }

        div#example_wrapper {
            margin-top: 10px;
        }

        div#example_filter label {
            width: 100%;
            float: left;
        }

        table.dataTable.no-footer {
            border-bottom: none;
        }

        .modal-dialog.modal-xl {
            max-width: 90% !important;
        }

        .header-column {
            position: fixed;
            z-index: 999;
            background: #fff;
            top: 98px;
            height: 30px;
            margin: 0 -3px;
        }

        .product-area {
            position: relative;
            top: 20px;
        }

        #thumbnail:hover {
            /*width: 100% !important;*/
            /*transform: scale(1.2);
                -webkit-transform: scale(1.2);
                -moz-transform: scale(1.2);
                -o-transform: scale(1.2);
                -ms-transform: scale(1.2);
            cursor: pointer; */
        }
    </style>
</head>
<?php require_once('../../common/header.php'); ?>
<?php require_once('../../common/menu.php'); ?>
<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="row col-12" style="display: inline-block;">
                    <p class="float-left pt-4 ml-4" style="display: inline-block;" id="total_product_display"></p>
                    <input type="hidden" id="total_products" value="">
                    <input type="hidden" id="total_money" value="">
                    <section style="display: inline-block;float: right;padding-top: 1.25rem;">
                        <button type="button" class="btn btn-success btn-flat" id="create_new_checking">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i> Tạo mới
                        </button>
                    </section>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example" class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th></th>
                            <th>Ngày bắt đầu</th>
                            <th>Ngày kết thúc</th>
                            <th>Tổng số SP</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
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
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
<?php //include 'createProducts.php'; ?>
</div>
<div class="iframeArea hidden"></div>
<?php require_once ('../../common/footer.php'); ?>
<script>
    $(document).ready(function () {
        set_title("Danh sách kiểm hàng");
        count_all_products();
        generate_datatable();

        $(".print-barcode").on("click", function () {
            let data = [];
            $.each($("#example tbody td input[type='checkbox']:checked"), function () {
                let id = $(this).attr("id");
                if (id != "selectall") {
                    data.push($(this).attr("id"));
                }
            });
            if (data.length > 0) {
                printBarcode(data);
            }
        });
        $(".clearAll").on("click", function () {
            clearAll();
        });

        $("#create_new_checking").click(function(){
            validate_new_checking();
        });
    });

    function validate_new_checking() {
        $.ajax({
            url: '<?php Common::getPath()?>src/controller/Check/CheckController.php',
            type: "POST",
            dataType: "json",
            data: {
                method: "check_exists_checking"
            },
            success: function (res) {
                console.log(res);
                if(res > 0) {
                    Swal.fire({
                        type: 'error',
                        title: 'Đã xảy ra lỗi',
                        text: "Hệ thống đang tồn tại 1 lần kiểm hàng chưa hoàn thành. Bạn có thể tiếp tục hoặc hủy bỏ để tạo mới!!"
                    });
                } else {
                    create_new_check();
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

    function create_new_check() {
        let total_products = $("#total_products").val();
        let total_money = replaceComma($("#total_money").val());
        $.ajax({
            url: '<?php Common::getPath() ?>src/controller/Check/CheckController.php',
            type: "POST",
            dataType: "json",
            data: {
                method: "create_new_check",
                total_products: total_products,
                total_money: total_money
            },
            success: function (res) {
                // console.log(res.checkId);
                window.location.href = "<?php Common::getPath() ?>src/view/check/processCheck.php?id="+ res.checkId+"&seq="+res.seq;
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

    function clearAll() {
        $.each($("#example tbody td input[type='checkbox']:checked"), function () {
            $(this).prop("checked", false);
        });
        $(".number-checked").text(0);
    }

    function countAllChecked() {
        let count = 0;
        $.each($("#example tbody td input[type='checkbox']:checked"), function () {
            let id = $(this).attr("id");
            if (id != "selectall") {
                count++;
            }
        });
        $(".number-checked").text(count);
    }

    function printBarcode(data) {
        $(".iframeArea").html("");
        $.ajax({
            url: '<?php Common::getPath() ?>src/controller/product/ProductController.php',
            type: "POST",
            dataType: "json",
            data: {
                method: "print_barcode",
                data: JSON.stringify(data)
            },
            success: function (res) {
                let filename = res.fileName;
                $(".iframeArea").html("");
                if (typeof filename !== "underfined" && filename !== "") {
                    $(".iframeArea").html('<iframe src="<?php Common::getPath() ?>src/controller/product/pdf/' + filename + '" id="barcodeContent" frameborder="0" style="border:0;" width="300" height="300"></iframe>');
                    window.open("<?php Common::getPath() ?>src/controller/product/pdf/" + filename, "_blank");
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

    function generate_datatable() {
        let table = $('#example').DataTable({
            "ajax": '<?php Common::getPath() ?>src/controller/Check/CheckController.php?method=findall',
            select: "single",
            // deferRender: true,
            // rowId: 'extn',
            "columns": [
                // {
                //     "className": 'details-control',
                //     "orderable": false,
                //     "data": null,
                //     "defaultContent": '',
                //     "render": function () {
                //         return '<i class="fa fa-plus-square" aria-hidden="true"></i>';
                //     },
                //     width: "5px"
                // },
                {
                    "data": "seq",
                    width: "5px"
                },
                {
                    "data": "id",
                    "className": 'hidden',
                    width: "5px"
                },
                {
                    "data": "start_date",
                    width: "150px"
                },
                {
                    "data": "finished_date",
                    width: "150px"
                },
                {
                    "data": format_total_products,
                    width: "150px"
                },
                {
                    "data": format_total_money,
                    width: "150px"
                },
                {
                    "data": format_status,
                    width: "50px"
                },
                {
                    "data": format_action,
                    width: "50px"
                }
            ],
            "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]]
        });

        // Event click delete product
        $('#example tbody').on('click', '#cancel_checking', function () {
            let tr = $(this).closest('tr');
            let row = table.row(tr);
            let id = row.data().id;

            Swal.fire({
                title: 'Bạn có chắc chắn muốn hủy bỏ lần kiểm hàng này?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ok'
            }).then((result) => {
                if (result.value) {
                    show_loading();
                    $.ajax({
                        url: '<?php Common::getPath() ?>src/controller/Check/CheckController.php',
                        type: "POST",
                        dataType: "json",
                        data: {
                            method: "cancel_checking",
                            data: id
                        },
                        success: function (res) {
                            console.log(res);
                            toastr.success('Cập nhật thành công!');
                            window.location.reload();
                        },
                        error: function (data, errorThrown) {
                            console.log(data.responseText);
                            console.log(errorThrown);
                            Swal.fire({
                                type: 'error',
                                title: 'Đã xảy ra lỗi',
                                text: "Vui lòng liên hệ quản trị hệ thống để khắc phục"
                            })
                            hide_loading();
                        }
                    });
                }
            });
        });

    }

    function format_total_money(data) {
        // let money_checked = data.money_checked;
        let total_money = data.total_money;
        // money_checked = formatNumber(money_checked);
        // total_money = formatNumber(total_money);
        return total_money +" <sup>đ</sup>";
    }

    function format_total_products(data) {
        let total_products = data.total_products;
        // let products_checked = data.products_checked;
        return total_products;
    }

    function format_status(data) {
        let status = Number(data.status);
        switch (status) {
            case 0:
                status = '<span class="badge badge-warning">Đang kiểm hàng</span>';
                break;
            case 1:
                status = '<span class="badge badge-success">Hoàn thành</span>';
                break;
            case 2:
                status =  '<span class="badge badge-danger">Đã hủy</span>';
                break;
            default:
                return '';
        }
        return status;
    }

    function count_all_products() {
        $.ajax({
            url: '<?php Common::getPath() ?>src/controller/Check/CheckController.php',
            type: "POST",
            dataType: "json",
            data: {
                method: "count_all_products"
            },
            success: function (res) {
                console.log(res);
                let data = res.total;
                $("#total_products").val(data[0]);
                $("#total_money").val(data[1]);
                let alert = '<div class="alert alert-info">' +
                                'Hiện có <strong>'+data[0]+'</strong> sản phẩm còn hàng trị giá <strong>'+data[1]+'</strong> <sup>đ</sup>' +
                            '</div>';
                $("#total_product_display").html(alert);
            },
            error: function (data, errorThrown) {
                console.log(data.responseText);
                console.log(errorThrown);
                $(".number_out_of_stock").text(0);
            }
        });
    }

    function format_action(data) {
        let status = Number(data.status);
        let seq = data.seq;
        let id = data.id;
        if(status == 0) {
            return '<a href="<?php Common::getPath() ?>src/view/check/processCheck.php?id='+id+'&seq='+seq+'" class="btn bg-gradient-info btn-sm continue_checking" title="Tiếp tục thực hiện kiểm hàng">' +
                '<i class="fas fa-undo"></i> Tiếp tục</a>&nbsp;'
                + '<button type="button" class="btn bg-gradient-danger btn-sm" id="cancel_checking" title="Hủy bỏ"><i class="fas fa-ban"></i> Hủy</button>';
        } else if(status == 1) {
            //return '<a href="<?php //Common::getPath() ?>//src/view/check/processCheck.php?id='+id+'&seq='+seq+'" class="btn bg-gradient-success btn-sm detail_checked" title="Chi tiết">' +
            //    '<i class="fas fa-info-circle"></i> Chi tiết</a>&nbsp;';
        }
        return '';
    }



    function format_discount_display(data) {
        let discount = data.discount;
        if (typeof discount == "undefined" || discount == 0) {
            discount = "";
        } else {
            if (discount < 100) {
                discount = discount + "%";
            } else {
                discount = formatNumber(discount);
            }
        }
        return discount;
    }

    function format_discount(data) {
        let discount = data.discount;
        if (typeof discount == "undefined" || discount == 0) {
            discount = "";
        } else {
            if (discount < 100) {
                discount = discount + "%";
            } else {
                discount = formatNumber(discount);
            }
        }
        let retail = data.retail;
        let profit = data.profit;
        let product_id = data.product_id;
        return '<input type="text" onchange="onchange_discount(this, \'' + profit + '\')" onblur="onchange_discount(this, \'' + profit + '\', \'' + retail + '\')" class="form-control col-md-6 float-left" value="' + discount + '"/>&nbsp;' +
            '<button type="button" class="btn bg-gradient-info btn-sm mt-1" onclick="update_discount(this, ' + product_id + ')" title="Lưu khuyến mãi"><i class="fas fa-save"></i></button>';
    }

    function onchange_discount(e, profit, retail) {
        $(e).removeClass("is-invalid");
        $("#update_discount").prop("disabled", true);
        let val = $(e).val();
        val = replaceComma(val);
        console.log(val);
        // let profit;
        if (val == "") {

        } else if (val.indexOf("%") == -1) {
            if (!isNaN(val) && val >= 0) {
                profit = replaceComma(profit);
                profit = profit - val;
                val = formatNumber(val);
                $(e).val(val);
                $("#update_discount").prop("disabled", "");
            } else {
                $(e).addClass("is-invalid");
                $("#update_discount").prop("disabled", true);
            }
        } else {
            val = replacePercent(val);
            profit = replaceComma(profit);
            retail = replaceComma(retail);
            profit = profit - retail * val / 100;
            $("#update_discount").prop("disabled", "");
        }
        $(e).parent().next("td").text(formatNumber(profit));
    }

    function update_discount(e, product_id) {
        let discount = $(e).parent().find("input").val();
        discount = replaceComma(discount);
        discount = replacePercent(discount);
        console.log(discount);
        console.log(product_id);
        if (discount == "undefined" || discount == "" || discount < 0) {
            toastr.error('Nhập chưa đúng!');
            return;
        }
        $.ajax({
            url: '<?php Common::getPath() ?>src/controller/product/ProductController.php',
            type: "POST",
            dataType: "json",
            data: {
                method: "update_discount",
                product_id: product_id,
                discount: discount
            },
            success: function (res) {
                console.log(res);
                toastr.success('Cập nhật thành công!');
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



    function check_stock(e, product_id) {
        $.ajax({
            url: '<?php Common::getPath() ?>src/controller/product/ProductController.php',
            type: "POST",
            dataType: "json",
            data: {
                method: "check_update_out_of_stock",
                product_id: product_id
            },
            success: function (res) {
                console.log(res);
                if(res.response === "in_stock") {
                    Swal.fire({
                        type: 'error',
                        title: 'Số lượng sản phẩm vẫn còn',
                        text: "Bạn vui lòng kiểm tra lại trước khi cập nhật hết hàng."
                    });
                    return;
                } else if(res.response === "success") {
                    Swal.fire({
                        title: 'Bạn chắc chắn muốn cập nhật hết hàng cho sản phẩm này?',
                        text: "",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        if (result.value) {
                            update_out_of_stock(e, product_id);
                        }
                    });
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

    function update_out_of_stock(e, product_id) {
        $.ajax({
            url: '<?php Common::getPath() ?>src/controller/product/ProductController.php',
            type: "POST",
            dataType: "json",
            data: {
                method: "update_stock",
                product_id: product_id,
                status: 1 // out of stock
            },
            success: function (res) {
                console.log(res);
                toastr.success('Cập nhật thành công!');
                $(e).parent().parent().hide(700);
                $(e).parent().parent().next().hide(700);
                count_out_of_stock();
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



    function format_intomoney(data) {
        let price = replaceComma(data.price);
        let fee = replaceComma(data.fee_transport);
        let into_money = Number(price) + Number(fee);
        if (!isNaN(into_money)) {
            return formatNumber(into_money);
        } else {
            return "";
        }
    }

    function format_name(data) {
        return "<a href='" + data.link + "' target='_blank'>" + data.name + "</a>";
    }

    function format_image(data) {
        return "<img src=" + data.image + " width='100px' id='thumbnail'>";
    }

    function format_variation(variations, isNew) {
        let table = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
        table += '<thead>' +
            '<tr>' +
            '<th class="center"><input type="checkbox" id="selectall" onclick="checkAll(this)"></th>' +
            '<th>Mã sản phẩm</th>' +
            '<th>Màu</th>' +
            '<th>Size</th>' +
            '<th>Số lượng</th>' +
            '<th>Hành động</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody>';
        for (let i = 0; i < variations.length; i++) {
            table += '<tr class="' + variations[i].sku + '">' +
                '<td class="center"><input type="checkbox" id="' + variations[i].sku + '" onclick="check(this)"></td>' +
                '<input type="hidden" class="product-id-' + variations[i].sku + '" value="' + variations[i].product_id + '">' +
                '<td>' + variations[i].sku + '</td>' +
                '<td>' + variations[i].color + '</td>' +
                '<td>' + variations[i].size + '</td>' +
                '<td id="qty">' + variations[i].quantity + '</td>' +
                '<td>' +
                '<button type="button" class="btn bg-gradient-info btn-sm edit_variation"><i class="fas fa-edit"></i> Sửa</button>&nbsp;' +
                //'<button type="button" class="btn bg-gradient-danger btn-sm delete_variation"><i class="fas fa-trash"></i> Xóa</button>' +
                '</td>' +
                '</tr>';
        }
        if (isNew === "isNew") {
            let new_sku = Number(variations[variations.length - 1].sku) < 10 ? "0" + variations[variations.length - 1].sku : Number(variations[variations.length - 1].sku) + 1;
            table += '<tr class="' + new_sku + '">' +
                '<td>' + new_sku + '</td>' +
                '<td><select class="select-color-' + new_sku + ' form-control w100" id="select_color_' + new_sku + '"><option value="-1"></option></select></td>' +
                '<td><select class="select-size-' + new_sku + ' form-control w100" id="select_size_' + new_sku + '"><option value="-1"></option></select></td>' +
                '<td><select class="select-qty-' + new_sku + ' form-control w100" id="select_qty_' + new_sku + '"><option value="-1"></option></select></td>' +
                '<td>' +
                '<button type="button" class="btn bg-gradient-primary btn-sm save_variation"><i class="fas fa-save"></i> Lưu</button>&nbsp;' +
                '</td>' +
                '<input type="hidden" class="product-id-' + new_sku + '" value="' + variations[variations.length - 1].product_id + '">' +
                '</tr>';
        }
        table += '</tbody>';
        table += '</table>';
        return table;
    }

    function check(e) {
        let isCheck = $(e).prop('checked');
        if (isCheck) {
            $(e).prop("checked", "checked");
        } else {
            $(e).prop("checked", "");
        }
        countAllChecked();
    }

    function checkAll(e) {
        let isCheck = $(e).prop('checked');
        if (isCheck) {
            $(e).parent().parent().parent().parent().find('td input:checkbox').prop("checked", "checked");
        } else {
            $(e).parent().parent().parent().parent().find('td input:checkbox').prop("checked", "");
        }
        countAllChecked();
    }

    // function formatNumber(num) {
    //     return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    // }

    // function replaceComma(value) {
    //     value = value.trim();
    //     return value.replace(/,/g, '');
    // }
    //
    // function replacePercent(value) {
    //     return value.replace(/%/g, '');
    // }

    function generate_select2(el, data, value) {
        $(el).select2({
            data: data
        });
        if (value !== "") {
            $(el).val(value).trigger('change');
        }
    }
</script>
</body>
</html>
