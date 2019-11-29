<?php require_once("../../common/constants.php") ?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo __PATH__?>dist/img/icon.png"/>
  <title>Quản lý đơn hàng</title>
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
  </style>
</head>  
<?php require ('../../common/header.php'); ?>
<?php require ('../../common/menu.php'); ?>
<section class="content">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Danh sách đơn hàng</h3>
        </div>
        <div class="row col-12" style="display: inline-block;float: right;">
          <section style="display: inline-block;float: right;padding-top: 1.25rem;">
            <button type="button" class="btn btn-success btn-flat order-create">
              <i class="fa fa-plus-circle" aria-hidden="true"></i> Tạo mới
            </button>   
            <!-- <button type="button" class="btn btn-info btn-flat order-update">
              <i class="fas fa-sync-alt"></i> Cập nhật
            </button> -->            
          </section>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th></th>
                <th class="hidden">ID</th>
                <th>Tên khách hàng</th>
                <th>Số điện thoại</th>
                <th>Địa chỉ</th>
                <th class="right">Phí ship</th>
                <th class="right">Chiết khấu</th>
                <th class="right">Tổng tiền</th>
                <th class="center">Ngày mua hàng</th>
                <th class="left">Loại đơn</th>
                <th class="left">Trạng thái</th>
              </tr>
            </thead>
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
<?php include 'createOrders.php'; ?>
</div>
<?php include __PATH__.'src/common/footer.php'; ?>
  <script>
    $(document).ready(function () {
        generate_datatable();
    });
    
    function generate_datatable() {
        var table = $('#example').DataTable({
            "ajax": "<?php echo __PATH__.'src/controller/orders/processOrder.php?method=find_all' ?>",
             select:"single",
             "columns": [
                 {
                     "className": 'details-control',
                     "orderable": false,
                     "data": null,
                     "defaultContent": '',
                     "render": function () {
                         return '<i class="fa fa-plus-square" aria-hidden="true"></i>';
                     },
                     width:"5px"
                },
                { 
                    "data": "order_id",
                     width:"70px",
                     class: 'hidden'
                },
                { 
                    "data": format_customer_name,
                     width:"150px" 
                },
                { 
                    "data": "phone",
                     width:"70px" 
                },
                { 
                    "data": "address",
                     width:"300px" 
                },
                { 
                    "data": "shipping",
                     width:"50px" ,
                     class: 'right'
                },
                { 
                    "data": "discount",
                     width:"50px"  ,
                     class: 'right'
                },
                { 
                    "data": "total_checkout",
                     width:"50px"  ,
                     class: 'right'
                },
                { 
                    "data": "created_date",
                     width:"80px"  ,
                     class: 'center'
                },
                { 
                    "data": format_type,
                     width:"80px" 
                },
                { 
                    "data": format_status,
                     width:"80px" 
                }      
             ],
            "lengthMenu": [[50, 100, -1], [50, 100, "All"]]
         });

         // Add event listener for opening and closing details
         $('#example tbody').on('click', '.details-control', function () {
             var tr = $(this).closest('tr');
             var tdi = tr.find("i.fa");
             var row = table.row(tr);

             if (row.child.isShown()) {
                 // This row is already open - close it
                 row.child.hide();
                 tr.removeClass('shown');
                 tdi.first().removeClass('fa-minus-square');
                 tdi.first().addClass('fa-plus-square');
             }
             else {
                 // Open this row
                 row.child(format_order_detail(row.data())).show();
                 tr.addClass('shown');
                 tdi.first().removeClass('fa-plus-square');
                 tdi.first().addClass('fa-minus-square');
             }
         });

         table.on("user-select", function (e, dt, type, cell, originalEvent) {
             if ($(cell.node()).hasClass("details-control")) {
                 e.preventDefault();
             }
         });
    }

    function format_order_detail(data){
        var details = data.details;
        var table = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
        table += '<thead>' +
                    '<tr>' +
                        '<th>Mã</th>' +
                        '<th>Tên</th>' +
                        '<th>Số lượng</th>' +
                        '<th class="right">Giá</th>' +
                        '<th class="right">Giảm trừ</th>' +
                        '<th class="right">Thành tiền</th>' +
                  '</tr>' +
                '</thead>';
        for(var i=0; i<details.length; i++) {
          table += '<tr>' +
                '<input type="hidden" id="product_id_'+i+'" value="'+details[i].product_id+'"/>' +
                '<input type="hidden" id="variant_id_'+i+'" value="'+details[i].variant_id+'"/>' +
                '<td>'+details[i].sku+'</td>' +
                '<td>'+details[i].product_name+'</td>' +
                '<td>'+details[i].quantity+'</td>' +
                '<td class="right">'+details[i].price+'&nbsp;</td>' +
                '<td class="right">'+details[i].reduce+'&nbsp;</td>' +
                '<td class="right">'+details[i].intoMoney+'&nbsp;</td>' +
              '</tr>';
        }
        table += '</table>';  
      return table;         
    }
    
    function format_customer_name(data){
         if(data.customer_name == "" || data.customer_name  == null)
         {
           return "Khách lẻ";
         } else {
           return data.customer_name;
         }
    }

    // function format_total(data) {
    //     return '<span class="woocommerce-Price-amount amount">'+data.total+'&nbsp;<span class="woocommerce-Price-currencySymbol">&#8363;</span></span>';
    // }
    // function format_shipping(data) {
    //     return '<span class="woocommerce-Price-amount amount">'+data.shipping+'&nbsp;<span class="woocommerce-Price-currencySymbol">&#8363;</span></span>';
    // }
    // function format_fee(data) {
    //     return '<span class="woocommerce-Price-amount amount">'+data.fee+'&nbsp;<span class="woocommerce-Price-currencySymbol">&#8363;</span></span>';
    // }
      function format_type(data) {
        var type = data.type;
        switch(type) {
        case '0' :
          return '<span class="badge badge-warning">Shop</span>';
          break;
        case '1':
          return '<span class="badge badge-success">Online</span>';
          break;
        default:
          return '';
          break;
      }
    }
    function format_status(data) {
      if(data.status === null)
      {
        return;
      }
      var status = data.status;
      switch(status) {
        case '0' :
          return '<span class="badge badge-warning">Đang đợi</span>';
          break;
        case '1':
          return '<span class="badge badge-primary">Đang xử lý</span>';
          break;
        case '2':
          return '<span class="badge badge-info">Tạm giữ</span>';
          break;
        case '3':
          return '<span class="badge badge-success">Thành công</span>';
          break;
        case '4':
          return '<span class="badge badge-secondary">Đã hủy</span>';
          break;
        case '5':
          return '<span class="badge badge-danger">Thất bại</span>';
          break;
        default:
          break;
      }
    }

    function update_data() {
        $(".loading").removeClass("hidden");
        $.ajax({
            url : '<?php echo __PATH__."src/controller/orders/data.php" ?>',
            dataType : "json",
            data : {
              orders: 'update'
            },
            type : 'GET',
            success : function (res) {
                alert("Cập nhật dữ liệu thành công!");
                // window.location.reload();
            },
            error : function (data, errorThrown) {
              console.log(data.responseText);
              alert("Đã có lỗi xảy ra");
              $(".loading").addClass("hidden");
            }
        });
    }
   
  </script>
</body>
</html>
