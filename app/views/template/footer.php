



<!-- /.container-fluid -->
<footer class="footer text-center">
    <img src="<?php echo WEBROOT ?>assets/images/by_numherit.png" class="img-responsive" title="<?php echo $this->lang['numheritby'] ; ?>" style="height: 30px; display: block; margin-left: auto; margin-right: auto;">
</footer>
</div>
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<!-- jQuery -->

<script src="<?= ASSETS ?>plugins/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="<?= ASSETS ?>bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Menu Plugin JavaScript -->
<script src="<?= ASSETS ?>plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
<!--slimscroll JavaScript -->
<script src="<?= ASSETS ?>js/jquery.slimscroll.js"></script>
<!-- Custom Theme JavaScript -->
<script src="<?= ASSETS ?>js/custom.min.js"></script>
<script src="<?= ASSETS ?>js/mask.js"></script>

<!-- Datatables JavaScript -->
<script src="<?= ASSETS ?>plugins/datatables/jquery.dataTables.js"></script>
<script src="<?= ASSETS ?>plugins/datatables/dataTables.bootstrap.js"></script>
<!-- bootstrap time picker -->
<script src="<?= ASSETS ?>plugins/bower_components/timepicker/bootstrap-timepicker.min.js"></script>
<script src="<?= ASSETS ?>plugins/datatables/extensions/Responsive/js/dataTables.responsive.js"></script>
<!-- Telephone -->
<script src="<?= ASSETS ?>plugins/telPlug/js/intlTelInput.js"></script>
<script src="<?= ASSETS ?>plugins/telPlug/js/utils.js"></script>
<!-- Jquery-confirm JS -->
<script src="<?= ASSETS ?>plugins/jconfirm/js/jquery-confirm.js"></script>
<script src="<?= ASSETS ?>plugins/bower_components/clockpicker/dist/jquery-clockpicker.min.js"></script>

<!--<script src="<?/*= ASSETS */?>plugins/datepicker/jquerydatepicker.js"></script>-->
<script type="text/javascript" src="<?= ASSETS ?>plugins/datepicker/datepicker.js"></script>
<!--<link rel="stylesheet" type="text/css" media="screen" href="<?/*= ASSETS */?>plugins/datepicker/datepicker.css">-->
<!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>-->






<!-- Sweet-Alert  -->
<script src="<?= ASSETS ?>plugins/bower_components/sweetalert/sweetalert.min.js"></script>

<script src="<?= ASSETS ?>plugins/select2/select2.full.min.js"></script>

<!-- SunuFramework JavaScript -->
<script src="<?= ASSETS ?>_main_/main.js"></script>
<script>
    $(".select2").select2();
</script>

<script type="text/javascript">
    var specialKeys = new Array();
    specialKeys.push(8); //Backspace
    function IsNumeric(e) {
        var keyCode = e.which ? e.which : e.keyCode
        var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
        /*document.getElementById("error").style.display = ret ? "none" : "inline";*/
        return ret;
    }
</script>








</body>

</html>