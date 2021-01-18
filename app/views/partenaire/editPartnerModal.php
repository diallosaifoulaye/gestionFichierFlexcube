<form id="my-form" class="form-inline form-validator" data-type="update" role="form" name="form"
      action="<?= WEBROOT ?>partenaire/updatePartenaire" method="post">
    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['modification_partenaire']; ?></h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="nom" class="control-label"><?php echo $this->lang['nom']; ?></label>
                        <input type="text" id="nom" name="nom" value="<?= $partenaire->nom ?>" class="form-control"
                                style="width: 100%">

                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="code" class="control-label"><?php echo $this->lang['couleur']; ?></label>
                        <input type="text" id="code" name="code" value="<?= $partenaire->code ?>" class="form-control"
                                style="width: 100%">
                    </div>
                    <input type="hidden" name="id" value="<?= base64_encode($partenaire->id) ?>">

                </div>

                <div class="col-sm-3"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-success confirm" data-form="my-form" type="submit"><i class="fa fa-check"></i> <?php echo $this->lang['btnValider']; ?>
        </button>
        <button class="btn btn-default" type="button" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo $this->lang['btnFermer']; ?></button>
    </div>
</form>


