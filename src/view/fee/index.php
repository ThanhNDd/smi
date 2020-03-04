<?php
require_once("../../common/common.php");
Common::authen();
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Quản lý chi phí</title>
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
    </style>
</head>
<?php require_once('../../common/header.php'); ?>
<?php require_once('../../common/menu.php'); ?>
<section class="content">
    <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="far fa-money-bill-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Tổng chi phí</span>
                    <span class="info-box-number" id="total_fee">1,410</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fas fa-dollar-sign"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Chi phí cố định</span>
                    <span class="info-box-number" id="total_fixed_fee">410</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-secondary"><i class="fas fa-hand-holding-usd"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Chi phí khả biến</span>
                    <span class="info-box-number" id="total_variable_fee">13,648</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-transparent pb-0">
                    <div class="form-group col-md-4 float-left mb-0">
                        <div class="input-group">
                            <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="far fa-calendar-alt"></i>
                  </span>
                            </div>
                            <input type="text" class="form-control float-left" id="reservation">
                        </div>
                        <!-- /.input group -->
                    </div>
                    <div class="float-right">
                        <button type="button" class="btn btn-success btn-flat float-left"  id="create_new_fee">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i> Tạo mới
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="hidden"></th>
                            <th>Ngày tháng</th>
                            <th>Lý do</th>
                            <th>Số tiền</th>
                            <th>Loại chi phí</th>
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
<div class="modal fade" id="formFee">
    <div class="modal-dialog modal-md modal-dialog-scrollable">
        <div class="modal-content">
            <div class="overlay d-flex justify-content-center align-items-center hidden">
                <i class="fas fa-2x fa-sync fa-spin"></i>
            </div>
            <div class="modal-header">
                <h4 class="modal-title">Tạo mới phiếu chi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="min-height: 300px;">
                <input type="hidden" class="form-control" id="id" value="">
                <div class="form-group">
                    <label for="feeDate">Ngày chi</label>
                    <input class="form-control datepicker" id="feeDate" data-date-format="dd/mm/yyyy"
                           value="<?php echo date('d/m/Y'); ?>">
                </div>
                <div class="form-group">
                    <label for="reason">Lý do</label>
                    <input type="text" class="form-control" id="reason" placeholder="Nhập lý do">
                </div>
                <div class="form-group">
                    <label for="amount">Số tiền</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="amount" placeholder="Nhập số tiền">
                        <div class="input-group-append">
                            <span class="input-group-text">đ</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="type">Loại chi phí</label>
                    <select class="form-control" id="type">
                        <option value="0" selected>Chi phí khả biến</option>
                        <option value="1">Chi phí cố định</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="add_new">
                    <span class="spinner-border spinner-border-sm hidden"></span>
                    Đăng ký
                </button>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="startDate">
<input type="hidden" id="endDate">
<?php require_once('../../common/footer.php'); ?>
<script>
    $(document).ready(function () {
        set_title("Quản lý chi phí");
        // generate_datatable();
        $('#create_new_fee').click(function () {
            reset_modal();
            open_modal();
        });

        $("#add_new").click(function () {
            if(!validate_form()) {
                return;
            }
            Swal.fire({
                title: 'Bạn chắc chắn chứ?',
                text: "Hãy kiểm tra kỹ các thông tin đã nhập",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ok'
            }).then((result) => {
                if (result.value) {
                    add_new();
                }
            });
        });

        $("#amount").change(function () {
            let val = $(this).val();
            if(validate_number(val)) {
                if(Number(val) < 1000) {
                    val += "000";
                }
                $(this).val(formatNumber(val));
            }
        });

        let startDate = moment().startOf('month').format("YYYY-MM-DD");
        let endDate = moment().endOf('month').format("YYYY-MM-DD");
        $("#startDate").val(startDate);
        $("#endDate").val(endDate);
        generate_datatable();
        get_total_fee();

        $('#reservation').daterangepicker({
            startDate: moment().startOf('month'),
            endDate: moment().endOf('month'),
            locale: {
                format: 'DD/MM/YYYY',
            }
        }, function (start, end, label) {
            let start_date = start.format('YYYY-MM-DD');
            let end_date = end.format('YYYY-MM-DD');
            $("#startDate").val(start_date);
            $("#endDate").val(end_date);
            generate_datatable();
            get_total_fee();
        });
    });

    function generate_datatable() {
        $('#example').DataTable({
            'ajax': {
                "type": "GET",
                "url": '<?php Common::getPath() ?>src/controller/fee/FeeController.php',
                "data": function (d) {
                    d.method = 'findall';
                    d.start_date = $("#startDate").val();
                    d.end_date = $("#endDate").val();
                }
            },
            destroy: true,
            ordering: false,
            scrollCollapse: true,
            "language": {
                "emptyTable": "Không có dữ liệu"
            },
            select: "single",
            "columns": [
                {
                    "data": "no",
                    width: "5px"
                },
                {
                    "data": "id",
                    "className": 'hidden',
                    width: "5px"
                },
                {
                    "data": "fee_date",
                    width: "150px"
                },
                {
                    "data": "reason",
                    width: "200px"
                },
                {
                    "data": "amount",
                    width: "100px"
                },
                {
                    "data": format_type,
                    width: "100px"
                },
                {
                    "data": format_action,
                    width: "50px"
                }
            ],
            "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]]
        });

        $('#example tbody').on('click', '.btn_edit', function () {
            let tr = $(this).closest('tr');
            let td = tr.find("td");
            let id = $(td[1]).text();
            edit_fee(id);
        });

        $('#example tbody').on('click', '.btn_delete', function () {
            let tr = $(this).closest('tr');
            let td = tr.find("td");
            let id = $(td[1]).text();
            delete_fee(id);
        });
    }

    function format_type(data) {
        let type = data.type;
        if(type == 0) {
            return '<span class="badge badge-secondary">Khả biến</span>';
        } else {
            return '<span class="badge badge-warning">Cố định</span>';
        }
    }

    function format_action() {
        return '<button class="btn bg-gradient-info btn-sm btn_edit" title="Sửa">' +
            '<i class="fas fa-pencil"></i> Sửa</a>' +
            '</button>&nbsp;&nbsp;' +
            '<button class="btn bg-gradient-danger btn-sm btn_delete" title="Xóa">' +
            '<i class="fas fa-trash"></i> Xóa</a>' +
            '</button>';
    }

    function open_modal() {
        $('#formFee').modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
    }

    function reset_modal() {
        $(".modal-title").text("Tạo mới phiếu chi");
        $("#id").val(0);
        $("#feeDate").val(get_current_date());
        $("#reason").val('');
        $("#amount").val('');
        $("#type").val(0).trigger("change");
    }

    function validate_form() {
        let valid = true;
        let feeDate = $("#feeDate").val();
        if(!validate_date(feeDate)) {
            toastr.error("Đã có lỗi xảy ra");
            $("#feeDate").focus();
            valid = false;
        }
        let reason = $("#reason").val();
        if(reason == "") {
            toastr.error("Đã có lỗi xảy ra");
            $("#reason").focus();
            valid = false;
        }
        let amount = $("#amount").val();
        if(!validate_number(amount)) {
            toastr.error("Đã có lỗi xảy ra");
            $("#amount").focus();
            valid = false;
        }
        return valid;
    }

    function get_inform() {
        let id = $("#id").val();
        let feeDate = $("#feeDate").val();
        let reason = $("#reason").val();
        let amount = $("#amount").val();
        let type = $("#type").val();

        let fee = {};
        fee["id"] = id;
        fee["feeDate"] = feeDate;
        fee["reason"] = reason;
        fee["amount"] = replaceComma(amount);
        fee["type"] = type;

        return JSON.stringify(fee);
    }

    function add_new() {
        let fee = get_inform();
        $.ajax({
            url: '<?php Common::getPath()?>src/controller/fee/FeeController.php',
            type: "POST",
            dataType: "json",
            data: {
                method: "save_or_update_fee",
                data: fee
            },
            success: function (res) {
                console.log(res);
                let table = $('#example').DataTable();
                table.ajax.reload();
                toastr.success("Lưu thành công");
                reset_modal();
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

    function delete_fee(id) {
        if(id == "") {
            toastr.error("Đã xảy ra lỗi");
            return;
        }
        Swal.fire({
            title: 'Bạn có chắc chắn muốn xóa?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok'
        }).then((result) => {
            if (result.value) {
                process_delete(id);
            }
        });
    }

    function process_delete(id) {
        $.ajax({
            url: '<?php Common::getPath() ?>src/controller/fee/FeeController.php',
            type: "POST",
            dataType: "json",
            data: {
                method: "delete_fee",
                id: id
            },
            success: function (res) {
                toastr.success('Xóa thành công!');
                let table = $('#example').DataTable();
                table.ajax.reload();
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

    function edit_fee(id) {
        if(id == "") {
            toastr.error("Đã xảy ra lỗi");
            return;
        }
        $.ajax({
            url: '<?php Common::getPath() ?>src/controller/fee/FeeController.php',
            type: "POST",
            dataType: "json",
            data: {
                method: "edit_fee",
                id: id
            },
            success: function (response) {
                reset_modal();
                let res = response.data;
                console.log(res[0]);
                $("#id").val(res[0].id);
                $("#feeDate").val(res[0].fee_date);
                $("#reason").val(res[0].reason);
                $("#amount").val(res[0].amount);
                $("#type").val(res[0].type).trigger("change");
                $(".modal-title").text("Cập nhật phiếu chi");
                open_modal();
            },
            error: function (data, errorThrown) {
                console.log(data);
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

    function get_total_fee() {
        $.ajax({
            url: '<?php Common::getPath()?>src/controller/fee/FeeController.php',
            type: "POST",
            dataType: "json",
            data: {
                method: "total_fee",
                start_date:  $("#startDate").val(),
                end_date : $("#endDate").val()
            },
            success: function (res) {
                console.log(res);
                $("#total_fee").text(res.total_fee);
                $("#total_fixed_fee").text(res.total_fixed_fee);
                $("#total_variable_fee").text(res.total_variable_fee);
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
