<?php
require_once("../../common/common.php");
Common::authen();
?>
<div class="modal fade" id="create-product">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="overlay d-flex justify-content-center align-items-center">
        <i class="fas fa-2x fa-sync fa-spin"></i>
      </div>
      <div class="modal-header">
        <h4 class="modal-title">Tạo mới sản phẩm</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="min-height: 300px;">
        <div class="row col-md-12">
          <div class="col-md-4">
            <div class="card card-outline card-danger">
              <div class="card-header">
                <h3 class="card-title">Danh sách sản phẩm</h3>
              </div>
              <div class="card-body">
                <input type="hidden" id="product_id">
                <table class="table table-info-product">
                  <tr>
                    <td>Tên sản phẩm</td>
                    <td>
                      <input type="text" class="form-control ml-2 col-sm-10"
                             id="name" placeholder="Nhập tên sản phẩm">
                    </td>
                  </tr>
                  <tr>
                    <td>Link sản phẩm</td>
                    <td>
                      <input type="text" class="form-control ml-2 col-sm-10" id="link"
                             placeholder="Nhập link sản phẩm">

                    </td>
                  </tr>
                  <tr>
                    <td>Phí vận chuyển</td>
                    <td>
                      <input type="text" class="form-control ml-2" style="float: left; width: 175px;" id="fee"
                             value="0" placeholder="Nhập phí vận chuyển">
                      <div class="input-group-append" style="float: left;">
                        <span class="input-group-text" style="border-radius: 0;">đ</span>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>Giới tính</td>
                    <td>
                      <select class="select-type form-control ml-2 col-sm-10" id="select_type"
                              style="width: 208px;"></select>
                    </td>
                  </tr>
                  <tr>
                    <td>Danh mục</td>
                    <td>
                      <select class="select-cat form-control ml-2 col-sm-10" id="select_cat"
                              style="width: 208px;"></select>
                    </td>
                  </tr>
                  <tr>
                    <td>Giá nhập</td>
                    <td>
                      <input type="text" class="form-control ml-2" style="float: left; width: 175px;" id="price" value="">
                      <div class="input-group-append" style="float: left;">
                        <span class="input-group-text" style="border-radius: 0;">đ</span>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>Giá bán lẻ</td>
                    <td>
                      <div style="display: inline;vertical-align: top;">
                        <input type="text" class="form-control ml-2 col-sm-10" id="retail" value=""
                               style="width: 120px;vertical-align: top;float: left;">
                        <input type="number" class="form-control ml-2" id="p_percent_" value="100" min="0" max="100"
                               style="width: 53px;padding-right: 5px;padding-left: 5px;vertical-align: top;float: left;">
                        <div class="input-group-append" style="float: left;">
                          <span class="input-group-text" style="border-radius: 0;">%</span>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>Size</td>
                    <td>
                      <select class="select-size form-control ml-2 mr-2 col-sm-10" id="select_size"
                              style="width: 167px;float: left;" multiple="multiple"></select>
                      <button class="btn btn-info btn-flat" id="add_size" title="Thêm size"><i
                          class="fa fa-plus-circle"></i></button>
                    </td>
                  </tr>
                  <tr>
                    <td>Màu sắc</td>
                    <td>
                      <select class="select-color form-control ml-2 mr-2 col-sm-10" id="select_color"
                              style="width: 167px;float: left;" multiple="multiple"></select>
                      <button class="btn btn-info btn-flat" id="add_color" title="Thêm màu sắc"><i
                          class="fa fa-plus-circle"></i></button>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2" style="text-align: center;">
                      <button class="btn btn-secondary btn-flat" id="create_variation">Tạo biến thể</button>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
          <div class="col-md-8">
            <div class="card card-outline card-danger" style="min-height: 532px;">
              <div class="card-header">
                <h3 class="card-title">Danh sách sản phẩm</h3>
              </div>
              <div class="card-body">
                <table class="table table-list">
                  <thead>
                  <tr>
                    <th width="50px">STT</th>
                    <th width="500px">Hình ảnh</th>
                    <th width="100px">Size</th>
                    <th width="100px">Màu sắc</th>
                  </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success form-control add-new-prod w80 btn-flat" title="Thêm 10 bản ghi">
          <i class="fa fa-plus-circle" aria-hidden="true"> </i>
        </button>
        <button type="button" class="btn btn-primary create-new btn-flat">Tạo mới</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
  <?php require_once('../../common/js.php'); ?>
  <script>
      let flagError = 0;
      const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
      });

      $(document).ready(function () {
          $('.product-create').click(function () {
              // clear();
              open_modal();
              // add_new_product();
          });

          // $('.add-new-prod').click(function () {
          //     // add_new_product();
          // });

          // $('.create-new').click(function () {
          //     create_new();
          // });
          $('#create-product').on('hidden.bs.modal', function () {
              // location.reload();
              let table = $('#example').DataTable();
              table.ajax.reload();
          });

          generate_select2_size('#select_size');
          generate_select2_colors('#select_color');
          generate_select2_types('#select_type');
          generate_select2_cats('#select_cat');


          $("#create_variation").click(function(){
              create_variation();
          });

      });

      function create_variation() {
          if(!validate_product()) {
              return;
          }
          generate_variations();
      }

      function validate_product() {
          let regExp = /^\d*$|^\d*[,]?\d+$/;

          let name = $("#name").val();
          if(name == "") {
              toastr.error("Tên sản phẩm không được để trống");
              $("#name").focus();
              $("#name").addClass("is-invalid");
              return false;
          } else {
              $("#name").removeClass("is-invalid");
          }

          let fee = $("#fee").val();
          if(fee != "" && !regExp.test(fee)) {
              toastr.error("Phí vận chuyển phải là số");
              $("#fee").focus();
              $("#fee").addClass("is-invalid");
              return false;
          } else {
              $("#fee").removeClass("is-invalid");
              $("#fee").val(formatNumber(fee));
          }

          let type = $("#select_type").val();
          if(type == "" || type == "-1") {
              toastr.error("Bạn chưa chọn giới tính");
              $("#select_type").focus();
              $("#select_type").addClass("is-invalid");
              return false;
          } else {
              $("#select_type").removeClass("is-invalid");
          }

          let cat = $("#select_cat").val();
          if(cat == "" || cat == "-1") {
              toastr.error("Bạn chưa chọn danh mục");
              $("#select_cat").focus();
              $("#select_cat").addClass("is-invalid");
              return false;
          } else {
              $("#select_cat").removeClass("is-invalid");
          }

          let price_import = $("#price").val();
          if(price_import == "") {
              toastr.error("Giá nhập sản phẩm không được bỏ trống");
              $("#price").focus();
              $("#price").addClass("is-invalid");
              return false;
          } else if (!regExp.test(price_import)) {
              toastr.error("Giá nhập phải là số");
              $("#price").focus();
              $("#price").addClass("is-invalid");
              return false;
          } else {
              $("#price").removeClass("is-invalid");
              $("#price").val(formatNumber(price_import));
          }

          let price_retail = $("#retail").val();
          if(price_retail == "") {
              toastr.error("Giá bán lẻ sản phẩm không được bỏ trống");
              $("#retail").focus();
              $("#retail").addClass("is-invalid");
              return false;
          } else if (!regExp.test(price_retail)) {
              toastr.error("Giá bán lẻ phải là số");
              $("#retail").focus();
              $("#retail").addClass("is-invalid");
              return false;
          } else {
              $("#retail").removeClass("is-invalid");
              $("#retail").val(formatNumber(price_retail));
          }

          let size = $("#select_size").val();
          if(size == "") {
              toastr.error("Bạn chưa chọn size");
              $("#select_size").focus();
              $("#select_size").addClass("is-invalid");
              return false;
          } else {
              $("#select_size").removeClass("is-invalid");
          }
          let color = $("#select_color").val();
          if(color == "") {
              toastr.error("Bạn chưa chọn màu sắc");
              $("#select_color").focus();
              $("#select_color").addClass("is-invalid");
              return false;
          } else {
              $("#select_color").removeClass("is-invalid");
          }
          return true;
      }

      function generate_variations() {
          $(".table-list tbody").append('<tr>\n' +
              '                    <td width="50px">1</td>\n' +
              '                    <td width="500px">\n' +
              '                      <img src="https://via.placeholder.com/100" style="justify-content: left;float: left;">\n' +
              '                      <div class="input-group mb-3 col-md-9" style="float: left;">\n' +
              '                        <input type="text" class="form-control col-md-10" placeholder="Nhập link hình ảnh" id="p_image">\n' +
              '                        <div class="input-group-append">\n' +
              '                          <button type="button" class="btn btn-info btn-flat">\n' +
              '                            <i class="fa fa-upload"></i> Upload\n' +
              '                          </button>\n' +
              '                        </div>\n' +
              '                      </div>\n' +
              '                    </td>\n' +
              '                    <td width="100px">\n' +
              '                      <input type="text" class="form-control mb-2 mr-sm-2 col-md-12 float-left" id="size_norow">\n' +
              '                    </td>\n' +
              '                    <td width="100px">\n' +
              '                      <input type="text" class="form-control mb-2 mr-sm-2 col-md-12 float-left" id="color_norow">\n' +
              '                    </td>\n' +
              '                  </tr>');
      }

      function open_modal() {
          $('#create-product').modal({
              backdrop: 'static',
              keyboard: false,
              show: true
          });
      }

      // function reset_form() {
      //     clear();
      //     add_new_product();
      // }

      // function clear() {
      //     $('.count-row').val(0);
      //     $(".product-area").html("");
      // }

      // function add_new_product() {
      //     show_loading();
      //     let noRow = $('.count-row').val();
      //     for ($i = 0; $i < 10; $i++) {
      //         noRow = Number(noRow) + 1;
      //         $('.count-row').val(noRow);
      //         let content = '<div class="row" id="product-' + noRow + '" row-index="' + noRow + '" style="padding-top: 10px;">' +
      //             '<input type="hidden" id="product_id_' + noRow + '">' +
      //             '<div class="w30 center">' +
      //             '<span class="lineNo">' + noRow + '</span>' +
      //             '</div>' +
      //             '<div class="pd-l-5 pd-r-5 w110">' +
      //             '<input type="text" value="https://via.placeholder.com/150" class="form-control" id="p_image_' + noRow + '">' +
      //             '</div>' +
      //             '<div class="pd-l-5 pd-r-5 w150">' +
      //             '<input type="text" class="form-control" id="p_name_' + noRow + '">' +
      //             '</div>' +
      //             '<div class="pd-l-5 pd-r-5 w130">' +
      //             '<input type="text" class="form-control" id="p_link_' + noRow + '">' +
      //             '</div>' +
      //             '<div class="pd-l-5 pd-r-5 w120">' +
      //             '<select class="select-size-' + noRow + ' js-states form-control" id="select_size_' + noRow + '" multiple="multiple"></select>' +
      //             '</div>' +
      //             '<div class="pd-l-5 pd-r-5 w120">' +
      //             '<select class="select-color-' + noRow + ' js-states form-control" id="select_color_' + noRow + '" multiple="multiple"></select>' +
      //             '</div>' +
      //             '<div class="pd-l-5 pd-r-5 w50">' +
      //             '<input type="text" class="form-control" id="p_qty_' + noRow + '" min="1" value="1">' +
      //             '</div>' +
      //             '<div class="pd-l-5 pd-r-5 w100">' +
      //             '<input type="text" class="form-control" id="p_price_' + noRow + '" min="1" onchange="onchange_price(this)">' +
      //             '</div>' +
      //             '<div class="pd-l-5 pd-r-5 w120">' +
      //             '<input type="text" class="form-control" id="p_fee_' + noRow + '" onchange="onchange_price(this)">' +
      //             '</div>' +
      //             '<div class="pd-l-5 pd-r-5 w70 center">' +
      //             '<input type="text" class="form-control" id="p_percent_' + noRow + '" value="80" onchange="onchange_percent(this)">' +
      //             '</div>' +
      //             '<div class="pd-l-5 pd-r-5 w70 center hidden">' +
      //             '<input type="text" class="form-control" id="p_retail_temp_' + noRow + '" onchange="onchange_retail_tmp(this)">' +
      //             '</div>' +
      //             '<div class="pd-l-5 pd-r-5 w110">' +
      //             '<input type="text" class="form-control" id="p_retail_' + noRow + '" onchange="onchange_retail(this)">' +
      //             '</div>' +
      //             '<div class="pd-l-5 pd-r-5 pd-t-5 w70">' +
      //             '<span id="p_profit_' + noRow + '"></span>' +
      //             '</div>' +
      //             '<div class="pd-l-5 pd-r-5 w100">' +
      //             '<select class="select-type-' + noRow + ' form-control" id="select_type_' + noRow + '"></select>' +
      //             '</div>' +
      //             '<div class="pd-l-5 pd-r-5 w130">' +
      //             '<select class="select-cat-' + noRow + ' form-control" id="select_cat_' + noRow + '"></select>' +
      //             '</div>' +
      //             '</div>';
      //         $(".product-area").append(content);
      //         generate_select2_size('.select-size-' + noRow);
      //         generate_select2_colors('.select-color-' + noRow);
      //         generate_select2_types('.select-type-' + noRow);
      //         generate_select2_cats('.select-cat-' + noRow);
      //     }
      //     hide_loading();
      // }

      function generate_select2_size(el) {
          $(el).select2({
              data: size,
              theme: 'bootstrap4',
              closeOnSelect: true
          });
      }

      function generate_select2_colors(el) {
          $(el).select2({
              data: colors,
              theme: 'bootstrap4',
              closeOnSelect: true
          });
      }

      function generate_select2_types(el) {
          $(el).select2({
              data: types,
              theme: 'bootstrap4',
          });
      }

      function generate_select2_cats(el) {
          $(el).select2({
              data: cats,
              theme: 'bootstrap4',
          });
      }

      // function onchange_retail_tmp(e) {
      //     let rowIndex = $(e).parent().parent().attr("row-index");
      //     let percent = $("[id=p_percent_" + rowIndex + "]").val();
      //     let price = $("[id=p_price_" + rowIndex + "]").val();
      //     price = replaceComma(price);
      //     let fee = $("[id=fee_" + rowIndex + "]").val();
      //     fee = replaceComma(fee);
      //     if (price !== "" && !isNaN(price)) {
      //         price = Number(price);
      //     } else {
      //         price = 0;
      //     }
      //     if (fee !== "" && !isNaN(fee)) {
      //         fee = Number(fee);
      //     } else {
      //         fee = 0;
      //     }
      //     if (percent !== "" && !isNaN(percent)) {
      //         percent = Number(percent);
      //     } else {
      //         percent = 0;
      //     }
      //     let retail = price + (price + fee) * percent / 100;
      //     retail = formatNumber(retail);
      //     if (retail === '0') {
      //         retail = "";
      //     }
      //     $("[id=retail]").val(retail);
      // }

      function onchange_retail(e) {
          // let rowIndex = $(e).parent().parent().attr("row-index");
          let val = $(e).val();
          val = replaceComma(val);
          if (isNaN(val) || val < 10) {
              $(e).addClass("is-invalid");
          } else {
              $(e).removeClass("is-invalid");
              if (val.indexOf(".") > 0) {
                  val = val.replace(/\./g, '');
                  val = Number(val + "00");
              } else {
                  val = Number(val + "000");
              }
              $(e).val(formatNumber(val));
              calc_profit();
              calc_percent();
          }
      }

      function calc_profit() {
          let retail = $("[id=retail]").val();
          retail = replaceComma(retail);
          let price = $("[id=price]").val();
          price = replaceComma(price);
          let fee = $("[id=fee]").val();
          fee = replaceComma(fee);
          let profit = Number(retail) - Number(price) - Number(fee);
          $("[id=profit]").text(formatNumber(profit));
      }

      function onchange_price(e) {
          let rowIndex = $(e).parent().parent().attr("row-index");
          let val = $(e).val();
          val = replaceComma(val);
          if (val.indexOf(".") > 0) {
              val = val.replace(/\./g, '');
              val = Number(val + "00");
          } else {
              val = Number(val + "000");
          }
          if (isNaN(val) || val > 1000000) {
              $(e).addClass("is-invalid");
          } else {
              $(e).removeClass("is-invalid");
              $(e).val(formatNumber(val));
              // $("[id=p_retail_temp_" + rowIndex + "]").trigger("change");
              calc_profit(rowIndex);
          }
      }

      function onchange_percent(e) {
          // let rowIndex = $(e).parent().parent().attr("row-index");
          let val = $(e).val();
          if (isNaN(val) || val < 39) {
              $(e).addClass("is-invalid");
              $(e).focus();
          } else {
              $(e).removeClass("is-invalid");
              // $("[id=retail_temp_" + rowIndex + "]").trigger("change");
              calc_profit(rowIndex);
          }
      }

      function calc_percent() {
          let retail = $("[id=retail]").val();
          retail = replaceComma(retail);
          let price = $("[id=price]").val();
          price = replaceComma(price);
          let fee = $("[id=fee]").val();
          fee = replaceComma(fee);
          if (isNaN(retail)) {
              $("[id=retail]").addClass("is-invalid");
              $("[id=retail]").focus();
          } else if (isNaN(price)) {
              $("[id=price]").addClass("is-invalid");
              $("[id=price]").focus();
          } else if (isNaN(fee)) {
              $("[id=fee]").addClass("is-invalid");
              $("[id=fee]").focus();
          } else {
              $("[id=retail]").removeClass("is-invalid");
              $("[id=price]").removeClass("is-invalid");
              $("[id=fee]").removeClass("is-invalid");
              retail = Number(retail);
              price = Number(price);
              fee = Number(fee);
              let percent = (retail - price) * 100 / (price + fee);
              percent = Math.round(percent);
              $("[id=percent]").val(percent);
          }
      }

      function create_new() {
          show_loading();
          let data = {};
          let rowProductNumber = $(".count-row").val();
          let products = [];
          for (let i = 1; i <= rowProductNumber.length; i++) {
              let product_id = $("#product_id_" + i).val();
              let image = $("#p_image_" + i).val();
              let name = $("#p_name_" + i).val();
              let link = $("#p_link_" + i).val();
              let size = $("#select_size_" + i).val();
              let color = $("#select_color_" + i).val();
              let qty = $("#p_qty_" + i).val();
              let price = $("#p_price_" + i).val();
              let fee = $("#p_fee_" + i).val();
              let percent = $("#p_percent_" + i).val();
              let retail = $("#p_retail_" + i).val();
              let profit = $("#p_profit_" + i).text();
              let type = $("#select_type_" + i).val();
              let catId = $("#select_cat_" + i).val();
              if (image !== "" && name !== "" && price !== "" && type.length > 0 && catId.length > 0) {
                  let product = {};
                  product["image"] = image;
                  product["name"] = name;
                  product["link"] = link;
                  product["size"] = size;
                  product["color"] = color;
                  product["quantity"] = qty;
                  product["price"] = replaceComma(price);
                  product["fee"] = replaceComma(fee);
                  product["retail"] = replaceComma(retail);
                  product["percent"] = percent.replace("%", "");
                  product["profit"] = replaceComma(profit);
                  product["type"] = type;
                  product["catId"] = catId;
                  product["product_id"] = product_id;
                  products.push(product);
              }
          }
          data["products"] = products;
          console.log(JSON.stringify(data));
          hide_loading();
          Swal.fire({
              title: 'Bạn có chắc chắn muốn tạo các sản phẩm này?',
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
                      dataType: 'json',
                      url: '<?php Common::getPath() ?>src/controller/product/ProductController.php',
                      data: {
                          type: 'addNew',
                          data: JSON.stringify(data)
                      },
                      type: 'POST',
                      success: function (data) {
                          Swal.fire(
                              'Thành công!',
                              'Các sản phẩm đã được tạo thành công.',
                              'success'
                          )
                          reset_form();
                          hide_loading();
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
          })
      }

      function show_loading() {
          // $("#create-product .overlay").removeClass("hidden");
      }

      function hide_loading() {
          $("#create-product .overlay").addClass("hidden");
      }

      // function formatNumber(num) {
      //     return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
      // }

      // function replaceComma(value) {
      //     return value.replace(/,/g, '');
      // }


      let size = [
          {
              id: '60',
              text: '60 cm (3kg-6kg)'
          },
          {
              id: '73',
              text: '73 cm (6kg-8kg)'
          },
          {
              id: '80',
              text: '80 cm (8kg-10kg)'
          },
          {
              id: '90',
              text: '90 cm (11kg-13kg)'
          },
          {
              id: '100',
              text: '100 cm (14kg-16kg)'
          },
          {
              id: '110',
              text: '110 cm (17kg-18kg)'
          },
          {
              id: '120',
              text: '120 cm (19kg-20kg)'
          },
          {
              id: '130',
              text: '130 cm (21kg-23kg)'
          },
          {
              id: '140',
              text: '140 cm (24kg-27kg)'
          },
          {
              id: '150',
              text: '150 cm (28kg-32kg)'
          },
          {
              id: '160',
              text: '160 cm (33kg-40kg)'
          },
          {
              id: '3m',
              text: '3m'
          },
          {
              id: '6m',
              text: '6m'
          },
          {
              id: '9m',
              text: '9m'
          },
          {
              id: 'Free Size',
              text: 'Free Size'
          },
          {
              id: '1',
              text: '1'
          },
          {
              id: '2',
              text: '2'
          },
          {
              id: '3',
              text: '3'
          },
          {
              id: '4',
              text: '4'
          },
          {
              id: '5',
              text: '5'
          },
          {
              id: '6',
              text: '6'
          },
          {
              id: '7',
              text: '7'
          },
          {
              id: '8',
              text: '8'
          },
          {
              id: '9',
              text: '9'
          },
          {
              id: '10',
              text: '10'
          },
          {
              id: '11',
              text: '11'
          },
          {
              id: '12',
              text: '12'
          },
          {
              id: '13',
              text: '13'
          },
          {
              id: '14',
              text: '14'
          },
          {
              id: '15',
              text: '15'
          },
          {
              id: '16',
              text: '16'
          },
          {
              id: '17',
              text: '17'
          },
          {
              id: '18',
              text: '18'
          },
          {
              id: '19',
              text: '19'
          },
          {
              id: '20',
              text: '20'
          },
          {
              id: '1T',
              text: '1T'
          },
          {
              id: '2T',
              text: '2T'
          },
          {
              id: '3T',
              text: '3T'
          },
          {
              id: '4T',
              text: '4T'
          },
          {
              id: '5T',
              text: '5T'
          },
          {
              id: '6T',
              text: '6T'
          },
          {
              id: '7T',
              text: '7T'
          },
          {
              id: '8T',
              text: '8T'
          },
          {
              id: '9T',
              text: '9T'
          },
          {
              id: '10T',
              text: '10T'
          },
          {
              id: '11T',
              text: '11T'
          },
          {
              id: '12T',
              text: '12T'
          },
          {
              id: '13T',
              text: '13T'
          },
          {
              id: '14T',
              text: '14T'
          },
          {
              id: '15T',
              text: '15T'
          },
          {
              id: '16T',
              text: '16T'
          },
          {
              id: '17T',
              text: '17T'
          },
          {
              id: '18T',
              text: '18T'
          },
          {
              id: '19T',
              text: '19T'
          },
          {
              id: '20T',
              text: '20T'
          }
      ];
      let colors = [
          {
              id: 'Trắng',
              text: 'Trắng'
          },
          {
              id: 'Xanh',
              text: 'Xanh'
          },
          {
              id: 'Đỏ',
              text: 'Đỏ'
          },
          {
              id: 'Tím',
              text: 'Tím'
          },
          {
              id: 'Vàng',
              text: 'Vàng'
          },
          {
              id: 'Xám',
              text: 'Xám'
          },
          {
              id: 'Hồng',
              text: 'Hồng'
          },
          {
              id: 'Đen',
              text: 'Đen'
          },
          {
              id: 'Nâu',
              text: 'Nâu'
          },
          {
              id: 'Kem',
              text: 'Kem'
          },
          {
              id: 'Bạc',
              text: 'Bạc'
          },
          {
              id: 'Cam',
              text: 'Cam'
          },
          {
              id: 'Kẻ',
              text: 'Kẻ'
          }
      ];
      let qty = [
          {
              id: '0',
              text: '0'
          },
          {
              id: '1',
              text: '1'
          },
          {
              id: '2',
              text: '2'
          },
          {
              id: '3',
              text: '3'
          },
          {
              id: '4',
              text: '4'
          },
          {
              id: '5',
              text: '5'
          },
          {
              id: '6',
              text: '6'
          },
          {
              id: '7',
              text: '7'
          },
          {
              id: '8',
              text: '8'
          },
          {
              id: '9',
              text: '9'
          },
          {
              id: '10',
              text: '10'
          },
          {
              id: '11',
              text: '11'
          },
          {
              id: '12',
              text: '12'
          },
          {
              id: '13',
              text: '13'
          },
          {
              id: '14',
              text: '14'
          }
      ];
      let types = [
          {
              id: '-1',
              text: ''
          },
          {
              id: '0',
              text: 'Bé trai'
          },
          {
              id: '1',
              text: 'Bé gái'
          },
          {
              id: '2',
              text: 'Trai gái'
          }
      ];
      let cats = [
          {
              id: '-1',
              text: ''
          },
          {
              id: '1',
              text: 'Bộ quần áo'
          },
          {
              id: '2',
              text: 'Áo'
          },
          {
              id: '3',
              text: 'Quần'
          },
          {
              id: '4',
              text: 'Váy'
          },
          {
              id: '5',
              text: 'Giày'
          },
          {
              id: '6',
              text: 'Dép'
          },
          {
              id: '7',
              text: 'Mũ'
          },
          {
              id: '8',
              text: 'Phụ kiện'
          }
      ];
  </script>
