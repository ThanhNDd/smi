<?php
require_once("../../common/common.php");
Common::authen();
?>
<div class="modal fade" id="show_wallet_history">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="overlay d-flex justify-content-center align-items-center">
                <i class="fas fa-2x fa-sync fa-spin"></i>
            </div>
            <div class="modal-header">
                <h4 class="modal-title modal-customer">Lịch sử giao dịch</h4>
                <button type="button" class="close close-modal-show-history" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-2">
                        <span>
                            Mã khách hàng:
                        </span>
                        <strong id="text_customer_id" class="text-danger"></strong>
                    </div>
                    <div class="col-sm-3">
                        <span>
                            Tên khách hàng:
                        </span>
                        <strong id="text_customer_name" class="text-danger"></strong>
                    </div>
                    <div class="col-sm-3">
                        <span>
                            Số điện thoại:
                        </span>
                        <strong id="text_customer_phone" class="text-danger"></strong>
                    </div>
                    <div class="col-sm-2">
                        <span>
                            Tổng số đơn hàng:
                        </span>
                        <strong id="total_order" class="text-danger"></strong>
                    </div>
                    <div class="col-sm-2">
                        <span>
                            Số dư khả dụng:
                        </span>
                        <strong id="available_ballances" class="text-danger"></strong>
                    </div>
                </div>
                <div class="form-group">
                    <table class="table table-striped table-hover" id="table_show_wallet_history">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Mã đơn hàng</th>
                                <th scope="col">Tích lũy <sup class="text-danger">(1)</sup></th>
                                <th scope="col">Sử dụng</th>
                                <th scope="col">Chuyển vào ví <sup class="text-danger">(2)</sup></th>
                                <th scope="col">Số còn lại <sup class="text-danger">(3)</sup></th>
                                <th scope="col">Số dư khả dụng<br><small class="text-danger">(1)+(2)+(3)</small></th>
                                <th scope="col">Ngày mua hàng</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer right">
                <button type="button" class="btn btn-secondary close-modal-show-history">Close</button>
            </div>
        </div>
    </div>
<script>
    $(document).ready(function () {
        close_modal_show_history();
        $("#edit_customer").click(function () {
            let customer_id = $("#customer_id").val();
            edit_customer(customer_id);
        });
    });

    function show_history(customerId, customerName, customer_phone) {
        if(customerId) {
            $.ajax({
                url: "<?php Common::getPath() ?>src/controller/Wallet/WalletController.php",
                dataType: 'json',
                type: 'post',
                data: {
                    customerId: customerId,
                    method: 'show_history'
                },
                success: function (res) {
                    hide_loading();
                    let data = res.data;
                    set_data(data, customerId, customerName, customer_phone);
                    setTimeout(function () {
                        open_modal("#show_wallet_history");
                        $('#table_show_wallet_history').DataTable();
                    },300);
                }
            });
        } else {
            hide_loading();
            toastr.error('Đã xảy ra lỗi!!!');
        }
    }
    
    function set_data(data, customerId, customerName, customer_phone) {
        $("#table_show_wallet_history tbody").html("");
        let final_available_ballances = 0;
        let no = 1;
        $.each(data, function (k, v) {
            let order_id = v.order_id;
            let saved = v.saved;
            let used = v.used;
            let repay = v.repay;
            let remain = v.remain;
            let created_at = v.created_at;
            let available_ballances = Number(replaceComma(saved)) + Number(replaceComma(repay)) + Number(replaceComma(remain));
            if(no === 1) {
                final_available_ballances = available_ballances;
            }
            $("#table_show_wallet_history tbody").append("<tr>" +
                "<th scope='row'>"+no+"</th>" +
                "<td><a href='<?php Common::getPath() ?>src/view/orders/?order_id="+order_id+"' target='_blank'>"+order_id+"</a></td>" +
                "<td>"+saved+"<sup>đ</sup></td>" +
                "<td>"+used+"<sup>đ</sup></td>" +
                "<td>"+repay+"<sup>đ</sup></td>" +
                "<td>"+remain+"<sup>đ</sup></td>" +
                "<td>"+formatNumber(available_ballances)+"<sup>đ</sup></td>" +
                "<td>"+created_at+"</td>" +
                "</tr>");
            no++;
        });
        $("#text_customer_id").html(customerId+" <a href='<?php Common::getPath() ?>src/view/orders/?customer_id="+customerId+"' target='_blank'><i class=\"fas fa-external-link-alt\"></i></a>");
        $("#text_customer_name").html(customerName);
        $("#text_customer_phone").html(customer_phone+" <a href='<?php Common::getPath() ?>src/view/orders/?customer_phone="+customer_phone+"' target='_blank'><i class=\"fas fa-external-link-alt\"></i></a>");
        $("#total_order").text(no-1);
        $("#available_ballances").html(formatNumber(final_available_ballances)+"<sup>đ</sup>");
    }

    function close_modal_show_history() {
        $('.close-modal-show-history').click(function () {
            close_modal("#show_wallet_history");
        });
    }
</script>