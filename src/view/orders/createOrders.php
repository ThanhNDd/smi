<?php require_once("../../common/constants.php") ?>
<div class="modal fade" id="create-order">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="overlay d-flex justify-content-center align-items-center">
          <i class="fas fa-2x fa-sync fa-spin"></i>
      </div>
      <div class="modal-header">
        <h4 class="modal-title">Tạo mới đơn hàng Online</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <div class="row">
              <div class="col-4">
                <label>Mã vận đơn</label>
                <input type="text" class="form-control" id="bill_of_lading_no" placeholder="Mã vận đơn" autocomplete="off">
              </div>
              <div class="col-4">
                <label>Phí ship (trả cho đơn vị vận chuyển)</label>
                <input type="text" class="form-control" id="shipping_fee" placeholder="Phí ship trả cho đơn vị vận chuyển" autocomplete="off">
              </div>
              <div class="col-4">
                <label>Đơn vị vận chuyển</label>
                <select class="select-shipping-unit form-control">
                  <option value="Viettel Post" selected="selected">Viettel Post</option>
                </select>
              </div>
              <div class="col-4">
                <label>Họ tên <span style="color:red">*</span></label>
                <input type="text" class="form-control" id="customerName" placeholder="Họ tên" autocomplete="off">
              </div>
              <div class="col-4">
                <label>Số điện thoại</label>
                <input type="number" class="form-control" id="phoneNumber" placeholder="Nhập số điện thoại" min="0">
              </div>
              <div class="col-4">
                <label>Email</label>
                <input type="text" class="form-control" id="email" placeholder="Email" autocomplete="off">
              </div>
              <div class="col-4">
                <label>Tỉnh / Thành phố</label>
                <select class="select-city form-control">
                  <option value="">Lựa chọn</option>
                </select>
              </div>
              <div class="col-4">
                <label>Quận / Huyện</label>
                <select class="select-district form-control">
                  <option value="">Lựa chọn</option>
                </select>
              </div>
              <div class="col-4">
                <label>Phường xã</label>
                <select class="select-village form-control">
                  <option value="">Lựa chọn</option>
                </select>
              </div>
              <div class="col-8">
                <label>Địa chỉ</label>
                <input type="text" class="form-control" id="address" placeholder="Nhập số nhà, thôn xóm ... " autocomplete="off">
              </div>
            </div>
          </div>
           <div class="form-group">
              <input type="hidden" value="0" class="count-row" />
              <div class="row product">
                <div class="col-2">
                  <label>Mã sản phẩm</label>
                  <!-- <select class="select-product form-control" id="prod_1" onchange="on_change_product('prod_1')"></select> -->
                  <!-- <input type="text" class="form-control" id="prod_1" placeholder="Nhập mã sản phẩm" onchange="on_change_product_2(this, 1)"> -->
                </div>
                <div class="col-4">
                  <label for="product_name_1">Tên sản phẩm</label>
                  <!-- <input type="text" class="form-control" id="product_name_1" disabled="disabled"> -->
                </div>
                <input type="hidden" id="variantId_1">
                <div class="col-2">
                  <label>Đơn giá</label>
                  <!-- <input type="text" autocomplete="off" class="form-control right" id="prodPrice_1" placeholder="0" disabled="disabled"  onchange="on_change_qty('prodQty_1', 'prodPrice_1', 'prodTotal_1')"> -->
                </div>
                <div class="col-1">
                  <label>Số lượng</label>
                  <!-- <input type="number" autocomplete="off" class="form-control center" id="prodQty_1" placeholder="1" min="1" disabled="disabled" onchange="on_change_qty('prodQty_1', 'prodPrice_1', 'prodTotal_1')"> -->
                </div>
                <div class="col-2">
                  <label>Tổng</label>
                  <!-- <input type="text" autocomplete="off" class="form-control right" id="prodTotal_1" placeholder="0" min="0" disabled="disabled"> -->
                </div>
                <div class="col-1 center">
                  <label>Chọn</label>
                  <!-- <button type="button" class="btn btn-success form-control add-new-prod" title="Thêm sản phẩm">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                  </button> -->
                </div>
              </div>
              <div class="form-group product-area">
                
              </div>
            </div>
            
            <div class="form-group total-area">
              <div class="row pd-t-5">
                <div class="col-9 right pd-t-10">
                  <label class="pd-t-5">Tổng tiền hàng</label>
                </div>
                <div class="col-2 right pd-t-10">
                  <label id="total_amount">0</label>
                </div>
              </div>
              <div class="row pd-t-5">
                <div class="col-9 right pd-t-10">
                  <label>Phí ship (KH trả)</label>
                </div>
                <div class="col-2 right pd-t-5">
                  <input type="text" class="form-control" id="shipping" placeholder="Phí ship" autocomplete="off">
                </div>
              </div>
              <div class="row pd-t-5">
                <div class="col-9 right pd-t-10">
                  <label>Giảm trừ</label>
                </div>
                <div class="col-2 right pd-t-5">
                  <input type="text" class="form-control" id="discount" placeholder="Giảm trừ" autocomplete="off">
                </div>
              </div>
              <div class="row pd-t-5">
                <div class="col-9 right pd-t-10">
                  <label>Tổng thanh toán</label>
                </div>
                <div class="col-2 right pd-t-5">
                  <label style="font-size: 23px;color: red;" id="total_checkout">0</label>
                </div>
              </div>
            </div>  
        </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary create-new" >Tạo mới</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
  <?php include __PATH__.'src/common/js.php'; ?>
  <script>
    var data_products;
    var flagError = 0;
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });
    $(document).ready(function () {
      $('.order-create').click(function(){
        reset_data();
        add_new_product();
        open_modal();
      });
      $('.order-update').click(function(){
        update_data();
      });

      $('.select-city').on('select2:select', function (e) {
          var data = e.params.data;
          var cityId = data.id;
          generate_select2_district(cityId);
      });
      $('.select-district').on('select2:select', function (e) {
          var data = e.params.data;
          var districtId = data.id;
          generate_select2_village(districtId);
      });
      
      $('.create-new').click(function(){
        create_new();
      });
      $("#shipping").change(function(){
        var e = this;
        var val = $(e).val();
        val = replaceComma(val);
        if(isNaN(val)) {
          $(e).addClass("is-invalid");  
        } else {
          $(e).removeClass("is-invalid");
          if(val < 1000)
          {
            if(val.indexOf(".") > 0)
            {
              val = val.replace(".","");
              val = val+"00";
            } else {
              val = val+"000";  
            }
          }
          val = Number(val);
          $(e).val(formatNumber(val));  
          on_change_total();
        }
      });
      $("#discount").change(function(){
        var e = this;
        var val = $(e).val();
        val = replaceComma(val);
        if(isNaN(val)) {
          $(e).addClass("is-invalid");  
        } else {
          $(e).removeClass("is-invalid");
          if(val < 1000)
          {
            if(val.indexOf(".") > 0)
            {
              val = val.replace(".","");
              val = val+"00";
            } else {
              val = val+"000";  
            }
          }
          val = Number(val);
          $(e).val(formatNumber(val));  
          on_change_total();
        }
      });
      $("#email").change(function(){
        var val = $(this).val();
        if(val != "" && !validateEmail(val))
        {
          $(this).addClass("is-invalid");
        } else {
          $(this).removeClass("is-invalid");
        }
      });
      $("#shipping_fee").change(function(){
        var e = this;
        var val = $(e).val();
        val = replaceComma(val);
        if(isNaN(val)) {
          $(e).addClass("is-invalid");  
        } else {
          $(e).removeClass("is-invalid");
          if(val < 1000)
          {
            if(val.indexOf(".") > 0)
            {
              val = val.replace(".","");
              val = val+"00";
            } else {
              val = val+"000";  
            }
          }
          val = Number(val);
          $(e).val(formatNumber(val));  
        }
      });
    });
    
    function validate() {
      var count_error = 0;
      var customerName = $("#customerName").val();
      if(customerName === "")
      {
        $("#customerName").addClass("is-invalid");
        // return false;
        count_error++;
      } else {
        $("#customerName").removeClass("is-invalid");
      }
      var phoneNumber = $("#phoneNumber").val();
      if(phoneNumber === "")
      {
        $("#phoneNumber").addClass("is-invalid");
        // return false;
        count_error++;
      } else {
        $("#phoneNumber").removeClass("is-invalid");
      }
      var cityId = $(".select-city").val();
      if(cityId === "")
      {
        $(".select-city").addClass("is-invalid");
        // return false;
        count_error++;
      } else {
        $(".select-city").removeClass("is-invalid");
        var districtId = $(".select-district").val();
        if(districtId === "")
        {
          $(".select-district").addClass("is-invalid");
          // return false;
          count_error++;
        } else {
          $(".select-district").removeClass("is-invalid");
          var villageId = $(".select-village").val();
          if(villageId === "")
          {
            $(".select-village").addClass("is-invalid");
            // return false;
            count_error++;
          } else {
            $(".select-village").removeClass("is-invalid");
            var add = $("#address").val();
            if(add === "")
            {
              $("#address").addClass("is-invalid");
              // return false;
              count_error++;
            } else {
              $("#address").removeClass("is-invalid");
            }
          }
          
        }
        
      }
      
      // var rowProductNumber = $(".count-row").val();
      // for(var i=1; i<=rowProductNumber.length; i++)
      // {
      //   var sku = $("#sku_"+i).val();
      //   if(sku !== "") {
      //     var prodId = $("#prod_"+i).val();
      //     if(prodId === "-1") {
      //       $("#prod_"+i).addClass("is-invalid");
      //       // return false;
      //       count_error++;
      //     } else {
      //       $("#prod_"+i).removeClass("is-invalid");
      //       var qty = $("#prodQty_"+i).val();
      //       if(qty === "")
      //       {
      //         $("#prodQty_"+i).addClass("is-invalid");
      //         // return false;
      //         count_error++;
      //       } else {
      //         $("#prodQty_"+i).removeClass("is-invalid");
      //       }  
      //     }
      //   } else {
      //     $("#sku_"+i).addClass("is-invalid");
      //     return;
      //   }
      // }
      if(count_error > 0)
      {
        return false;
      }
      return true; 
    }

    function create_new()
    {
      if(!validate())
      {
        return;
      }
      var data = {};
      data["bill_of_lading_no"] = $("#bill_of_lading_no").val();
      data["shipping_fee"] = replaceComma($("#shipping_fee").val());
      data["shipping_unit"] = $(".select-shipping-unit").val();
      data["customerName"] = $("#customerName").val();
      data["phoneNumber"] = $("#phoneNumber").val();
      data["email"] = $("#email").val();
      data["cityId"] = $(".select-city").val();
      data["districtId"] = $(".select-district").val();
      data["villageId"] = $(".select-village").val();
      data["address"] = $("#address").val();
      data["shipping"] = replaceComma($("#shipping").val());
      data["discount"] = replaceComma($("#discount").val());
      data["total_amount"] = replaceComma($("#total_amount").text());
      data["total_checkout"] = replaceComma($("#total_checkout").text());
      var rowProductNumber = $(".count-row").val();

      var products = [];
      for(var i=1; i<=rowProductNumber.length; i++)
      {
        var product = {};
        var prodId = $("#prod_"+i).val();
        if(prodId !== "") {
          product["product_id"] = $("#prod_"+i).val();  
        }
        var variantId = $("#variantId_"+i).val();
        if(variantId !== "")
        {
          product["variant_id"] = $("#variantId_"+i).val();   
        }
        var sku = $("#sku_"+i).val();
        if(sku !== "")
        {
          product["sku"] = $("#sku_"+i).val();   
        }
        var qty = $("#prodQty_"+i).val();
        if(qty !== "")
        {
          product["quantity"] = $("#prodQty_"+i).val();  
        }
        var price = $("#prodPrice_"+i).val();
        if(price !== "")
        {
          product["price"] = replaceComma($("#prodPrice_"+i).val());  
        }
        products.push(product);
      }
      data["products"] = products;
      console.log(JSON.stringify(data));
      Swal.fire({
        title: 'Bạn có chắc chắn muốn tạo đơn hàng này?',
        text: "",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ok'
      }).then((result) => {
        if (result.value) {
          $("#create-order .overlay").removeClass("hidden");
          $.ajax({
            dataType : 'json',
            url      : '<?php echo __PATH__.'src/controller/orders/OrderController.php' ?>',
            data : {
              orders : 'new',
              data : JSON.stringify(data)
            },
            type : 'POST',
            success: function(data)
            {
              console.log(data);
              // var orderId = data.id;
              Swal.fire(
                'Thành công!',
                'Đơn hàng đã được tạo thành công.',
                'success'
              ).then((result) => {
                  if (result.value) {
                    reset_data();
                    $("#create-order .close").click();
                    $("#create-order .overlay").addClass("hidden");
                    window.location.reload();
                  }
              });
            },
            error : function (data, errorThrown) {
              console.log(data.responseText);
              console.log(errorThrown);
              Swal.fire({
                type: 'error',
                title: 'Đã xảy ra lỗi',
                text: "Vui lòng liên hệ quản trị hệ thống để khắc phục"
              })
              $("#create-order .overlay").addClass("hidden");
            }
          });
          
        }
      })
    }
    function reset_data()
    {
      $("#bill_of_lading_no").val("");
      $("#shipping_fee").val("");
      $(".select-shipping-unit").val(-1).trigger("change");
      $("#customerName").val("");
      $("#phoneNumber").val("");
      $("#email").val("");
      $(".select-city").val(-1).trigger("change");
      $(".select-district").val(-1).trigger("change");
      $(".select-village").val(-1).trigger("change");
      $("#address").val("");
      $("#shipping").val("");
      $("#discount").val("");
      $("#total_amount").text("");
      $("#total_checkout").text("");
      $(".product-area").html("");
    }
    function add_new_product()
    {
      var noRow = $('.count-row').val();
      noRow = Number(noRow) + 1;
      $('.count-row').val(noRow);
      var content = '<div class="row" id="product-'+noRow+'" style="padding-top: 10px;">' +
                    '<div class="col-2">' +
                    // '<select class="select-product-'+noRow+' form-control" id="prod_'+noRow+'" onchange="on_change_product(\'prod_'+noRow+'\')"></select>' +
                    '<input type="hidden" class="form-control" id="prod_'+noRow+'">' +
                    '<input type="text" class="form-control" id="sku_'+noRow+'" placeholder="Nhập mã sản phẩm" onchange="on_change_product_2(this, '+noRow+')">' +
                    '</div>' +
                    '<div class="col-4">' +
                    '<input type="text" class="form-control" id="product_name_'+noRow+'" disabled="disabled">' +
                    '</div>' +
                    '<input type="hidden" id="variantId_'+noRow+'">' +
                    '<div class="col-2">' +
                    '<input type="text" class="form-control" id="prodPrice_'+noRow+'" placeholder="0" disabled="disabled" onchange="on_change_qty(\'prodQty_'+noRow+'\', \'prodPrice_'+noRow+'\', \'prodTotal_'+noRow+'\')">' +
                    '</div><div class="col-1">' +
                    '<input type="number" class="form-control" id="prodQty_'+noRow+'" placeholder="0" disabled="disabled"  min="0" onchange="on_change_qty(\'prodQty_'+noRow+'\', \'prodPrice_'+noRow+'\', \'prodTotal_'+noRow+'\')">' +
                    '</div>' +
                    '<div class="col-2">' + 
                    '<input type="text" class="form-control" id="prodTotal_'+noRow+'" placeholder="0" min="0" disabled="disabled">' +
                    '</div>' +
                    '<div class="col-1">';
                    if(noRow == 1) {
                      content += '<button type="button" class="btn btn-success form-control add-new-prod" title="Thêm sản phẩm" onclick="add_new_product();">' +
                                  '<i class="fa fa-plus-circle" aria-hidden="true"></i>' +
                                  '</button>';
                    } else {
                      content += '<button type="button" class="btn btn-danger form-control" onclick="del_product(this, \'product-'+noRow+'\')" title="Xóa sản phẩm">' +
                                  '<i class="fa fa-minus-circle" aria-hidden="true"></i>' +
                                  '</button>';
                    }
                    
                    // '</div>' +
                    content += '</div></div>';
      $(".product-area").append(content);
      // generate_select2_products('.select-product-'+noRow);
    }

    function on_change_total()
    {
      var total_amount = 0;
      var rowProductNumber = $(".count-row").val();
      for(var i=1; i<=rowProductNumber; i++)
      {
        var prodTotal = $("#prodTotal_"+i).val();
        if(prodTotal !== "")
        {
          prodTotal = Number(replaceComma(prodTotal));
          total_amount += prodTotal;
        }
      }
      $("#total_amount").text(formatNumber(total_amount));
      var shipping = $("#shipping").val();
      if(shipping !== "")
      {
        shipping  = Number(replaceComma(shipping));
      }
      var discount = $("#discount").val();
      if(discount !== "")
      {
        discount  = Number(replaceComma(discount));
      }
      var total_checkout = total_amount + shipping - discount;
      $("#total_checkout").text(formatNumber(total_checkout));
    }

    function on_change_qty(qtyId, priceId, totalId)
    {
      var qty = $("[id="+qtyId+"]").val();
      var price = $("[id="+priceId+"]").val();
      var total = Number(qty)*Number(replaceComma(price));
      if(total > 0) {
        $("[id="+totalId+"]").val(formatNumber(total)); 
      } else
      {
        $("[id="+totalId+"]").val(0);
      }
      $("[id="+totalId+"]").trigger("change");
      on_change_total();
    }

    function formatNumber(num) {
      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    }
    function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }
    function replaceComma(value)
    {
      return value.replace(/,/g, '');
    } 

    function on_change_product_2(e, rowIndex) 
    {
      var val = $(e).val();
      var priceId = "prodPrice_"+rowIndex;
      var productName = "product_name_"+rowIndex;
      var prodQty = "prodQty_"+rowIndex;
      var variantId = "variantId_"+rowIndex;
      var totalId = "totalId_"+rowIndex;
      $(e).removeClass("is-invalid");
      $.ajax({
        dataType : "json",
          url      : "<?php echo __PATH__.'src/controller/orders/OrderController.php' ?>",
          data : {
            method : 'find_product_by_sku',
            sku : val
          },
          type : 'POST',
          success: function(data)
          {
            console.log(data);
            if(data.length > 0) {
              $.each(data, function(k, v){
                var name = v.name +" - "+ v.size + " - " + v.color;
                $("[id=prod_"+rowIndex+"]").val(v.product_id);
                $("[id=sku_"+rowIndex+"]").val(v.sku);
                $("[id="+productName+"]").val(name);
                $("[id="+priceId+"]").val(v.retail);
                $("[id="+variantId+"]").val(v.variant_id);
                if(v.retail.replace(",","") > 0) {
                  $("[id="+prodQty+"]").val(1);
                  $("[id="+prodQty+"]").removeAttr("disabled");
                } else {
                  $("[id="+prodQty+"]").val(0);
                  $("[id="+prodQty+"]").attr("disabled", "disabled");
                }
                $("[id="+prodQty+"]").trigger("change");
                on_change_total(); 
              });
            } else {
              $(e).addClass("is-invalid");
            }
          },
          error : function (data, errorThrown) {
            console.log(data.responseText);
            console.log(errorThrown);
            $(e).addClass("is-invalid");
          }
      });
    }

    function on_change_product(prodId)
    {
      var no = prodId.split("_");
      var priceId = "prodPrice_"+no[1];
      var prodQty = "prodQty_"+no[1];
      var variantId = "variantId_"+no[1];
      var totalId = "totalId_"+no[1];
      $("[id='"+prodId+"']").on('select2:select', function (e) {
          var data = e.params.data;
          $("[id="+priceId+"]").val(data.price);
          $("[id="+variantId+"]").val(data.variant_id);
          if(data.price.replace(",","") > 0) {
            $("[id="+prodQty+"]").val(1);
            $("[id="+prodQty+"]").removeAttr("disabled");
          } else {
            $("[id="+prodQty+"]").val(0);
            $("[id="+prodQty+"]").attr("disabled", "disabled");
          }
          $("[id="+prodQty+"]").trigger("change");
          // $("[id="+totalId+"]").trigger("change");
          on_change_total(); 
      });
    }

    function del_product(e, p)
    {
      Swal.fire({
        title: 'Bạn có chắc chắn muốn xóa sản phẩm này?',
        text: "",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ok'
      }).then((result) => {
        if (result.value) {
          $(e).closest("[id='"+p+"']").remove();  
          Swal.fire(
            'Xóa thành công!',
            'Sản phẩm đã được xóa.',
            'success'
          )
        }
      })
      
    }

    function open_modal() {
        // generate_select2_products('.select-product');
        generate_select2_city();
        $('#create-order').modal({
          backdrop : 'static',
          keyboard : false,
          show: true
        }); 
    }

    function generate_select2_city()
    {
      $("#create-order .overlay").removeClass("hidden");
      $.ajax({
          dataType : "json",
          url      : "<?php echo __PATH__.'src/controller/orders/OrderController.php' ?>",
          data : {
            orders : 'loadDataCity'
          },
          type : 'GET',
          success: function(data)
          {
            $('.select-city').select2({
              placeholder: {
                id: '-1', // the value of the option
                text: 'Select an option'
              },
              data: data.results,
              theme: 'bootstrap4',
            });        
            $("#create-order .overlay").addClass("hidden");
          },
          error : function (data, errorThrown) {
            console.log(data.responseText);
            console.log(errorThrown);
            $("#create-order .overlay").addClass("hidden");
          }
      });
    }

    function generate_select2_district(cityId)
    {
      $("#create-order .overlay").removeClass("hidden");
      $('.select-district').empty();
      $.ajax({
          dataType : "json",
          url      : "<?php echo __PATH__.'src/controller/orders/OrderController.php' ?>",
          data : {
            orders : 'loadDataDistrict',
            cityId : cityId
          },
          type : 'GET',
          success: function(data)
          {
            $('.select-district').select2({
              placeholder: {
                id: '-1', // the value of the option
                text: 'Select an option'
              },
              data: data.results,
              theme: 'bootstrap4',
            });        
            $("#create-order .overlay").addClass("hidden");
          },
          error : function (data, errorThrown) {
            console.log(data.responseText);
            console.log(errorThrown);
            $("#create-order .overlay").addClass("hidden");
          }
      });
    }

    function generate_select2_village(districtId)
    {
      $("#create-order .overlay").removeClass("hidden");
      $('.select-village').empty();
      $.ajax({
          dataType : "json",
          url      : "<?php echo __PATH__.'src/controller/orders/OrderController.php' ?>",
          data : {
            orders : 'loadDataVillage',
            districtId : districtId
          },
          type : 'GET',
          success: function(data)
          {
            $('.select-village').select2({
              placeholder: {
                id: '-1', // the value of the option
                text: 'Select an option'
              },
              data: data.results,
              theme: 'bootstrap4',
            });        
            $("#create-order .overlay").addClass("hidden");
          },
          error : function (data, errorThrown) {
            console.log(data.responseText);
            console.log(errorThrown);
            $("#create-order .overlay").addClass("hidden");
          }
      });
    }

    function generate_select2_products(el)
    {
      // $.getJSON("<?php //echo __PATH__.'src/controller/orders/products.json' ?>",function(data){
        $(el).select2({
          data: data_products.results,
          theme: 'bootstrap4',
        });     
      // });
    }
  </script>