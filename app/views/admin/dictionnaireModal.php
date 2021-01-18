<form id="validation" class="form-inline form-validator" data-type="update" role="form" action="<?php echo WEBROOT; ?>administration/<?= ((isset($dictionnaire->rowid)) ? "modifDictionnaire" : "ajoutDictionnaire") ?>" method="post">

    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?= ((isset($dictionnaire->rowid)) ? $this->lang['btnModifierDictionnaire'] : $this->lang['btnAjouterDictionnaire']) ?></h4>
    </div>

    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="matricule" class="control-label"><?php echo $this->lang['matricule']; ?></label>
                        <input type="text" id="matricule" name="matricule" class="form-control" placeholder="<?php echo $this->lang['matricule']; ?>"
                               value="<?php echo $dictionnaire->matricule; ?>" style="width: 100%" required>
                        <span class="help-block with-errors"> </span>
                    </div>
                </div>
                <div class="col-sm-3"></div>

            </div>
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="num_compte" class="control-label"><?php echo $this->lang['numcompte']; ?></label>
                        <input type="text" id="num_compte" name="num_compte" class="form-control" placeholder="<?php echo $this->lang['numcompte']; ?>"
                               value="<?php echo $dictionnaire->num_compte; ?>" style="width: 100%" required>
                        <span class="help-block with-errors"> </span>
                    </div>
                    <?php if(isset($dictionnaire->rowid)) {  ?> <input type="hidden" name="id" value="<?= $dictionnaire->rowid; ?>"><?php } ?>
                </div>
                <div class="col-sm-3"></div>

            </div>


            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="code_agence" class="control-label"><?php echo $this->lang['code_agence']; ?></label>
                        <input type="text" id="code_agence" name="code_agence" class="form-control" placeholder="<?php echo $this->lang['code_agence']; ?>"
                               value="<?php echo $dictionnaire->code_agence; ?>" style="width: 100%" required>
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