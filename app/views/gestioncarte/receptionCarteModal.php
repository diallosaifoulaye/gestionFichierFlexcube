<form id="validation" class="form-inline form-validator" data-type="update" role="form"
      action="<?php echo WEBROOT; ?>carte/ajoutCarteStock " method="post" id="frmCSVImport" name="uploadCSV"
      enctype="multipart/form-data">

    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title" style="text-align: center"><?= $this->lang['AjouterNewCarte'] ?></h4>

    </div>

    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>

                <div class="col-sm-6">

                    <div class="input-row">
                        <label class="col-md-4 control-label" style="width: 80%;"><?php echo $this->lang['chooseFileCSV'];?> </label> <br />
                        <input required type="file" name="file" id="file" accept=".csv" placeholder="<?php echo $this->lang['chooseFileCSV'];?>">

                        <br />

                    </div>
                    <div id="labelError"></div>

                </div>

                <div class="col-sm-3"></div>

            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button class="btn btn-success confirm" data-form="my-form" id="submit" name="import" ><i class="fa fa-check"></i> <?php echo $this->lang['btnValider']; ?>
        </button>
        <button class="btn btn-default" type="button" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo $this->lang['btnFermer']; ?> </button>
    </div>

</form>


<script type="text/javascript">
    $(document).ready(
        function () {
            $("#frmCSVImport").on(
                "submit",
                function () {

                    $("#response").attr("class", "");
                    $("#response").html("");
                    var fileType = ".csv";
                    var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+("
                        + fileType + ")$");
                    if (!regex.test($("#file").val().toLowerCase())) {
                        $("#response").addClass("error");
                        $("#response").addClass("display-block");
                        $("#response").html(
                            "Invalid File. Upload : <b>" + fileType
                            + "</b> Files.");
                        return false;
                    }
                    return true;
                });
        });
</script>
