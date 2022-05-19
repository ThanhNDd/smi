
$(document).ready(function () {

    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy HH:mi:ss',
        language: 'vi',
        todayBtn: true,
        todayHighlight: true,
        autoclose: true
    });

    if (window.jQuery().datetimepicker) {
        $('.datetimepicker').datetimepicker({
            // Formats
            format: 'YYYY-MM-DD hh:mm:ss',
            // Your Icons
            // as Bootstrap 4 is not using Glyphicons anymore
            icons: {
                time: 'far fa-clock',
                date: 'fa fa-calendar',
                up: 'fa fa-chevron-up',
                down: 'fa fa-chevron-down',
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-check',
                clear: 'fa fa-trash',
                close: 'fa fa-times'
            }
        });

    }

});

function format_phone(phone) {
    let index = phone.indexOf('84');
    if(index == 0) {
        phone = phone.replace('84', '0');
    } else {
        index = phone.indexOf('0');
        if(index != 0) {
            phone = '0'+phone;
        }
    }
    console.log(phone);
    return phone;
}

function formatNumber(num) {
    if(num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
    }
    return num;
}

function replaceComma(value) {
    if(value) {
        value = value.replace(/,/g, '');
        if(value.indexOf("đ") > -1) {
            value = value.replace(" đ","");
        }
        value = value.replace(/ /g, '');
    }
    return value;
}

function replacePercent(value) {
    if(value) {
        value = value.replace(/%/g, '');
        if (value.indexOf("đ") > -1) {
            value = value.replace("đ", "");
        }
        value = value.replace(/ /g, '');
    }
    return value;
}

// let regExp = /^\d*$|^\d*[,]?\d+$/;
let regExp = /^\$?([0-9]{1,3},([0-9]{3},)*[0-9]{3}|[0-9]+)(.[0-9][0-9])?$/;
function validate_number(val) {
    return regExp.test(val);
}

let regDate = /^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$/;
function validate_date(val) {
    return regDate.test(val);
}

  let regEmail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/;
  function validate_email(val) {
    return regEmail.test(val);
  }

  let regPhone = /^((84|0)[3|5|7|8|9])+([0-9]{8})\b$/;
  function validate_phone(val) {
    return regPhone.test(val);
  }

function get_current_date() {
    let today = new Date();
    let dd = String(today.getDate()).padStart(2, '0');
    let mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    let yyyy = today.getFullYear();
    today = dd + '/' + mm + '/' + yyyy;
    return today;
}

function custom_select2(el, data) {
    $(el).select2({
        data: data,
        theme: 'bootstrap4',
        closeOnSelect: true,
    });
}

// function format_money(value) {
//   if(value.indexOf('k') > -1 || value.indexOf('K') > -1) {
//       value = value.replace('k','000');
//       value = value.replace('K','000');
//       return value;
//   } else if(value.indexOf('m') > -1 || value.indexOf('M') > -1) {
//     value = value.replace('m','000000');
//     value = value.replace('M','000000');
//     return value;
//   } else {
//     return value;
//   }
// }
function format_money(val) {
    if(val.indexOf('k') > -1 || val.indexOf('K') > -1) {
        val = val.replace('k','000');
        val = val.replace('K','000');
    } else if(val.indexOf('m') > -1 || val.indexOf('M') > -1) {
        val = val.replace('m','000000');
        val = val.replace('M','000000');
    } else {
        val = replaceComma(val);
    }
    return val;
}

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

function generate_select2_city(city_id) {
    return new Promise((resolve) => {

        // show_loading();
        $.ajax({
            dataType: "json",
            url: root_path + "src/controller/orders/OrderController.php",
            data: {
                orders: 'loadDataCity'
            },
            type: 'GET',
            success: function (data) {
                // hide_loading();
                reset_select2('.select-city');
                $('.select-city').select2({
                    data: data.results,
                    theme: 'bootstrap4',
                    placeholder: 'Lựa chọn'
                });
                // let select = $('.select-city');
                // let option = $('<option></option>').attr('selected', true).text("Lựa chọn").val(-1);
                // option.appendTo(select);
                // select.trigger('change');
                if (city_id) {
                    $(".select-city").val(city_id).trigger("change");
                } else {
                    generate_select2_district();
                }
            },
            error: function (data, errorThrown) {
                console.log(data.responseText);
                console.log(errorThrown);
                // hide_loading();
            }
        });
        resolve();

    });
}

function generate_select2_district(cityId, districtId) {
    return new Promise((resolve) => {
        console.log("cityId: ", cityId);
        console.log("districtId: ", districtId);
        // show_loading();
        if(!cityId) {
            reset_select2('.select-district');
            $('.select-district').select2({
                data: null,
                theme: 'bootstrap4',
                placeholder: 'Lựa chọn'
            });
            generate_select2_village();
            // hide_loading();
        } else {
            $.ajax({
                dataType: "json",
                url: root_path + "src/controller/orders/OrderController.php",
                data: {
                    orders: 'loadDataDistrict',
                    cityId: cityId
                },
                type: 'GET',
                success: function (data) {
                    // console.log(data.results);
                    // hide_loading();
                    reset_select2('.select-district');
                    $('.select-district').select2({
                        data: data.results,
                        theme: 'bootstrap4',
                        placeholder: 'Lựa chọn'
                    });
                    if (districtId) {
                        if(districtId.length < 3) {
                            districtId = districtId.padStart(3, '0');
                        }
                        $(".select-district").val(districtId).trigger("change");
                    } else {
                        generate_select2_village();
                    }
                },
                error: function (data, errorThrown) {
                    console.log(data.responseText);
                    console.log(errorThrown);
                    // hide_loading();
                }
            });
        }
    resolve();

    });
}

function generate_select2_village(districtId, villageId) {
    return new Promise((resolve) => {
        // show_loading();
        if(!districtId) {
            reset_select2('.select-village');
            $('.select-village').select2({
                data: null,
                theme: 'bootstrap4',
                placeholder: 'Lựa chọn'
            });
            // hide_loading();
        } else {
            $.ajax({
                dataType: "json",
                url: root_path + "src/controller/orders/OrderController.php",
                data: {
                    orders: 'loadDataVillage',
                    districtId: districtId
                },
                type: 'GET',
                success: function (data) {
                    reset_select2('.select-village');
                    $('.select-village').select2({
                        data: data.results,
                        theme: 'bootstrap4',
                        placeholder: 'Lựa chọn'
                    });
                    // hide_loading();
                    if (villageId) {
                        if(villageId.length < 5) {
                                villageId = villageId.padStart(5, '0');
                        }
                        
                        $(".select-village").val(villageId).trigger("change");
                    }
                },
                error: function (data, errorThrown) {
                    console.log(data.responseText);
                    console.log(errorThrown);
                    // hide_loading();
                }
            });
        }
        resolve();

    });
}

function reset_select2(element) {
    let select = $(element);
    $(select).html("");
    $(select).removeClass('is-invalid');
    let option = $('<option></option>').attr('selected', true).text("Lựa chọn").val(-1);
    option.prependTo(select);
    select.trigger('change');
}

function open_modal(modal_element) {
    if(modal_element) {
        $(modal_element).modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
        hide_loading();
    } else {
        toastr.error('Đã xảy ra lỗi.');
    }
}

function close_modal(modal_element) {
    if(modal_element) {
        $(modal_element).modal('hide');
    } else {
        toastr.error('Đã xảy ra lỗi.');
    }
}

function show_loading() {
    $(".modal-dialog .overlay").removeClass("hidden");
}

function hide_loading() {
    $(".modal-dialog .overlay").addClass("hidden");
}

function format_date(date) {
    if(date) {
        let arr = date.split("-");
        let y = arr[0];
        let m = arr[1];
        let d = arr[2];
        return d+"/"+m+"/"+y;
    }
    return date;
}

function generate_select2(element) {
    $(element).select2({
        theme: 'bootstrap4'
    });
}

function alert_error_message(msg) {
    if(!msg) {
        msg = "Vui lòng liên hệ quản trị hệ thống để khắc phục";
    }
    Swal.fire({
        type: 'error',
        title: 'Đã xảy ra lỗi',
        text: msg
    });
}

function toast_error_message(msg) {
    if(!msg) {
        msg = "";
    }
    toastr.error(msg);
}

function substringMatcher (strs) {
    return function findMatches(q, cb) {
        let matches = [];
        let substrRegex = new RegExp(q, 'i');
        $.each(strs, function (i, str) {
            if (substrRegex.test(str)) {
                matches.push(str);
            }
        });
        cb(matches);
    };
}
