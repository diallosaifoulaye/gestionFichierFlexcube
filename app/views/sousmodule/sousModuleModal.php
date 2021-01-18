<form id="validation" class="form-inline form-validator" data-type="update" role="form" action="<?= WEBROOT ?>sousModule/<?= ((isset($sousModule->id)) ? "modifSousModule" : "ajoutSousModule") ?>" method="post">

    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?= ((isset($sousModule->id)) ? $this->lang['update_SousModule'] : $this->lang['ajoutSousModule']) ; ?></h4>

    </div>

    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">

                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="form-group" style="width: 100%;padding: 10px;">

                        <label for="fk_module" class="control-label"><?php echo $this->lang['labModule']; ?></label>
                        <select name="fk_module" id="fk_module" class="form-control" style="width: 100%">
                            <?php foreach ($module as $item) { ?>
                                <option <?= ($sousModule->module == $item->id) ? "selected" : "" ?> value="<?= $item->id ?>"><?= $item->module ?></option>
                            <?php } ?>
                        </select>
                        <span class="help-block with-errors"> </span>
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">

                        <label for="sous_module" class="control-label"><?php echo $this->lang['labSousModule']; ?></label>
                        <input type="text" id="sous_module" name="sous_module" class="form-control" placeholder="Libelle"
                               value="<?= $sousModule->sous_module; ?>" style="width: 100%" required>
                        <span class="help-block with-errors"> </span>
                    </div>
                    <?php if(isset($sousModule->id)){  ?> <input type="hidden" name="id" value="<?= $sousModule->id; ?>"><?php } ?>
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