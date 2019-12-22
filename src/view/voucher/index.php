<?php require_once("../../common/constants.php") ?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Danh sách mã giảm giá</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo __PATH__?>dist/img/icon.png"/>
    <?php require ('../../common/css.php'); ?>
    <?php require ('../../common/js.php'); ?>
    <style>

        td.details-control {
            text-align:center;
            color:forestgreen;
            cursor: pointer;
        }
        tr.shown td.details-control {
            text-align:center;
            color:red;
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
    </style>
</head>
<?php require ('../../common/header.php'); ?>
<?php require ('../../common/menu.php'); ?>
<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!--<div class="row col-12" style="display: inline-block;float: right;">
                    <section style="display: inline-block;float: right;padding-top: 1.25rem;">
                        <button type="button" class="btn btn-success btn-flat voucher-create">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i> Tạo mới
                        </button>
                    </section>
                </div>-->
                <div class="card-body">
                    <table id="example" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th class="hidden">Id</th>
                            <th>No.</th>
                            <th>Mã</th>
                            <th>Giá trị</th>
                            <th>Ngày bắt đầu hiệu lực</th>
                            <th>Ngày hết hạn</th>
                            <th>Trạng thái</th>
<!--                            <th>Ngày tạo</th>-->
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
<?php require_once ('createVoucher.php'); ?>
</div>
<?php require_once (__PATH__.'src/common/footer.php'); ?>
<script>
    $(document).ready(function () {
        set_title("Danh sách mã giảm giá");
        generate_datatable();
    });
    function generate_datatable() {
        let table = $('#example').DataTable({
            "ajax": '<?php echo __PATH__.'src/controller/voucher/VoucherController.php?method=findall' ?>',
            select:"single",
            deferRender: true,
            rowId: 'extn',
            "columns": [
                {
                    "data": "id",
                    "className": 'hidden',
                    width:"5px"
                },
                {
                    "data": 'no',
                    "className": 'center',
                    width:"5px"
                },
                {
                    "data": 'code',
                    width:"50px"
                },
                {
                    "data": format_value,
                    width:"50px"
                },
                {
                    "data": "start_date",
                    width:"50px"
                },
                {
                    "data": "expired_date",
                    width:"50px"
                },
                {
                    "data": format_status,
                    width:"50px"
                },
                // {
                //     "data": "created_date",
                //     width:"50px"
                // },
                {
                    "data": format_action,
                    width:"50px"
                }
            ],
            "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]]
        });


        $('#example tbody').on('click', '.del_voucher', function () {
            let tr = $(this).closest('tr');
            let td = tr.find("td");
            let voucher_id = $(td[1]).text();
            Swal.fire({
                title: 'Bạn có chắc chắn muốn xóa mã này?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ok'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url : '<?php echo __PATH__.'src/controller/voucher/VoucherController.php' ?>',
                        type : "POST",
                        dataType : "json",
                        data : {
                            type : "del_voucher",
                            voucher_id : voucher_id
                        },
                        success : function(res){
                            var response = res.response;
                            console.log(response);
                            toastr.success('Mã voucher đã được xóa thành công.');
                            hide_loading();
                            table.ajax.reload();
                        },
                        error : function(data, errorThrown) {
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

        $('#example tbody').on('click', '.edit_voucher', function () {
            var tr = $(this).closest('tr');
            var td = tr.find("td");
            var id = $(td[1]).text();
            var code = $(td[2]).text();
            var value = $(td[3]).text();
            var startDate = $(td[4]).text();
            var expiredDate = $(td[5]).text();

            var input_code = '<input type="text" id="code_'+id+'" value="'+code+'">';
            var input_value = '<input type="text" id="value_'+id+'" value="'+value+'">';
            var input_startDate = '<input type="text" id="startDate_'+id+'" value="'+startDate+'">';
            var input_expiredDate = '<input type="text" id="expiredDate_'+id+'" value="'+expiredDate+'">';
            var btn_gr = '<button type="button" class="btn bg-gradient-primary btn-sm update_voucher"><i class="fas fa-save"></i> Lưu</button>&nbsp;'+
                '<button type="button" class="btn bg-gradient-danger btn-sm cancel_edit" "><i class="fas fa-trash"></i> Hủy</button>';
            var gr_input_hidden = '<input type="hidden" id="curr_code_'+id+'" value="'+code+'">' +
                '<input type="hidden" id="curr_value_'+id+'" value="'+value+'">' +
                '<input type="hidden" id="curr_startDate_'+id+'" value="'+startDate+'">' +
                '<input type="hidden" id="curr_expiredDate_'+id+'" value="'+expiredDate+'">';
            $(td[2]).html(input_code);
            $(td[3]).html(input_value);
            $(td[4]).html(input_startDate);
            $(td[5]).html(input_expiredDate);
            $(td[7]).html(btn_gr);
            $(tr).append(gr_input_hidden);
        });

        $('#example tbody').on('click', '.update_voucher', function () {
            show_loading();
            var tr = $(this).closest('tr');
            var td = tr.find("td");
            var id = $(td[1]).text();
            var code = $("#code_"+id).val();
            var value = $("#value_"+id).val();
            var startDate = $("#startDate_"+id).val();
            var expiredDate = $("#expiredDate_"+id).val();
            var canceled = $(td[6]).text();
            if(canceled === "") {
                canceled = "0";
            } else {
                canceled = "1";
            }
            $.ajax({
                url : '<?php echo __PATH__.'src/controller/voucher/VoucherController.php' ?>',
                type : "POST",
                dataType : "json",
                data : {
                    method : "update_voucher",
                    id : id,
                    code : code,
                    value : value,
                    startDate : startDate,
                    expiredDate : expiredDate,
                    canceled : canceled
                },
                success : function(){
                    toastr.success('Cập nhật thành công!');
                    $(td[2]).html(code);
                    $(td[3]).html(value);
                    $(td[4]).html(startDate);
                    $(td[5]).html(expiredDate);
                    $(td[6]).html(format_action());
                    hide_loading();
                },
                error : function(data, errorThrown) {
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
        });

        // Event click cancel edit variation
        $('#example tbody').on('click', '.cancel_variation', function () {
            var tr = $(this).closest('tr');
            var td = tr.find("td");
            var sku = tr.attr("class");
            var color = $("#curr_color_"+sku).val();
            var size = $("#curr_size_"+sku).val();
            var qty = $("#curr_qty_"+sku).val();
            var btn_gr = '<button type="button" class="btn bg-gradient-info btn-sm edit_variation"><i class="fas fa-edit"></i> Sửa</button>&nbsp;';
            // '<button type="button" class="btn bg-gradient-danger btn-sm delete_variation"><i class="fas fa-trash"></i> Xóa</button>';

            $(td[2]).html(color);
            $(td[3]).html(size);
            $(td[4]).html(qty);
            $(td[5]).html(btn_gr);

            $("#curr_color_"+sku).remove();
            $("#curr_size_"+sku).remove();
            $("#curr_qty_"+sku).remove();
        });

    }

    function format_action()
    {
        // return '<button type="button" class="btn bg-gradient-info btn-sm edit_voucher"><i class="fas fa-edit"></i> Sửa</button>&nbsp;' +
        //     '<button type="button" class="btn bg-gradient-danger btn-sm del_voucher" "><i class="fas fa-trash"></i> Xóa</button>&nbsp;' +
        //     '<button type="button" class="btn bg-gradient-danger btn-sm cancel_voucher" "><i class="far fa-window-close"></i> Hủy</button>';
        return '<button type="button" class="btn bg-gradient-success btn-sm active_voucher"><i class="fas fa-check"></i> Kích hoạt</button>';
    }

    function format_value(data)
    {
        let type = data.type;
        let value = "";
        if(type == 0) {
            value = formatNumber(data.value)+ " <small>đ</small>";
        } else if(type == 1) {
            value = data.value + "%";
        }
        return value;
    }
    function format_status(data)
    {
        let status = data.status;
        switch (status) {
            case '1':
                return '<span class="badge badge-secondary">Chưa kích hoạt</span>';
                break;
            case '2':
                return '<span class="badge badge-success">Đã kích hoạt</span>';
                break;
            case '3':
                return '<span class="badge badge-warning">Đã sử dụng</span>';
                break;
            default:
                return '';
                break;
        }

    }
</script>
</body>
</html>
