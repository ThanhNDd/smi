<?php
require_once("../../common/common.php");
Common::authen();
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Tạo đơn hàng loạt</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?php Common::getPath() ?>dist/img/icon.png"/>
    <?php require_once('../../common/css.php'); ?>
    <?php require_once('../../common/js.php'); ?>
    <style type="text/css">
      .table thead th {
          white-space: nowrap;
      }
      td.details-control {
            text-align: center;
            color: forestgreen;
            cursor: pointer;
        }

        tr.shown td.details-control {
            text-align: center;
            color: red;
        }

        div#product_datatable {
            margin-top: 10px;
        }

        div#product_datatable_filter label {
            width: 100%;
            float: left;
        }

        table.dataTable.no-footer {
            border-bottom: none;
        }

        .title {
          width: 110px;
              vertical-align: top;
        }

        .text {
          display: inline-block;
          width: 100%;
          line-height: 20px;
        }
        .card-header {
            background-color: rgba(0,0,0,.03);
        }
        .spinner-border {
          width: 1.2rem !important;
          height: 1.2rem !important;
        }

        #tabledata td {
          white-space: nowrap;
        }
        #tabledata tr {
          cursor: pointer;
        }
        .alert-success {
            color: #155724 !important;
            background-color: #d4edda !important;
            border-color: #c3e6cb !important;
        }
        .alert-warning {
          color: #856404 !important;
          background-color: #fff3cd !important;
          border-color: #ffeeba !important;
        }
        .alert-danger {
            color: #721c24 !important;
            background-color: #f8d7da !important;
            border-color: #f5c6cb !important;
        }
    </style>
  </head>
<?php require_once('../../common/header.php'); ?>
<?php require_once('../../common/menu.php'); ?>
<section class="content p-4">
  <div class="row col-md-12 mb-3">
    <a href="<?php Common::getPath() ?>src/view/orders/online.php" class="btn btn-sm btn-secondary btn-flat p-2">
        <i class="fas fa-backward"></i> Back
    </a>
  </div>

<!-- <div class="card">
  <div class="card-body"> -->
    <!-- <ul class="nav nav-pills">
      <li class="nav-item">
        <a class="nav-link active" data-toggle="pill"  href="#ghn">Giao hàng nhanh</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="pill"  href="#jt">J&T Express</a>
      </li>
    </ul> -->
    <!-- <div class="tab-content">
      <div class="tab-pane active" id="ghn">
        <br>
        <h1>Giao  hàng nhanh</h1>
      </div>
      <div class="tab-pane fade" id="jt">
        <br> -->
        <div class="card">
          <div class="card-body">
            <form id="import" method="post" enctype="multipart/form-data" class="d-inline-block">
              <label for="fileToUpload">Select file to upload:</label>
              <input type="file" name="fileToUpload" id="fileToUpload" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
              <button class="btn btn-primary" name="submit" id="submit" disabled style="border-radius: 4px !important;font-size: 12px;">
                <i class="fas fa-upload"></i> Tải lên
              </button>
            </form>
            <button class="btn btn-danger float-right" id="updateAll" style="border-radius: 4px !important;font-size: 12px;">
              <div class="spinner-border d-none" id="spinnerUpdateAll"></div>
              Cập nhật
            </button>
          </div>
        </div>
        <!-- <div class="alert alert-warning">
          <strong><i class="fas fa-exclamation-triangle"></i></strong> <strong>J&T Express:</strong> Tên file bắt đầu bằng <strong>data-</strong> (VD: data-2023-04-03-2023-04-03-1680517653129.xlsx)
          <br>
          <strong><i class="fas fa-exclamation-triangle"></i></strong> <strong>Giao hàng nhanh:</strong> Tên file bắt đầu bằng <strong>GHN_</strong> (VD: GHN_080420230837_3567976.xlsx)
        </div> -->
        <div class="table-responsive">          
          <table class="table table-striped table-hover" id="tabledata">
            <thead class="thead-light">
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th class="text-center" style="width: 50px;">STT</th>
                <th class="text-center" style="width: 150px;">Hành động</th>
                <th class="text-left" style="width: 150px;">Mã đơn hàng</th>
                <th class="text-left" style="width: 150px;">Mã vận đơn</th>
                <th class="text-left">Vận phí</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>  
      </div>
    <!-- </div>
  </div> -->
</div>
</section>

<?php require_once('../../common/footer.php'); ?>
<script>
  let excelData = null;
  let dataAvailable = [];
  $(document).ready(function(){

    $("#updateAll").click(async function() {
      let data = await getAvailableData();
      if(data.length == 0) {
        toastr.error('Không có đơn hàng phù hợp');
        return false;
      }
      $(`#updateAll`).attr("disabled", true);
      $(`#spinnerUpdateAll`).removeClass("d-none");
      Swal.fire({
        title: "Xác nhận",
        text: `Bạn có chắc chắn muốn cập nhật ${data.length} đơn hàng này`,
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ok'
      }).then(async (result) => {
          if (result.value) {
            await updateAllOrder(data).then((orderSuccess) => {
              console.log("new ExcelData: ")
              console.log("orderSuccess: ", orderSuccess);
              if(orderSuccess == data.length) {
                toastr.success(`Cập nhật ${orderSuccess} đơn thành công`);
              } 
              if(orderSuccess < data.length) {
                toastr.error(`Cập nhật ${Number(data.length) - Number(orderSuccess)} đơn không thành công`);
              }
              $(`#spinnerUpdateAll`).addClass("d-none");
              $(`#updateAll`).removeAttr("disabled"); 
            }).catch(() => {
              toastr.error('Đã xảy ra lỗi');
            });
          } else {
            $(`#spinnerUpdateAll`).addClass("d-none");
            $(`#updateAll`).removeAttr("disabled"); 
          }
      });
    })

    $("#fileToUpload").change(() => {
      let file_data = $("#fileToUpload").prop('files')[0];
      console.log(file_data.name.indexOf("GHN_"));
      if(file_data) {
        let filename = file_data.name;
        // if(filename.indexOf("GHN_") == -1 || filename.indexOf("data-") == -1) {
        //   toastr.error('Định dạng file không đúng');
        //   return false;
        // }
        const lastDot = filename.lastIndexOf('.');
        const ext = filename.substring(lastDot + 1);
        if(ext == 'xls' || ext == 'xlsx') {
          $("#submit").removeAttr("disabled");
        } else {
          toastr.error('Định dạng file không đúng');
          return false;
        }
      } else {
        $("#submit").attr("disabled", true);
      }
    });

      $("#submit").click(function(e) {
        e.preventDefault();    
        var form = $("#import");
        let file_data = $("#fileToUpload").prop('files')[0];
        var formData = new FormData(form[0]);
        formData.append('file', file_data);
        $.ajax({
            url: "<?php Common::getPath() ?>src/controller/batch/UpdateController.php",
            type: 'POST',
            data: formData,
            success: async (response) => {
              console.log(response);  
              $("#data").html("");
              let data = JSON.parse(response);
              if(data.length == 0) {
                toastr.error("Không có dữ liệu");
              }
              excelData = data;
              await generateDataTable().then(() => {
                $("#fileToUpload").val("");
                $("#submit").attr("disabled", true);
              });
            },
            cache: false,
            contentType: false,
            processData: false
          }).done(function() {
            if(excelData && excelData.length > 0) {
                $("#fileToUpload").val("");
                $("#submit").attr("disabled", true);

            }
          });
    });

  });

  function getAvailableData() {
    return new Promise((resolve) => {
      let data = [];
      $.each(excelData, (k, v) => {
        console.log(v);
        if(v.order_id) {
          let checked = $(`#checkbox_${v.order_id}`).is(":checked");
          console.log("Checked: ", checked);
          if(checked) {
            data.push(v);
          }
        }
      });
      resolve(data);
    });
  }

  function updateAllOrder(data) {
    return new Promise((resolve) => {
      let orderSuccess = 0;
      $.each(data, async (k, order) => {
        orderSuccess++;
        console.log(order);
        await sendData(order).then(async (result) => {
          $(`#order_${order.order_id}`).text("Đã cập nhật").removeClass("btn-success").addClass("btn-secondary").attr("disabled", true);
          $(`#spinner_${order.order_id}`).removeClass("d-none");
          $(`#checkbox_${order.order_id}`).attr("disabled", true);
          orderSuccess++;
        })
      });
      resolve(orderSuccess);
    });
  }

  function generateDataTable() {
    return new Promise((resolve) => {
      $("#tabledata tbody").html("");
      let index = 1;
      console.log("excelData generateDataTable: ",JSON.stringify(excelData));
      $.each(excelData, function(k, v){
        let content = `<tr>`;
            content += `<td class="text-center"><input id="checkbox_${v.order_id}" type="checkbox" checked/></td>`;
            content += `<td class="text-center">${index}</td>`;
            content += `<td class="text-center">`;
            if(v.hasOwnProperty('existedOrder')) {
              content += `<button class="btn btn-secondary" disabled style="border-radius: 4px !important;font-size: 12px;">Đã tạo đơn</button>`;
            } else {
              content += `<button class="btn btn-success" id="order_${v.order_id}" 
                            onclick="updateOrder(this, '${v.order_id}')" 
                            style="border-radius: 4px !important;font-size: 12px;">
                            <div class="spinner-border d-none" id="spinner_${v.order_id}"></div>
                            Cập nhật
                          </button>`;
            }
            content += `</td>`;
            content += `<td class="text-left"><a href="javascript:void(0)" class="td_${v.order_id}">${v.order_id}</a></td>`;
            content += `<td class="text-left">${v.bill_no}</td>`;
            content += `<td class="text-left">${formatNumber(v.shipping_fee)}</td>`;
            content += `</tr>`;
        $("#tabledata tbody").append(content);
        index++;
      }); 
      resolve();
    });
  }

  async function updateOrder(e, order_id) {
    let order = await getData(order_id);
    console.log(JSON.stringify(order)); 
    if(order) {
      Swal.fire({
          title: "Xác nhận",
          text: "Bạn có chắc chắn muốn cập nhật đơn hàng này",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ok'
      }).then(async (result) => {
          if (result.value) {
              await sendData(order).then((result) => {
                toastr.success('Cập nhật thành công');
                $(e).text("Đã cập nhật").removeClass("btn-success").addClass("btn-secondary").attr("disabled", true);
              }).catch(() => {
                toastr.error('Đã xảy ra lỗi');
              });

          }
      });
    }
  }

  function sendData(order) {
    return new Promise((resolve, reject) => {
      $.ajax({
          dataType: 'json',
          url: '<?php Common::getPath() ?>src/controller/orders/OrderController.php',
          data: {
              method: 'update_bill',
              order_id: order.order_id,
              shipping_unit: order.shipping_unit,
              status: order.status,
              bill_no: order.bill_no,
              shipping_fee: order.shipping_fee,
              estimated_delivery: order.estimated_delivery
          },
          type: 'POST',
          success: async function (data) {
              console.log(data);
              resolve();
          },
          error: function (data, errorThrown) {
              console.log(data.responseText);
              console.log(errorThrown);
              reject();
          }
      });
    });
  }

  function getData(order_id) {
    return new Promise((resolve) => {
      if(!order_id) {
        toastr.error('Không tồn tại đơn hàng');
        resolve(false);
        return false;
      }
      let order = null;
      $.each(excelData, (k, v) => {
        if(v.order_id == order_id) {
          order = Object.assign({}, v);
          return false;
        }
      });
      resolve(order);
    })
  }
</script>
</body>
</html>