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
    <a href="<?php Common::getPath() ?>src/view/products" class="btn btn-sm btn-secondary btn-flat p-2">
        <i class="fas fa-backward"></i> Back
    </a>
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
      <button class="btn btn-danger float-right" id="updateAll" style="border-radius: 4px !important;font-size: 12px;">
        <div class="spinner-border d-none" id="spinnerUpdateAll"></div>
        Cập nhật
      </button>
    </div>
  </div>

  <div class="alert alert-danger">
    <strong><i class="fas fa-exclamation-triangle"></i></strong> Chỉ sử dụng cho các đơn J&T
  </div>

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
</section>

<?php require_once('../../common/footer.php'); ?>
<script>
  $(document).ready(function(){

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
            url: "<?php Common::getPath() ?>src/controller/batch/UpdateShopeeQuantityController.php",
            type: 'POST',
            data: formData,
            success: async (response) => {
              console.log(response);  
              if(response) {
                download(response);
              }
            },
            cache: false,
            contentType: false,
            processData: false
          }).done(function() {
            
          });
    });

  });

</script>
</body>
</html>