<?php
require_once("../../common/common.php");
Common::authen();
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Quản lý khách hàng</title>
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

        div#table_customer_filter label {
            width: 100%;
            float: left;
        }

        .card-body {
            padding: 0;
        }

        .table td, .table th {
            padding: 5px;
            border-top: none;
            margin: 0 !important;
        }

        /*input[type=text], input[type=number], .select2-container--bootstrap4 .select2-selection {*/
        /*    border-radius: 0 !important;*/
        /*    margin: 0 !important;*/
        /*}*/
        /*.dataTables_wrapper .dataTables_paginate .paginate_button:hover {*/
        /*  background: linear-gradient(to bottom, #ffffff 0%, #ffffff 100%) !important;*/
        /*  border: #ffffff !important;*/
        /*}*/
        .customer-inactive td, .customer-inactive a {
            color: slategray;
        }

        div#table_customer_wrapper {
            padding: 20px;
        }

        /*table.dataTable tbody th, table.dataTable tbody td {*/
        /*  padding: 3px 10px !important;*/
        /*}*/
        /*.dataTable td, .dataTable th {*/
        /*  font-size: 14px !important;*/
        /*}*/
        /*table.dataTable thead th, table.dataTable thead td {*/
        /*  padding: 5px 10px !important;*/
        /*}*/
        /*table.dataTable thead th, table.dataTable thead td {*/
        /*  border-bottom: 1px solid #1110 !important;*/
        /*}*/
        /*.dataTables_wrapper.no-footer .dataTables_scrollBody {*/
        /*  border-bottom: 1px solid #1110 !important;*/
        /*}*/
        /*.dataTables_filter {*/
        /*  display: none;*/
        /*}*/
    </style>
</head>
<?php require_once('../../common/header.php'); ?>
<?php require_once('../../common/menu.php'); ?>
<section class="content">
    <div class="card">
        <div class="card-body">
            <div class="row col-12" style="display: inline-block;">
                <section style="display: inline-block;float: right;padding-top: 1.25rem;padding-bottom: 1.25rem;">
                    <button type="button" class="btn btn-success btn-flat" id="btn_create_new_customer">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i> Tạo mới
                    </button>
                </section>
            </div>
            <table id="table_customer" class="table table-hover table-striped">
                <thead>
                <tr>
                    <th></th>
                    <th class="hidden"></th>
                    <th></th>
                    <th>Họ tên</th>
                    <th>Địa chỉ</th>
                    <th>Số điện thoại</th>
                    <th>Zalo</th>
                    <th>Ngày sinh</th>
                    <th>Email</th>
                    <th>Facebook</th>
                    <th>Số lần mua hàng</th>
                    <th>Ngày tạo</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?php include 'createCustomer.php'; ?>
<?php require_once('../../common/footer.php'); ?>
<script>
    $(document).ready(function () {
        set_title("Danh sách khách hàng");
        loadall();
        $('[data-toggle="tooltip"]').tooltip();
    });

    function loadall() {
        let table = $('#table_customer').DataTable({
            "ajax": '<?php Common::getPath() ?>src/controller/customer/CustomersController.php?method=findall',
            ordering: false,
            select: "single",
            deferRender: true,
            rowId: 'extn',
            "columns": [
                {
                    "data": format_action,
                    "orderable": false,
                    width: "50px"
                },
                {
                    "data": "id",
                    "orderable": false,
                    "class": 'hidden',
                    width: "40px"
                },
                {
                    "data": format_image,
                    "orderable": false,
                    width: "40px"
                },
                {
                    "data": "name",
                    "orderable": false,
                    width: "150px"
                },
                {
                    "data": "address",
                    "orderable": false,
                    width: "350px"
                },
                {
                    "data": "phone",
                    "orderable": false,
                    width: "50px"
                },
                {
                    "data": format_add_friend_zalo,
                    "orderable": false,
                    width: "50px"
                },
                {
                    "data": "birthday",
                    "orderable": false,
                    width: "50px"
                },
                {
                    "data": "email",
                    "orderable": false,
                    width: "150px"
                },
                {
                    "data": format_facebook,
                    "orderable": false,
                    width: "100px"
                },
                {
                    "data": "purchased",
                    width: "50px"
                },
                {
                    "data": "created_at",
                    "orderable": false,
                    width: "50px"
                }
            ],
            "lengthMenu": [[50, 100, -1], [50, 100, "All"]]
        });

        $('#table_customer tbody').on('click', '.edit_customer', function () {
            let tr = $(this).closest('tr');
            let row = table.row(tr);
            let customerId = row.data().id;
            edit_customer(customerId);
        });

        $('#table_customer tbody').on('click', '.active_customer', function () {
            let tr = $(this).closest('tr');
            let row = table.row(tr);
            let customerId = row.data().id;
            let active_status = row.data().active == 1 ? 0 : 1;
            active_customer(customerId, active_status, tr);
        });

        $('#table_customer tbody').on('click', '.add-zalo', function () {
            let tr = $(this).closest('tr');
            let row = table.row(tr);
            let customerId = row.data().id;
            let status = row.data().is_add_zalo == 1 ? 0 : 1;
            add_zalo(customerId, status);
        });
    }

    function format_action(data) {
        let btn = '<a href="javascript:void(0)" data-toggle="tooltip" title="Chỉnh sửa" class="edit_customer"><i class="text-info fas fa-edit"></i></a>&nbsp;' +
            '<a href="javascript:void(0)" data-toggle="tooltip" title="Khoá tài khoản" class="active_customer"><i class="text-danger fas fa-lock"></i></a>';
        if (data.active == 0) {
            btn = '<a href="javascript:void(0)" data-toggle="tooltip" title="Chỉnh sửa" class="edit_customer"><i class="text-info fas fa-edit"></i></a>&nbsp;' +
                '<a href="javascript:void(0)" data-toggle="tooltip" title="Mở khoá tài khoản" class="active_customer"><i class="text-danger fas fa-lock-open"></i></a>';
        }
        return btn;
    }

    function format_image(data) {
        if (data.avatar) {
            let avatar = '<?php Common::path_avatar(); ?>' + data.avatar;
            return "<a href='" + avatar + "' target='_blank' data-img='" + avatar + "' data-toggle=\"popover-hover\">" +
                "<img src='" + avatar + "' width='40px' class=\"img-circle img-fluid\" onerror='this.onerror=null;this.src=\"<?php Common::image_error()?>\"'></a>";
        } else {
            return "<img src='<?php Common::image_error()?>' width='40px' class=\"img-circle img-fluid\">";
        }
    }

    function format_add_friend_zalo(data) {
        let checked = data.is_add_zalo == 0 ? "" : 'checked';
        return "<div class=\"custom-control custom-switch\">" +
            "<input type=\"checkbox\" class=\"custom-control-input add-zalo\" id=\"add_zalo_"+data.id+"\" "+checked+">" +
            "<label class=\"custom-control-label\" for=\"add_zalo_"+data.id+"\"></label>" +
            "</div>";
    }

    function format_facebook(data) {
        if (data.facebook && data.link_fb) {
            return '<a href="' + data.link_fb + '" target="_blank">' + data.facebook + '</a>';
        }
        return '';
    }

    function active_customer(customerId, status) {
        if (customerId) {
            $.ajax({
                url: "<?php Common::getPath() ?>src/controller/customer/CustomersController.php",
                dataType: 'text',
                type: 'post',
                data: {
                    customerId: customerId,
                    method: 'active_customer',
                    status: status
                },
                success: function (res) {
                    console.log(res);
                    hide_loading();
                    if (res === 'success') {
                        toastr.success('Cập nhật thành công!!');
                        $('#table_customer').DataTable().ajax.reload();
                    } else {
                        toastr.error('Cập nhật không thành công!!!');
                    }
                }
            });
        } else {
            hide_loading();
            toastr.error('Đã xảy ra lỗi!!!');
        }
    }

    function add_zalo(customerId, status) {
        if (customerId) {
            $.ajax({
                url: "<?php Common::getPath() ?>src/controller/customer/CustomersController.php",
                dataType: 'text',
                type: 'post',
                data: {
                    customerId: customerId,
                    method: 'add_zalo',
                    status: status
                },
                success: function (res) {
                    console.log(res);
                    hide_loading();
                    if (res === 'success') {
                        toastr.success('Cập nhật thành công!!');
                        $('#table_customer').DataTable().ajax.reload();
                    } else {
                        toastr.error('Cập nhật không thành công!!!');
                    }
                }
            });
        } else {
            hide_loading();
            toastr.error('Đã xảy ra lỗi!!!');
        }
    }

    // function format_detail(variations, isNew) {
    //     let table = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
    //     table += '<thead>' +
    //         '<tr>' +
    //         '<th class="center"><input type="checkbox" id="selectall" onclick="checkAll(this)"></th>' +
    //         '<th>Mã sản phẩm</th>' +
    //         '<th>Màu</th>' +
    //         '<th>Size</th>' +
    //         '<th>Số lượng</th>' +
    //         '<th>Shopee</th>' +
    //         '<th>Lazada</th>' +
    //         '</tr>' +
    //         '</thead>' +
    //         '<tbody>';
    //     for (let i = 0; i < variations.length; i++) {
    //         let updated_qty = JSON.parse(variations[i].updated_qty);
    //         let shopee = updated_qty.shopee === 0 ? '' : 'checked';
    //         let lazada = updated_qty.lazada === 0 ? '' : 'checked';
    //         table += '<tr class="' + variations[i].sku + '">' +
    //             '<td class="center"><input type="checkbox" id="' + variations[i].sku + '" onclick="check(this)"></td>';
    //         table += '<input type="hidden" class="product-id-' + variations[i].sku + '" value="' + variations[i].product_id + '">' +
    //             '<td>' + variations[i].sku + '</td>' +
    //             '<td>' + variations[i].color + '</td>' +
    //             '<td>' + variations[i].size + '</td>' +
    //             '<td id="qty">' + variations[i].quantity + '</td>' +
    //             '<td><div class="custom-control custom-switch">' +
    //             '<input type="checkbox" class="custom-control-input upd-qty-shopee" id="shopee_'+variations[i].sku+'" '+shopee+' onchange="updatedQty(this, \'shopee\', '+variations[i].sku+')">' +
    //             '<label class="custom-control-label" for="shopee_'+variations[i].sku+'"></label>' +
    //             '</div></td>' +
    //             '<td><div class="custom-control custom-switch">' +
    //             '<input type="checkbox" class="custom-control-input upd-qty-lazada" id="lazada_'+variations[i].sku+'" '+lazada+' onchange="updatedQty(this, \'lazada\', '+variations[i].sku+')">' +
    //             '<label class="custom-control-label" for="lazada_'+variations[i].sku+'"></label>' +
    //             '</div></td>' +
    //             '</tr>';
    //     }
    //     if (isNew === "isNew") {
    //         let new_sku = Number(variations[variations.length - 1].sku) < 10 ? "0" + variations[variations.length - 1].sku : Number(variations[variations.length - 1].sku) + 1;
    //         table += '<tr class="' + new_sku + '">' +
    //             '<td>' + new_sku + '</td>' +
    //             '<td><select class="select-color-' + new_sku + ' form-control w100" id="select_color_' + new_sku + '"><option value="-1"></option></select></td>' +
    //             '<td><select class="select-size-' + new_sku + ' form-control w100" id="select_size_' + new_sku + '"><option value="-1"></option></select></td>' +
    //             '<td><select class="select-qty-' + new_sku + ' form-control w100" id="select_qty_' + new_sku + '"><option value="-1"></option></select></td>' +
    //             '<input type="hidden" class="product-id-' + new_sku + '" value="' + variations[variations.length - 1].product_id + '">' +
    //             '</tr>';
    //     }
    //     table += '</tbody>';
    //     table += '</table>';
    //     return table;
    // }

</script>
</body>
</html>
