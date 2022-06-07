<?php
require_once("common.php");
//Common::authen();
?>
<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="<?php Common::getPath()?>plugins/jquery/jquery.js"></script>
<!-- Bootstrap -->
<script src="<?php Common::getPath()?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php Common::getPath()?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php Common::getPath()?>dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="<?php Common::getPath()?>dist/js/demo.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="<?php Common::getPath()?>plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="<?php Common::getPath()?>plugins/raphael/raphael.min.js"></script>
<script src="<?php Common::getPath()?>plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="<?php Common::getPath()?>plugins/jquery-mapael/maps/world_countries.min.js"></script>
<!-- ChartJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>

<!-- PAGE SCRIPTS -->
<!-- <script src="<?php Common::getPath()?>dist/js/pages/dashboard2.js"></script> -->

<script src="<?php Common::getPath()?>plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php Common::getPath()?>plugins/datatables/dataTables.bootstrap4.js"></script>
<script src="https://cdn.rawgit.com/ashl1/datatables-rowsgroup/fbd569b8768155c7a9a62568e66a64115887d7d0/dataTables.rowsGroup.js"></script>
<!--<script src="--><?php //Common::getPath()?><!--plugins/datatables/dataTables.responsive.min.js"></script>-->
<!--<script src="--><?php //Common::getPath()?><!--plugins/datatables/responsive.bootstrap4.min.js"></script>-->
<!--<script src="<?php /*Common::getPath()*/?>plugins/datatables/dataTables.select.min.js" type="text/javascript"></script>-->
<script src="<?php Common::getPath()?>plugins/datatables/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="<?php Common::getPath()?>plugins/datatables/extensions/button/js/buttons.html5.min.js"></script>

<script src="<?php Common::getPath()?>plugins/select2/js/select2.js"></script>

<!-- Toastr -->
<script src="<?php Common::getPath()?>plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="<?php Common::getPath()?>plugins/toastr/toastr.min.js"></script>

<!-- iCheck js -->
<!-- <script src="<?php Common::getPath()?>plugins/icheck/icheck.min.js"></script> -->

<!--<script src="--><?php //Common::getPath()?><!--plugins/moment/moment.min.js"></script>-->
<script src="<?php Common::getPath()?>plugins/bootstrap4-datetimepicker/build/js/moment.min.js"></script>
<!-- date-range-picker -->
<script src="<?php Common::getPath()?>plugins/daterangepicker/daterangepicker.js"></script>

<script src="<?php Common::getPath()?>plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="<?php Common::getPath()?>plugins/bootstrap4-datetimepicker/build/js/bootstrap-datetimepicker.js"></script>
<script src="<?php Common::getPath()?>plugins/summernote/summernote-bs4.min.js"></script>
<script src="<?php Common::getPath()?>plugins/typeahead/js/typeahead.bundle.js"></script>
<script src="<?php Common::getPath()?>plugins/typeahead/js/bloodhound.min.js"></script>

<!--<script src="https://raw.githubusercontent.com/twitter/typeahead.js/master/dist/bloodhound.min.js"></script>-->


<script src="<?php Common::getPath()?>dist/js/common.js"></script>
<script type="text/javascript">
	let root_path = '<?php Common::getPath(); ?>';
	const IS_ADMIN = <?php echo Common::isAdmin() ?>;
	function set_title(title) {
		$(".title-page").text(document.getElementsByTagName("title")[0].innerHTML);
	}
	$(document).ready(() => {
		$(".title-page").text(document.getElementsByTagName("title")[0].innerHTML);
	})

</script>
