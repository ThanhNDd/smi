
$(document).ready(function () {

    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        language: 'vi',
        todayBtn: true,
        todayHighlight: true,
        autoclose: true
    });

});

function formatNumber(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
}

function replaceComma(value) {
    if(value) {
      value = value.trim();
      return value.replace(/,/g, '');
    }
    return value;
}

function replacePercent(value) {
    return value.replace(/%/g, '');
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

  let regPhone = /^((09|03|07|08|05)+([0-9]{8})\b)$/;
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


