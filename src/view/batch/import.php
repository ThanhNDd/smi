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
    </style>
  </head>
<?php require_once('../../common/header.php'); ?>
<?php require_once('../../common/menu.php'); ?>
<section class="content p-4">
  <div class="row col-md-12 mb-3">
    <a href="<?php Common::getPath() ?>src/view/orders/online.php" class="btn btn-sm btn-secondary btn-flat p-2">
        <i class="fas fa-backward"></i> Back
    </a>
    <button class="btn btn-danger float-right" onclick="testCreateOrder()" style="border-radius: 4px !important;font-size: 12px;">
        Test
      </button>
  </div>
  <div class="card">
    <div class="card-body">
      <form id="import" method="post" enctype="multipart/form-data" class="d-inline-block">
        <label for="fileToUpload">Select file to upload:</label>
        <input type="file" name="fileToUpload" id="fileToUpload" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
        <button class="btn btn-primary" name="submit" id="submit" disabled style="border-radius: 4px !important;font-size: 12px;">
          <i class="fas fa-upload"></i> Tải lên
        </button>
      </form>
      <button class="btn btn-danger float-right" id="createAll" disabled style="border-radius: 4px !important;font-size: 12px;">
        <div class="spinner-border d-none" id="spinnerCreateAll"></div>
        Tạo tất cả
      </button>
    </div>
  </div>

  <div class="alert alert-success d-none" id="alert">
    Có <span id="orderAvailable">0</span> đơn hàng hợp lệ
  </div>

  <div class="table-responsive">          
    <table class="table table-striped table-hover" id="tabledata">
      <thead class="thead-light">
        <tr>
          <th class="text-center">#</th>
          <th class="text-center">STT</th>
          <th class="text-center">Hành động</th>
          <th>Mã đơn hàng</th>
          <th>Khách hàng</th>
          <th>Số điện thoại</th>
          <th>Địa chỉ</th>
          <th>Phường/Xã</th>
          <th>Quận/Huyện</th>
          <th>Tỉnh/Thành Phố</th>
          <th>Tổng tiền hàng</th>
          <th>Tổng giảm trừ</th>
          <th>Tổng thanh toán</th>
          <th>Sản phẩm</th>
          <th class="text-center">Số lượng</th>
          <th>Mã vận đơn</th>
          <th>Đơn vị vận chuyển</th>
          <th>Ngày đặt hàng</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </div>  
  <div class="modal fade" id="myModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Sửa Đơn Hàng</h4>
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <div class="row col-md-12">
            <div class="form-group col-md-4">
              <label for="phone">Mã đơn hàng:</label>
              <input type="text" disabled class="form-control" id="shopeeOrderId">
            </div>
            <div class="form-group col-md-4">
              <label for="phone">Số điện thoại:</label>
              <input type="text" disabled class="form-control" id="phone">
            </div>
            <div class="form-group col-md-4">
              <label for="name">Họ tên:</label>
              <input type="text" disabled class="form-control" id="name">
            </div>
          </div>
          <div class="row col-md-12">
            <div class="form-group  col-md-12">
              <label>Địa chỉ trên Shopee</label>
              <input type="text" disabled class="form-control" id="addressOnShopee">
            </div>
          </div>
          <div class="row col-md-12">
            <div class="form-group col-md-4">
              <label>Tỉnh / Thành phố <span style="color:red">*</span></label>
              <select class="select-city form-control" id="select_city"></select>
            </div>
            <div class="form-group col-md-4">
              <label>Quận / Huyện <span style="color:red">*</span></label>
              <select class="select-district form-control" id="select_district"></select>
            </div>
            <div class="form-group col-md-4">
              <label>Phường xã <span style="color:red">*</span></label>
              <select class="select-village form-control" id="select_village"></select>
            </div>
          </div>          
          <div class="row col-md-12">
            <div class="form-group  col-md-12">
              <label>Địa chỉ <span style="color:red">*</span></label>
              <input type="text" class="form-control" id="address"
                     placeholder="Nhập số nhà, thôn xóm ... " autocomplete="chrome-off">
            </div>
          </div>
          <div class="row col-md-12">
            <div class="form-group  col-md-12">
              <label>Ghi chú</label>
              <textarea class="form-control" rows="3" id="description" placeholder="Ghi chú đơn hàng"></textarea>
            </div>
          </div>
          <div class="row col-md-12">
            <div class="form-group  col-md-12">
              <button class="btn btn-outline-danger" id="deleteProductNotExist">Xoá sản phẩm không tồn tại</button>
            </div>
          </div>
          <div class="row col-md-12">
            <div class="form-group col-md-12">
              <div class="table-responsive">
                <table class="table table-hover" id="tableProductOrder">
                  <thead>
                    <tr>
                      <!-- <th class="text-center">#</th> -->
                      <th class="text-center">STT</th>
                      <th>Sản phẩm</th>
                      <th class="text-right">Giá bán</th>
                      <th class="text-center">Số lượng</th>
                      <th class="text-right">Giảm giá</th>
                      <th class="text-right">Thành tiền</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                  <tfoot></tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal footer -->
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="updateOrder">Cập nhật</button>
        </div>
        
      </div>
    </div>
  </div>
<div id="data"></div>
</section>

<?php require_once('../../common/footer.php'); ?>
<script>
  let excelData = null;
  let dataAvailable = [];
  $(document).ready(function(){

    $("#createAll").click(async function() {
      let data = await getAvailableData();
      if(data.length == 0) {
        toastr.error('Không có đơn hàng phù hợp');
        return false;
      }
      console.log(JSON.stringify(data));
      $(`#createAll`).attr("disabled", true);
      $(`#spinnerCreateAll`).removeClass("d-none");
      Swal.fire({
        title: "Xác nhận",
        text: `Bạn có chắc chắn muốn tạo ${data.length} đơn hàng này`,
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ok'
      }).then(async (result) => {
          if (result.value) {
            await updateAllOrder(data).then((orderSuccess) => {
              if(orderSuccess == data.length) {
                toastr.success(`Tạo ${orderSuccess} đơn thành công`);
              } 
              if(orderSuccess < data.length) {
                toastr.error(`Tạo ${Number(data.length) - Number(orderSuccess)} đơn không thành công`);
              }
              $(`#spinnerCreateAll`).addClass("d-none");
              $(`#createAll`).removeAttr("disabled"); 
            }).catch(() => {
              toastr.error('Đã xảy ra lỗi');
            });
          } else {
            $(`#spinnerCreateAll`).addClass("d-none");
            $(`#createAll`).removeAttr("disabled"); 
          }
      });
    })

    $("#fileToUpload").change(() => {
      let file_data = $("#fileToUpload").prop('files')[0];
      console.log(file_data.name);
      
      if(file_data) {
        let filename = file_data.name;
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
            url: "<?php Common::getPath() ?>src/controller/batch/ImportController.php",
            type: 'POST',
            data: formData,
            success: async (response) => {
              console.log(response);  
              $("#data").html("");
              let data = JSON.parse(response);
              if(data.length == 0) {
                toastr.error("Không có dữ liệu");
              }
              await sortData(data);
              await generateDataTable().then(() => {
                $("#fileToUpload").val("");
                $("#submit").attr("disabled", true);
              });
              showAlert();
              
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


      $("#updateOrder").click(async (e) => {
        await validateForm().then((is_valid) => {
          console.log("result is_valid: ", is_valid);
          if(is_valid > 0) {
            toastr.error("Đã xảy ra lỗi");
          } else {
            Swal.fire({
              title: "Xác nhận",
              text: "Bạn chắc chắn muốn cập nhật?",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Ok'
            }).then((result) => {
                if (result.value) {
                    updateForm().then(async () => {
                      console.log("update done");
                      console.log("new ExcelData: ", JSON.stringify(excelData));
                      await generateDataTable();
                      showAlert();
                      console.log("generateDataTable done");
                      $("#myModal").modal("hide");
                    });
                }
            });
          }
        });
      });

      $("#deleteProductNotExist").click(() => {
        let shopeeOrderId = $("#shopeeOrderId").val();
        if(shopeeOrderId) {
          Swal.fire({
              title: "Xác nhận",
              text: "Bạn có chắc chắn muốn tạo đơn hàng này",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Ok'
          }).then(async (result) => {
              if (result.value) {
                await deleteProductNotExist(shopeeOrderId);
              }
            });
        } else {
          toastr.error("Đã xảy ra lỗi");
          console.log("shopeeOrderId: ", shopeeOrderId);
        }
        
      });
  
      init_select_city();
      init_select_district();

      // getDataOnServer();

  });



  // function testCreateOrder() {
  //   let conf = confirm("Bạn có chắc chắn muốn tạo đơn hàng này?");
  //   if(conf) {
  //     let order = {"order_id":null,"order_type":1,"source":3,"order_status":13,"wallet":0,"shipping_fee":0,"shipping":0,"payment_type":1,"shopee_order_id":"220518G1D3CRK4","order_date":"2022-05-18 12:34","bill_of_lading_no":"SPXVN027264389455","shipping_unit":"SPXEXPRESS","totalFee":"5613","customer_id":null,"customerName":"Hoàng ngọc anh","customerPhone":"0989877447","cityId":1,"cityName":"Hà Nội","districtId":"007","districtName":"Quận Hai Bà Trưng","villageId":"00244","villageName":"Phường Bạch Đằng","address":"Số 6 Lê Quý Đôn","fullAddress":"Số 6 Lê Quý Đôn, Phường Bạch Đằng, Quận Hai Bà Trưng, Hà Nội","fullAddressShopee":"Số 6 Lê Quý Đôn, Phường Bạch Đằng, Quận Hai Bà Trưng, Hà Nội","isNotExistProduct":0,"quantity":2,"description":"1. Quần bơi,Vàng Đậm,L (17-21kg, 5-7T)\n","discount":"5613","total_reduce":5613,"total_amount":65000,"total_checkout":59387,"products":[{"product_id":"862","product_name":"Quần bơi","reduce":0,"reduce_percent":null,"reduce_type":null,"product_exchange":null,"profit":22560,"sku":"86222","name":"Vàng Đậm,L (17-21kg, 5-7T)","price":65000,"quantity":2}]};
  //     $.ajax({
  //         dataType: 'json',
  //         url: '<?php Common::getPath() ?>src/controller/orders/OrderShopeeController.php',
  //         data: {
  //             method: 'add_new',
  //             data: JSON.stringify(order)
  //         },
  //         type: 'POST',
  //         success: async function (data) {
  //             console.log(data);
  //             resolve();
  //         },
  //         error: function (data, errorThrown) {
  //             console.log(data.responseText);
  //             console.log(errorThrown);
  //             // toastr.error('Đã xảy ra lỗi');
  //             reject();
  //         }
  //     });
  //   }
  // }

  async function showAlert() {
    await getAvailableData().then((result) => {
      if(result.length > 0) {
        $("#createAll").removeAttr("disabled");
        $("#orderAvailable").html(`<strong>${result.length}</strong>/<strong>${excelData.length}</strong>`);
      } else {
        $("#alert").removeClass("alert-success")
          .addClass("alert-warning")
          .html(`<i class="fas fa-exclamation-triangle"></i> Không tồn tại đơn hàng`);
        $("#createAll").attr("disabled", true);
      }
      $("#alert").removeClass("d-none");
    });
  }

  function getAvailableData() {
    return new Promise((resolve) => {
      let data = [];
      $.each(excelData, (k, v) => {
        if(!v.hasOwnProperty('orderError') && !v.hasOwnProperty('existedOrder') && v.isNotExistProduct == 0) {
          let isChecked = $(`#checkbox_${v.shopee_order_id}`).is(":checked");
          if(isChecked) {
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
        await sendData(order).then(async (result) => {
          $(`#order_${order.shopee_order_id}`).removeClass("btn-success").addClass("btn-secondary").attr("disabled", true).text("Đã tạo đơn");
          $(`#spinner_${order.shopee_order_id}`).removeClass("d-none");
          $(`#checkbox_${order.shopee_order_id}`).attr("disabled", true);
          await updateOrderSuccess(data, order.shopee_order_id);
          orderSuccess++;
        });
      });
      resolve(orderSuccess);
    });
  }

  function updateOrderSuccess(shopee_order_id) {
    return new Promise((resolve) => {
      $.each(excelData, (k, v) => {
        if(v.shopee_order_id == shopee_order_id) {
          excelData[k].existedOrder = true;
          return fasle;
        }
      });
      resolve();
    })
  }

  function updateForm() {
    return new Promise((resolve) => {
      let cityId = $("#select_city").val();
      let cityName = $( "#select_city option:selected" ).text();
      let districtId = $("#select_district").val();
      let districtName = $( "#select_district option:selected" ).text();
      let villageId = $("#select_village").val();
      let villageName = $( "#select_village option:selected" ).text();
      let address = $("#address").val();
      let products = [];
      $("#tableProductOrder tbody tr").each(function () {
        let sku = $(this).attr("id");
        if (sku) {
            let price = $(`#price_${sku}`).text();
            price = price.replace("₫","");
            price = Number(replaceComma(price));
            let profit = $(`#profit_${sku}`).val();
            profit = Number(replaceComma(profit));
            let quantity = $(`#quantity_${sku}`).text();
            let reduce = $(`#reduce_${sku}`).text();
            reduce = reduce.replace("₫","");
            reduce = Number(replaceComma(reduce));
            let reduce_type = 0;
            let reduce_percent = "";
            if(reduce > 0) {
                if (reduce < 101) {
                    reduce_percent = reduce;
                    reduce = (reduce * price) / 100;
                    reduce_type = 0;
                } else {
                    reduce_percent = Math.round(reduce * 100 / (price * quantity));
                    reduce_type = 1;
                }
            }
            let product = {};
            product["product_id"] = 0;
            product["variant_id"] = 0;
            product["sku"] = $("[id=sku_" + sku + "]").val();
            product["product_name"] = $("[id=product_name_" + sku + "]").text();
            product["name"] = $("[id=variant_name_" + sku + "]").text();
            product["price"] = price;
            product["quantity"] = quantity;
            product["reduce"] = reduce;
            product["reduce_percent"] = reduce_percent;
            product["reduce_type"] = reduce_type;
            product["product_exchange"] = 0;
            product["profit"] = profit;
            products.push(product);
        }
      });
      console.log("products: ",JSON.stringify(products));
      let description = $("#description").val();
      let shopeeOrderId = $("#shopeeOrderId").val();
      // console.log("excelData: ",JSON.stringify(excelData));
      $.each(excelData, (k, v) => {
        if(shopeeOrderId == v.shopee_order_id) {
          excelData[k]["cityId"] = cityId;
          excelData[k]["cityName"] = cityName;
          excelData[k]["districtId"] = districtId;
          excelData[k]["districtName"] = districtName;
          excelData[k]["villageId"] = villageId;
          excelData[k]["villageName"] = villageName;
          excelData[k]["address"] = address;
          excelData[k]["fullAddress"] = `${address},${villageName},${districtName},${cityName}`;
          excelData[k]["description"] = description;
          delete excelData[k].orderError;
          excelData[k]["isNotExistProduct"] = 0;
          excelData[k]["products"] = products;
        }
      });
      resolve();
    }); 
  }

  function validateForm() {
    return new Promise((resolve) => {
      $(".modal-body").find("input").removeClass("is-invalid");
      $(".modal-body").find("select").removeClass("is-invalid");
      let is_valid = 0;
      let cityId = $("#select_city").val();
      // let cityName = $( "#select_city option:selected" ).text();
      if (!cityId || cityId === "-1") {
          $(".select-city").addClass("is-invalid");
          is_valid++;
      } else {
          $(".select-city").removeClass("is-invalid");
      }
      let districtId = $("#select_district").val();
      // let districtName = $( "#select_district option:selected" ).text();
      if (!districtId || districtId === "-1") {
          $(".select-district").addClass("is-invalid");
          is_valid++;
      } else {
          $(".select-district").removeClass("is-invalid");
      }
      let villageId = $("#select_village").val();
      if (!villageId || villageId === "-1") {
          $(".select-village").addClass("is-invalid");
          is_valid++;
      } else {
          $(".select-village").removeClass("is-invalid");
      }
      let address = $("#address").val();
      
      if (!address) {
          $("#address").addClass("is-invalid");
          is_valid++;
      } else {
          $("#address").removeClass("is-invalid");
      }
      let numberProduct = 0;
      let products = [];
      $("#tableProductOrder tbody tr").each(function () {
        let sku = $(this).attr("id");
        if (sku && sku != 'null') {
            numberProduct++;
        }
      });

      if(numberProduct == 0) {
        toastr.error("Không tồn tại sản phẩm");
        is_valid++;
      }
      resolve(is_valid);
    });
  }


  function sortData(data) {
    return new Promise((resolve) => {
      let orderError = [];
      let existedOrder = [];
      let availableOrder = [];
      $.each(data, (k,v) => {
        if(v.hasOwnProperty('orderError')) {
          orderError.push(v);
        } else if(v.hasOwnProperty('existedOrder')) {
          existedOrder.push(v);
        } else {
          availableOrder.push(v);
        }
      });
      excelData = [];
      $.each(orderError, (k,v) => {
        excelData.push(v);
      });
      $.each(availableOrder, (k,v) => {
        excelData.push(v);
      });
      $.each(existedOrder, (k,v) => {
        excelData.push(v);
      });
      resolve();
    });
  }
  

  function generateDataTable() {
    return new Promise((resolve) => {
      $("#tabledata tbody").html("");
      let index = 1;
      console.log("excelData generateDataTable: ",JSON.stringify(excelData));
      $.each(excelData, function(k, v){
        if(!v.hasOwnProperty('orderError') && !v.hasOwnProperty('existedOrder') && v.isNotExistProduct == 0) {
          dataAvailable.push(v);
        }
        let content = `<tr>`;
            content += `<td><input id="checkbox_${v.shopee_order_id}" type="checkbox" ${!v.hasOwnProperty('orderError') && !v.hasOwnProperty('existedOrder') && v.isNotExistProduct == 0 ? 'checked' : 'disabled'}/></td>`;
            content += `<td>${index}</td>`;
            content += `<td align="center">`;
            if(v.hasOwnProperty('existedOrder')) {
              content += `<button class="btn btn-secondary" disabled style="border-radius: 4px !important;font-size: 12px;">Đã tạo đơn</button>`;
            } else {
              content += `<button class="btn ${v.hasOwnProperty('orderError') || v.isNotExistProduct > 0 ? 'btn-secondary' : 'btn-success' }" id="order_${v.shopee_order_id}" 
                            ${v.hasOwnProperty('orderError') || v.isNotExistProduct > 0 ? 'disabled' : ''}
                            onclick="createOrder(this, '${v.shopee_order_id}')" 
                            style="border-radius: 4px !important;font-size: 12px;">
                            <div class="spinner-border d-none" id="spinner_${v.shopee_order_id}"></div>
                            Tạo đơn này
                          </button>
                          <small class="text-danger ${v.hasOwnProperty('orderError') ? 'd-block' : 'd-none'}" >Đơn hàng có lỗi</small>
                          <small class="text-danger ${v.isNotExistProduct > 0 ? 'd-block' : 'd-none'}" >Có ${v.isNotExistProduct} sản phẩm không tồn tại</small>`;
            }
            content += `</td>`;
            content += `<td><a href="javascript:void(0)" class="td_${v.shopee_order_id}">${v.shopee_order_id}</a></td>`;
            content += `<td>${v.customerName}</td>`;
            content += `<td>${v.customerPhone}</td>`;
            content += `<td>${v.address}</td>`;
            content += `<td><span class="${v.villageId ? '' : 'text-danger'}">${v.villageName}</span></td>`;
            content += `<td><span class="${v.districtId ? '' : 'text-danger'}">${v.districtName}</span></td>`;
            content += `<td><span class="${v.cityId ? '' : 'text-danger'}">${v.cityName}</span></td>`;
            content += `<td>${formatNumber(v.total_amount)}</td>`;
            content += `<td>${formatNumber(v.total_reduce)}</td>`;
            content += `<td>${formatNumber(v.total_checkout)}</td>`;
            content += `<td><p style="white-space: pre">${v.description}</p></td>`;
            content += `<td>${v.quantity}</td>`;
            content += `<td>${v.bill_of_lading_no}</td>`;
            content += `<td>${v.shippingUnit}</td>`;
            content += `<td>${v.order_date}</td>`;
            content += `</tr>`;
        $("#tabledata tbody").append(content);
        $(`.td_${v.shopee_order_id}`).click(async (e) => {
          console.log(JSON.stringify(v));
          if(v.hasOwnProperty('existedOrder')) {
            return false;
          }
            
            $("#shopeeOrderId").val(`${v.shopee_order_id}`);
            $("#name").val(`${v.customerName}`);
            $("#phone").val(`${v.customerPhone}`);
            $("#addressOnShopee").val(`${v.fullAddressShopee}`);
            await generate_select2_city(v.cityId)
            await generate_select2_district(v.cityId, v.districtId);
            await generate_select2_village(v.districtId, v.villageId);
            $("#address").val(`${v.address}`);
            $("#description").val(`${v.description}`);
            await generateProductTable(v);
          $("#myModal").modal({backdrop: "static"});
        });
        index++;
      }); 
      resolve();
    });
  }

  function generateProductTable(v) {
    return new Promise((resolve) => {
      $("#tableProductOrder tbody").html("");
      let i = 1;
      $.each(v.products, (key, variant) => {
        let data = `<tr id="${variant.sku}">`;
            data += `<td class="d-none"><input type="hidden" id="product_id_${variant.sku}" value="${variant.product_id}"></td>`;
            data += `<td class="d-none"><input type="hidden" id="variant_id_${variant.sku}" value="${variant.variant_id}"></td>`;
            data += `<td class="d-none"><input type="hidden" id="sku_${variant.sku}" value="${variant.sku}"></td>`;
            data += `<td class="d-none"><input type="hidden" id="profit_${variant.sku}" value="${variant.profit}"></td>`;
            // data += `<td class="text-center">${variant.product_id ? '' : '<span class="text-danger c-pointer">Xoá</span>'}</td>`;
            data += `<td class="text-center">${i}</td>`;
            data += `<td>
                      <p class="m-0" id="product_name_${variant.sku}">${variant.product_name ? "<span>"+variant.product_name+"</span>" : '<span class="text-danger">Không tồn tại sản phẩm</span>' }</p>
                      <p class="m-0 text-primary" id="variant_name_${variant.sku}"><small>${variant.name}</small></p>
                    </td>`;
            data += `<td class="text-right" id="price_${variant.sku}">${formatNumber(variant.price)}&#8363;</td>`;
            data += `<td class="text-center" id="quantity_${variant.sku}">${variant.quantity}</td>`;
            data += `<td class="text-right" id="reduce_${variant.sku}">${formatNumber(variant.reduce)}&#8363;</td>`;
            data += `<td class="text-right">${formatNumber((Number(variant.price) - Number(variant.reduce)) * Number(variant.quantity))}&#8363;</td>`;
            data += `<tr>`;
        $("#tableProductOrder tbody").append(data);
        i++;
      });
      let tfoot =  `<tr>
                      <td colspan="5" class="text-right">Tổng tiền hàng</td>
                      <td><h6 class="text-right m-0" id="total_amount_${v.shopee_order_id}" data="${v.total_amount}">${formatNumber(v.total_amount)}&#8363;</h6></td>
                    </tr>`;
          tfoot +=  `<tr>
                      <td colspan="5" class="text-right">Phí shopee</td>
                      <td><h6 class="text-right m-0" id="discount_${v.shopee_order_id}" data="${v.discount}">${formatNumber(v.discount)}&#8363;</h6></td>
                    </tr>`;
          tfoot +=  `<tr>
                      <td colspan="5" class="text-right">Tổng giảm trừ</td>
                      <td><h6 class="text-right m-0" id="total_reduce_${v.shopee_order_id}" data="${v.total_reduce}">${formatNumber(v.total_reduce)}&#8363;</h6></td>
                    </tr>`;
          tfoot +=  `<tr>
                      <td colspan="5" class="text-right">Tổng thanh toán</td>
                      <td><h4 class="text-right text-danger" id="total_checkout_${v.shopee_order_id}" data="${v.total_checkout}">${formatNumber(v.total_checkout)}&#8363;</h4></td>
                    </tr>`; 
      $("#tableProductOrder tfoot").html(tfoot);                   
      resolve();
    });
  }


  function deleteProductNotExist(shopee_order_id) {
    return new Promise((resolve) => {
      $.each(excelData, (k,v) => {
        if(v.shopee_order_id == shopee_order_id) {
          const filteredItems = v.products.filter(item => item.product_id)
          excelData[k]["products"] = filteredItems;
          generateProductTable(excelData[k]);
        }
      });
      resolve();
    });
  }

  async function createOrder(e, orderId) {
    let order = await getData(orderId);
    console.log(JSON.stringify(order)); 
    Swal.fire({
        title: "Xác nhận",
        text: "Bạn có chắc chắn muốn tạo đơn hàng này",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ok'
    }).then(async (result) => {
        if (result.value) {
            await sendData(order).then((result) => {
              updateExcelData(orderId);
              toastr.success('Tạo đơn hàng thành công');
              $(e).text("Đã tạo đơn").removeClass("btn-success").addClass("btn-secondary").attr("disabled", true);
            }).catch(() => {
              toastr.error('Đã xảy ra lỗi');
            });

        }
    });
  }


  

  function sendData(order) {
    return new Promise((resolve, reject) => {
      $.ajax({
          dataType: 'json',
          url: '<?php Common::getPath() ?>src/controller/orders/OrderController.php',
          data: {
              method: 'add_new',
              data: JSON.stringify(order)
          },
          type: 'POST',
          success: async function (data) {
              console.log(data);
              resolve();
          },
          error: function (data, errorThrown) {
              console.log(data.responseText);
              console.log(errorThrown);
              // toastr.error('Đã xảy ra lỗi');
              reject();
          }
      });
    });
  }

  function updateExcelData(orderId) {
    $.each(excelData, (k, v) => {
      if(v.shopee_order_id == orderId) {
        excelData.splice(v, 1);
        return false;
      }
    });
    console.log("updateExcelData excelData.length: ", excelData.length);
    if(excelData && excelData.length > 0) {
      $("#createAll").removeAttr("disabled");
    } else {
      $("#createAll").attr("disabled", true);
    };
  }

  function getData(orderId) {
    return new Promise((resolve) => {
      if(!orderId) {
        toastr.error('Không tồn tại đơn hàng');
        resolve(false);
        return false;
      }
      let order = null;
      $.each(excelData, (k, v) => {
        if(v.shopee_order_id == orderId) {
          order = Object.assign({}, v);
          return false;
        }
      });
      resolve(order);
    })
  }

  function init_select_city() {
      $('.select-city').on('select2:select', function (e) {
          let data = e.params.data;
          let cityId = data.id;
          generate_select2_district(cityId);
      });
  }

  function init_select_district() {
      $('.select-district').on('select2:select', function (e) {
          let data = e.params.data;
          let districtId = data.id;
          generate_select2_village(districtId);
      });
  }   
</script>
</body>
</html>