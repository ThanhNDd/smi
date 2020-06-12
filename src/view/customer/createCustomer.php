<?php
require_once("../../common/common.php");
Common::authen();
?>
<div class="modal fade" id="create-customer">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="overlay d-flex justify-content-center align-items-center">
        <i class="fas fa-2x fa-sync fa-spin"></i>
      </div>
      <div class="modal-header">
        <h4 class="modal-title">Tạo mới khách hàng</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <input type="hidden" class="form-control" id="customer_id" value="">
<!--          <input type="hidden" class="form-control" id="customer_exist" value="0">-->
<!--          <input type="hidden" class="form-control" id="form_valid" value="0">-->
          <div class="row">
            <div class="col-4">
              <label>Số điện thoại <span style="color:red">*</span></label>
              <div class="input-group mb-1">
                <input type="text" class="form-control" id="phone_number" placeholder="Nhập số điện thoại" autocomplete="chrome-off">
                <input type="hidden" id="existed_phone" value="0">
                <div class="input-group-append hidden spinner-phone">
                  <span class="input-group-text">
                    <span class="spinner-border spinner-border-sm"></span>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-4">
              <label>Email</label>
              <div class="input-group mb-1">
                <input type="text" class="form-control" id="email" placeholder="Email" autocomplete="chrome-off">
                <input type="hidden" id="existed_email" value="0">
                <div class="input-group-append hidden spinner-email">
                  <span class="input-group-text">
                    <span class="spinner-border spinner-border-sm"></span>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-4">
              <div class="col-3 float-left">
                <img src='<?php Common::image_error()?>' width='70px' id='thumbnail' class=" img-circle img-fluid">
              </div>
              <div class="col-9 float-left pr-0">
                <label>Avatar</label>
                <div class="input-group mb-1">
                  <input type="text" class="form-control" placeholder="Upload hình ảnh" id="link_image" autocomplete="chrome-off">
                  <div class="input-group-append">
                    <form id="form" action="" method="post" enctype="multipart/form-data">
                      <input id="image" type="file" accept="image/*" name="image" class="hidden"/>
                      <button type="button" class="btn btn-info btn-flat" id="btn_upload">
                        <span class="spinner-border spinner-border-sm hidden" id="spinner"></span>
                        <i class="fa fa-upload"></i>
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-4">
              <label>Họ tên <span style="color:red">*</span></label>
              <input type="text" class="form-control" id="customer_name" placeholder="Họ tên"
                     autocomplete="chrome-off">
            </div>


            <div class="col-4">
              <label>Tỉnh / Thành phố <span style="color:red">*</span></label>
              <select class="select-city form-control" id="select_city">
                <option value="-1">Lựa chọn</option>
              </select>
            </div>
            <div class="col-4">
              <label>Quận / Huyện <span style="color:red">*</span></label>
              <select class="select-district form-control" id="select_district">
                <option value="-1">Lựa chọn</option>
              </select>
            </div>
            <div class="col-4">
              <label>Phường xã <span style="color:red">*</span></label>
              <select class="select-village form-control" id="select_village">
                <option value="-1">Lựa chọn</option>
              </select>
            </div>
            <div class="col-4">
              <label>Địa chỉ <span style="color:red">*</span></label>
              <input type="text" class="form-control" id="address"
                     placeholder="Nhập số nhà, thôn xóm ... " autocomplete="chrome-off">
            </div>
            <div class="col-4">
              <label>Ngày sinh</label>
              <input class="form-control datepicker" id="birthday" data-date-format="dd/mm/yyyy"
                     placeholder="<?php echo date('d/m/Y'); ?>" autocomplete="chrome-off">
            </div>
            <div class="col-4">
              <label>Tên Facebook</label>
              <input type="text" class="form-control" id="facebook" autocomplete="chrome-off" placeholder="Nhập tên facebook">
            </div>
            <div class="col-4">
              <label>Link Facebook</label>
              <input type="text" class="form-control" id="link_fb" autocomplete="chrome-off" placeholder="Nhập link facebook">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="create_new">Tạo mới</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
  <?php require_once('../../common/js.php'); ?>
  <script>
      let data_products;
      let flagError = 0;
      const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
      });
      $(document).ready(function () {
          $('.create_new').click(function () {
              reset_data();
              generate_select2_city();
              open_modal();
          });
          $('.select-city').on('select2:select', function (e) {
              let data = e.params.data;
              let cityId = data.id;
              generate_select2_district(cityId);
          });
          $('.select-district').on('select2:select', function (e) {
              let data = e.params.data;
              let districtId = data.id;
              generate_select2_village(districtId);
          });

          $('#create_new').click(function () {
              create_new();
          });

          btn_upload();

          check_exist_email();
          check_exist_phone();

          onchange_image();

      });

      function edit_customer(customerId) {
          if(customerId) {
              $.ajax({
                  url: "<?php Common::getPath() ?>src/controller/customer/CustomersController.php",
                  dataType: 'json',
                  type: 'post',
                  data: {
                      customerId: customerId,
                      method: 'edit_customer'
                  },
                  success: function (res) {
                      console.log(res);
                      hiden_overlay();
                      if(res && res.length > 0) {
                          let data = res[0];
                          reset_data();
                          setDataInform(data);
                          open_modal();
                      } else {
                          toastr.error('Không tìm thấy dữ liệu!!!');
                      }
                  }
              });
          } else {
              hiden_overlay();
              toastr.error('Đã xảy ra lỗi!!!');
          }
      }

      function setDataInform(data) {
          $("#customer_exist").val('');
          $("#customer_id").val(data.id);
          $("#phone_number").val(data.phone);
          $("#email").val(data.email);
          $("#link_image").val(data.avatar ? '<?php Common::path_avatar(); ?>'+data.avatar : '<?php Common::image_error(); ?>').trigger('blur');
          $("#customer_name").val(data.name);
          generate_select2_city(data.city_id);
          generate_select2_district(data.city_id, data.district_id);
          generate_select2_village(data.district_id, data.village_id);
          // $(".select-city").val(data.cityId).trigger('change');
          // $(".select-district").val(data.districtId).trigger('change');
          // $(".select-village").val(data.villageId).trigger('change');
          $("#address").val(data.address);
          $("#birthday").val(data.birthday);
          $("#facebook").val(data.facebook);
          $("#link_fb").val(data.link_fb);
      }

      function check_exist_phone() {
          $("#phone_number").blur(function () {
             let phone = $("#phone_number").val();
              let customer_id = $("#customer_id").val();
             if(phone && !customer_id) {
                 if(!validate_phone(phone)) {
                     $("#phone_number").addClass("is-invalid");
                     $("#phone_number").focus();
                 } else {
                     $('.spinner-phone').removeClass('hidden');
                     check_exist(phone, 'phone');
                 }
             }
          });
      }

      function check_exist_email() {
          $("#email").blur(function () {
              let email = $("#email").val();
              let customer_id = $("#customer_id").val();
              if(email && !customer_id) {
                  if(!validate_email(email)) {
                      $("#email").addClass("is-invalid");
                      $("#email").focus();
                  } else {
                      $('.spinner-email').removeClass('hidden');
                      check_exist(email, 'email');
                  }
              }
          });
      }

      function check_exist(value, type) {
          $.ajax({
              url: "<?php Common::getPath() ?>src/controller/customer/CustomersController.php",
              dataType: 'text',
              type: 'post',
              data: {
                  value: value,
                  type: type,
                  method: 'check_exist'
              },
              success: function (res) {
                  console.log(res);
                  $('.spinner-phone').addClass('hidden');
                  $('.spinner-email').addClass('hidden');
                  $("#existed_phone").val(0);
                  $("#existed_email").val(0);
                  if(res === 'existed') {
                      if(type === 'phone') {
                          toastr.error('Số điện thoại đã tồn tại');
                          $("#phone_number").addClass("is-invalid");
                          $("#existed_phone").val(1);
                      } else if(type === 'email') {
                          toastr.error('Email đã tồn tại');
                          $("#email").addClass("is-invalid");
                          $("#existed_email").val(1);
                      }
                  } else {
                      if(type === 'phone') {
                          $("#phone_number").removeClass("is-invalid");
                      } else if(type === 'email') {
                          $("#email").removeClass("is-invalid");
                      }
                  }
              }
          });
      }

      function btn_upload() {
          $("[id=btn_upload]").click(function () {
              $(this).prop('disabled', true);
              $("[id=image]").click();
              upload_image();
          });
      }

      function onchange_image() {
          $("[id=link_image]").on('blur',function () {
              let value = $(this).val();
              if(!value) {
                  $("[id=thumbnail]").attr('src', '<?php Common::image_error(); ?>');
              } else {
                  $("[id=thumbnail]").attr('onerror', '<?php Common::image_error(); ?>').attr('src', value);
              }
          });
      }

      function upload_image() {
          $("[id=image]").change(function () {
              let file_data = $(this).prop('files')[0];
              let type = file_data.type;
              let match = ["image/png", "image/jpg", "image/jpeg",];
              if (type === match[0] || type === match[1] || type === match[2]) {
                  let form_data = new FormData();
                  form_data.append('file', file_data);
                  $("[id=spinner]").removeClass('hidden');
                  $.ajax({
                      url: "<?php Common::getPath() ?>src/controller/customer/CustomersController.php",
                      dataType: 'text',
                      cache: false,
                      contentType: false,
                      processData: false,
                      data: form_data,
                      type: 'post',
                      success: function (res) {
                          console.log(res);
                          $("[id=btn_upload]").prop('disabled', '');
                          $("[id=spinner]").addClass('hidden');
                          if (res === 'file_too_large') {
                              toastr.error('File có dung lượng quá lớn.');
                              return;
                          } else if(res === 'error') {
                              toastr.error('Đã xảy ra lỗi!!');
                              return;
                          } else if(res === 'not_image') {
                              toastr.error('Chỉ được upload file ảnh có định dạng jpg, jpeg, png!!');
                              return;
                          }
                          $("[id=img]").prop('src', res).removeClass('hidden');
                          $("[id=link_image]").val(res);
                          $("[id=thumbnail]").attr('src', res);

                      }
                  });
              } else {
                  toastr.error('Chỉ được upload file ảnh');
              }
          });
      }

      function validate() {
          let is_valid = true;
          $(".modal-body").find("input").removeClass("is-invalid");
          $(".modal-body").find("select").removeClass("is-invalid");
          let customer_id = $("#customer_id").val();
          let phone_number = $("#phone_number").val();
          let existed_phone = $("#existed_phone").val();
          if (!phone_number || !validate_phone(phone_number)) {
              $("#phone_number").addClass("is-invalid");
              // $("#phone_number").focus();
              is_valid = false;
          } else if(!customer_id && existed_phone == 1){
              toastr.error('Số điện thoại đã tổn tại');
              $("#phone_number").addClass("is-invalid");
              is_valid = false;
          } else {
              $("#phone_number").removeClass("is-invalid");
          }
          let email = $("#email").val();
          let existed_mail = $("#existed_email").val();
          if(email && !validate_email(email)) {
              $("#email").addClass("is-invalid");
              // $("#email").focus();
              is_valid = false;
          } else if(!customer_id && existed_mail == 1){
              toastr.error('Email đã tổn tại');
              $("#email").addClass("is-invalid");
              is_valid = false;
          } else {
              $("#email").removeClass("is-invalid");
          }
          let customer_name = $("#customer_name").val();
          if (customer_name === "") {
              $("#customer_name").addClass("is-invalid");
              // $("#customer_name").focus();
              is_valid = false;
          } else {
              $("#customer_name").removeClass("is-invalid");
          }

          let cityId = $(".select-city").val();
          if (!cityId || cityId === "-1") {
              $(".select-city").addClass("is-invalid");
              is_valid = false;
          } else {
              $(".select-city").removeClass("is-invalid");
          }
          let districtId = $(".select-district").val();
          if (!districtId || districtId === "-1") {
              $(".select-district").addClass("is-invalid");
              is_valid = false;
          } else {
              $(".select-district").removeClass("is-invalid");
          }
          let villageId = $(".select-village").val();
          if (!villageId || villageId === "-1") {
              $(".select-village").addClass("is-invalid");
              is_valid = false;
          } else {
              $(".select-village").removeClass("is-invalid");
          }
          let add = $("#address").val();
          if (!add) {
              $("#address").addClass("is-invalid");
              is_valid = false;
          } else {
              $("#address").removeClass("is-invalid");
          }
          let facebook = $("#facebook").val();
          let linkFB = $("#link_fb").val();
          $("#facebook").removeClass("is-invalid");
          $("#link_fb").removeClass("is-invalid");
          if(facebook && !linkFB) {
              $("#link_fb").addClass("is-invalid");
              is_valid = false;
          } else if(!facebook && linkFB) {
              $("#facebook").addClass("is-invalid");
              is_valid = false;
          }
          return is_valid;
      }

      function create_new() {
          if (!validate()) {
              return;
          }
          let avatar = $("#link_image").val();
          let imgErr = '<?php Common::image_error(); ?>';
          if(avatar.indexOf(imgErr) > -1) {
              avatar = '';
          } else {
              avatar = avatar.replace('<?php echo Common::path_avatar(); ?>','');
          }
          let data = {};
          data["id"] = $("#customer_id").val();
          data["name"] = $("#customer_name").val();
          data["avatar"] = avatar;
          data["phone"] = $("#phone_number").val();
          data["email"] = $("#email").val();
          data["facebook"] = $("#facebook").val();
          data["linkFB"] = $("#link_fb").val();
          data["cityId"] = $(".select-city").val();
          data["districtId"] = $(".select-district").val();
          data["villageId"] = $(".select-village").val();
          data["address"] = $("#address").val();
          data["birthday"] = $("#birthday").val();

          console.log(JSON.stringify(data));
          let title = 'Bạn có chắc chắn muốn tạo khách hàng này?';
          let customer_id = $("#customer_id").val();
          if (customer_id !== "underfined" && customer_id !== "") {
              title = 'Bạn có chắc chắn muốn cập nhật khách hàng này?';
          }
          Swal.fire({
              title: title,
              text: "",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Ok'
          }).then((result) => {
              if (result.value) {
                  show_overlay();
                  $.ajax({
                      dataType: 'text',
                      url: '<?php Common::getPath() ?>src/controller/customer/CustomersController.php',
                      data: {
                          method: 'add_new',
                          data: JSON.stringify(data)
                      },
                      type: 'POST',
                      success: function (data) {
                          hiden_overlay();
                          console.log(data);
                          if(data == 'success') {
                              Swal.fire({
                                  type: 'success',
                                  title: 'Tạo mới thành công',
                                  text: "Khách hàng đã được tạo mới thành công"
                              }).then((result) => {
                                  if (result.value) {
                                      reset_data();
                                      $("#create-customer .close").click();
                                      hiden_overlay();
                                      $('#example').DataTable().ajax.reload();
                                  }
                              });
                          } if(data == 'existed_phone') {
                              toastr.error('Số điện thoại đã tồn tại');
                              $("#phone_number").addClass("is-invalid");
                              $("#customer_exist").val("phone");
                          } else if(data == 'existed_email') {
                              toastr.error('Email đã tồn tại');
                              $("#email").addClass("is-invalid");
                              $("#customer_exist").val("email");
                          }
                      },
                      error: function (data, errorThrown) {
                          console.log(data.responseText);
                          console.log(errorThrown);
                          Swal.fire({
                              type: 'error',
                              title: 'Đã xảy ra lỗi',
                              text: "Vui lòng liên hệ quản trị hệ thống để khắc phục"
                          });
                          hiden_overlay();
                      }
                  });

              }
          })
      }

      function reset_data() {
          $(".modal-title").text("Tạo mới khách hàng");
          $("#create_new").text("Tạo mới");
          $("#customer_id").val("");
          $("#customer_name").val("").removeClass('is-invalid');
          $("#phone_number").val("").removeClass('is-invalid');
          $("#email").val("").removeClass('is-invalid');
          $(".select-city").val("-1").trigger("change").removeClass('is-invalid');
          $(".select-district").val("-1").trigger("change").removeClass('is-invalid');
          $(".select-village").val("-1").trigger("change").removeClass('is-invalid');
          $("#address").val("").removeClass('is-invalid');
          $("#birthday").val("").removeClass('is-invalid');
          $("#link_image").val('').trigger('blur');
          $("#facebook").val('');
          $("#link_fb").val('');
      }

      // function validateEmail(email) {
      //     let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      //     return re.test(String(email).toLowerCase());
      // }

      // function replaceComma(value) {
      //     return value.replace(/,/g, '');
      // }
      //
      // function replacePercent(value) {
      //     return value.replace(/%/g, '');
      // }

      function open_modal() {
          $('#create-customer').modal({
              backdrop: 'static',
              keyboard: false,
              show: true
          });
      }

      function generate_select2_city(city_id) {
          show_overlay();
          $.ajax({
              dataType: "json",
              url: "<?php Common::getPath() ?>src/controller/orders/OrderController.php",
              data: {
                  orders: 'loadDataCity'
              },
              type: 'GET',
              success: function (data) {
                  $('.select-city').select2({
                      data: data.results,
                      theme: 'bootstrap4',
                      placeholder: 'Lựa chọn'
                  });
                  hiden_overlay();
                  if (city_id) {
                      $(".select-city").val(city_id).trigger("change");
                  }
              },
              error: function (data, errorThrown) {
                  console.log(data.responseText);
                  console.log(errorThrown);
                  hiden_overlay();
              }
          });
      }

      function generate_select2_district(cityId, districtId) {
          show_overlay();
          $('.select-district').empty();
          $.ajax({
              dataType: "json",
              url: "<?php Common::getPath() ?>src/controller/orders/OrderController.php",
              data: {
                  orders: 'loadDataDistrict',
                  cityId: cityId
              },
              type: 'GET',
              success: function (data) {
                  console.log(data.results);
                  $('.select-district').select2({
                      data: data.results,
                      theme: 'bootstrap4',
                  });
                  hiden_overlay();
                  let select = $('.select-district');
                  let option = $('<option></option>').attr('selected', true).text("Lựa chọn").val(-1);
                  option.prependTo(select);
                  select.trigger('change');
                  if (typeof districtId != "undefined" && districtId !== '') {
                      districtId = districtId.padStart(3, '0');
                      $(".select-district").val(districtId).trigger("change");
                  }
              },
              error: function (data, errorThrown) {
                  console.log(data.responseText);
                  console.log(errorThrown);
                  hiden_overlay();
              }
          });
      }

      function generate_select2_village(districtId, villageId) {
          show_overlay();
          $('.select-village').empty();
          $.ajax({
              dataType: "json",
              url: "<?php Common::getPath() ?>src/controller/orders/OrderController.php",
              data: {
                  orders: 'loadDataVillage',
                  districtId: districtId
              },
              type: 'GET',
              success: function (data) {
                  $('.select-village').select2({
                      data: data.results,
                      theme: 'bootstrap4',
                  });
                  let select = $('.select-village');
                  let option = $('<option></option>').attr('selected', true).text("Lựa chọn").val(-1);
                  option.prependTo(select);
                  select.trigger('change');
                  hiden_overlay();
                  if (typeof villageId != "undefined" && villageId !== '') {
                      villageId = villageId.padStart(5, '0');
                      $(".select-village").val(villageId).trigger("change");
                  }
              },
              error: function (data, errorThrown) {
                  console.log(data.responseText);
                  console.log(errorThrown);
                  hiden_overlay();
              }
          });
      }

      function show_overlay() {
          $("#create-order .overlay").removeClass("hidden");
      }
      function hiden_overlay() {
          $("#create-customer .overlay").addClass("hidden");
      }

  </script>
