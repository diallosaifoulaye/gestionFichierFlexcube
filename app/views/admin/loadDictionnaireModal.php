<form id="validation" class="form-inline form-validator" data-type="update" role="form" action="<?php echo WEBROOT; ?>administration/loadDictionnaireModal" method="post" enctype="multipart/form-data">

    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?= $this->lang['toLoadDictionnaire'] ?></h4>
    </div>


    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="fichier" class="control-label"><?php echo $this->lang['file_dict']; ?></label>
                        <input type="file" id="fichier" name="fichier" accept="text/csv" class="form-control" placeholder=""
                               style="width: 100%" required>
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

<script>
//    $('#validation').formValidation({
//            framework: 'bootstrap',
//            fields: {
//                libelle: {
//                    validators: {
//                        notEmpty: {
//                            message: '<?//= $this->lang['utilisateurObligatoire']; ?>//'
//                        }
//                    }
//                }
//            }
//        }
//    );
</script>