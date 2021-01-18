<form id="validation" class="form-inline form-validator" data-type="update" role="form" action="<?= WEBROOT ?>utilisateur/regenerationPwd" method="post">

    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['confirmTitre']; ?></h4>
    </div>

    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6"><?= $this->lang['reload_pwd']; ?></div>
                <div class="col-sm-3"><input type="hidden" name="id" value="<?= $rowid; ?>"/></div>

            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button class="btn btn-success confirm" data-form="my-form" type="submit"><i class="fa fa-check"></i> <?php echo $this->lang['oui']; ?>
        </button>
        <button class="btn btn-default" type="button" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo $this->lang['non']; ?> </button>
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