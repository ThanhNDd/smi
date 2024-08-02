<?php
$root = dirname(__FILE__, 4);
require_once($root."/common/common.php");
Common::authen();
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Cập nhật tồn kho Shopee</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?php Common::getPath() ?>dist/img/icon.png"/>
    <?php require_once($root.'/common/css.php'); ?>
    <?php require_once($root.'/common/js.php'); ?>
    <style>

    </style>
</head>
<?php require($root.'/common/header.php'); ?>	
<?php require($root.'/common/menu.php'); ?>
<section class="content pt-3">
	<div class="card">
		<div class=" col-md-12 m-3">
	        <form id="import" method="post" enctype="multipart/form-data" class="d-inline-block">
	            <label for="fileToUpload">Tải lên file excel dữ liệu</label>
	            <input type="file" name="fileToUpload" id="fileToUpload" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
	            <button class="btn btn-primary" name="submit" id="submit" disabled style="border-radius: 4px !important;font-size: 12px;">
	              <i class="fas fa-upload" id="uploadIcon"></i>
	              <div class="spinner-border d-none" id="spinnerIcon" style="width: 15px;height: 15px;"></div> 
	              Tải lên
	            </button>
	        </form>
	    </div>
	</div>
</section>
<?php require_once ($root.'/common/footer.php'); ?>

<script>
    $(document).ready(function () {
        set_title("Cập nhật tồn kho Shopee");
        chooseFile();
        upload();
    });
    function chooseFile() {
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
    }

    function upload() {
        $("#submit").click(function(e) {
            e.preventDefault();    
            $("#uploadIcon").addClass("d-none");
            $("#spinnerIcon").removeClass("d-none");
            // $("#fileToUpload").attr("disabled", true);
            $("#submit").attr("disabled", true);


            var form = $("#import");
            let file_data = $("#fileToUpload").prop('files')[0];
            var formData = new FormData(form[0]);
            formData.append('file', file_data);

            $.ajax({
                url: "<?php Common::getPath() ?>src/controller/batch/UpdateInventoryController.php",
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (response) => {
                    console.log(response);
                    response = JSON.parse(response);
                    console.log(response);  
                    if(response) {
                        window.open(response, "_blank");
                    } else {
                        $("#uploadIcon").removeClass("d-none");
                        $("#spinnerIcon").addClass("d-none");
                        $("#fileToUpload").val("");
                        $("#submit").removeAttr("disabled");
                        toastr.error(`Đã xảy ra lỗi`);
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $("#uploadIcon").removeClass("d-none");
                    $("#spinnerIcon").addClass("d-none");
                    $("#fileToUpload").val("");
                    $("#submit").removeAttr("disabled");
                    toastr.error(`Đã xảy ra lỗi`);
                },
              })
            .done(function() {
                $("#uploadIcon").removeClass("d-none");
                $("#spinnerIcon").addClass("d-none");
                $("#fileToUpload").val("");
                $("#submit").removeAttr("disabled");
                toastr.success(`Cập nhật thành công`);
            })
        });
    }
</script>