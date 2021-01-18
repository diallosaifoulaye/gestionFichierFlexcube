<form id="validation" class="form-inline form-validator" enctype="multipart/form-data" data-type="update" role="form" action="<?= WEBROOT ?>fichier/uploadExcel" method="post">

    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['chargementFile']; ?></h4>
    </div>

    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">

                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="form-group" style="width: 100%;padding: 10px;">

                        <label for="file" class="control-label"><?php echo $this->lang['choiceExcelFile']; ?><br></label>
                        <br>
                        <input required type="file" name="file" id="file" accept=".xls,.xlsx" >

                        <span class="help-block with-errors"> </span>
                    </div>


                </div>
                <div class="col-sm-3"></div>

            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button class="btn btn-success confirm" data-form="my-form" type="submit"><i class="fa fa-check"></i> <?php echo $this->lang['btnValider']; ?>
        </button>
        <button class="btn btn-default" type="button" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo $this->lang['btnFermer']; ?> </button>
    </div>

</form>
