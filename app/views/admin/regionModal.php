<form id="validation" class="form-inline form-validator" data-type="update" role="form" action="<?php echo WEBROOT; ?>administration/<?= ((isset($region->rowid)) ? "modifRegion" : "ajoutRegion") ?>" method="post">

    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?= ((isset($region->rowid)) ? $this->lang['btnModifierRegion'] : $this->lang['btnAjouterRegion']) ?></h4>
    </div>

    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="label" class="control-label"><?php echo $this->lang['labelregion']; ?></label>
                        <input type="text" id="label" name="label" class="form-control" placeholder="<?php echo $this->lang['labelregion']; ?>"
                               value="<?php echo $region->label; ?>" style="width: 100%" required>
                        <span class="help-block with-errors"> </span>
                    </div>
                    <?php if(isset($region->rowid)) {  ?> <input type="hidden" name="id" value="<?= $region->rowid; ?>"><?php } ?>
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