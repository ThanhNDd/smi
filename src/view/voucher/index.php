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

        $('#example tbody').on('click', '.active_voucher', function () {
            let tr = $(this).closest('tr');
            let td = tr.find("td");
            let voucher_id = $(td[1]).text();
            let voucher_code = $(td[2]).text();
            $.ajax({
                url : '<?php echo __PATH__.'src/controller/voucher/VoucherController.php' ?>',
                type : "POST",
                dataType : "json",
                data : {
                    method : "update_status",
                    voucher_id : voucher_id,
                    status: 2 // active
                },
                success : function(res){
                    console.log(res);
                    toastr.success('Mã voucher '+voucher_code+' đã được kích hoạt thành công.');
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
        });

        $('#example tbody').on('click', '.inactive_voucher', function () {
            let tr = $(this).closest('tr');
            let td = tr.find("td");
            let voucher_id = $(td[1]).text();
            let voucher_code = $(td[2]).text();
            $.ajax({
                url : '<?php echo __PATH__.'src/controller/voucher/VoucherController.php' ?>',
                type : "POST",
                dataType : "json",
                data : {
                    method : "update_status",
                    voucher_id : voucher_id,
                    status: 1
                },
                success : function(res){
                    console.log(res);
                    toastr.success('Mã voucher '+voucher_code+' đã ngừng kích hoạt.');
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
                            toastr.success('Mã voucher '+voucher_id+' đã được xóa thành công.');
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
        
    }

    function format_action(data)
    {
        // return '<button type="button" class="btn bg-gradient-info btn-sm edit_voucher"><i class="fas fa-edit"></i> Sửa</button>&nbsp;' +
        //     '<button type="button" class="btn bg-gradient-danger btn-sm del_voucher" "><i class="fas fa-trash"></i> Xóa</button>&nbsp;' +
        //     '<button type="button" class="btn bg-gradient-danger btn-sm cancel_voucher" "><i class="far fa-window-close"></i> Hủy</button>';
        if(data.status == 2) {
            return '<button type="button" class="btn bg-gradient-danger btn-sm inactive_voucher"><i class="fas fa-check"></i> Ngừng Kích hoạt</button>';
        } else if(data.status == 1) {
            return '<button type="button" class="btn bg-gradient-success btn-sm active_voucher"><i class="fas fa-check"></i> Kích hoạt</button>';
        } else {
            return '';
        }
        
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
            case '4':
                return '<span class="badge badge-secondary">Đã khoá</span>';
                break;
            default:
                return '';
                break;
        }

    }
</script>
</body>
</html>
