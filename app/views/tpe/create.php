<form id="validation" class="form-inline form-validator" data-type="update" role="form" action="<?= WEBROOT ?>tpe/<?= ((isset($device->rowid)) ? "edit" : "create") ?>" method="post">

    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?= ((isset($device->rowid)) ? $this->lang['tpe_update'] : $this->lang['tpe_new']) ; ?></h4>
    </div>

    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="label" class="control-label"><?php echo $this->lang['tpe_libelle']; ?></label>
                        <input type="text" id="nom" name="nom" class="form-control" placeholder="<?php echo 'TPE '.($nombreDevice+1); ?>"
                               value="<?= isset($device->nom) ?$device->nom : 'TPE '.($nombreDevice+1) ; ?>" style="width: 100%" required>
                        <span class="help-block with-errors"> </span>
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="responsable" class="control-label"><?php echo $this->lang['ref_tpe']; ?></label>
                        <input type="text" id="reference" name="reference" class="form-control" placeholder="<?php echo $this->lang['ref_tpe']; ?>"
                               value="<?= isset($device->reference)?$device->reference:''; ?>" style="width: 100%" required>
                        <span class="help-block with-errors"> </span>
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="responsable" class="control-label"><?php echo $this->lang['uiid']; ?></label>
                        <input type="text" id="uiid" name="uiid" class="form-control" placeholder="<?php echo $this->lang['uiid']; ?>"
                               value="<?= isset($device->uiid)?$device->uiid:''; ?>" style="width: 100%" required>
                        <span class="help-block with-errors"> </span>
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="fk_profil" class="control-label"><?php echo $this->lang['agence']; ?></label>
                        <select name="agence_id" id="agence_id" class="form-control select2" style="width: 100%">
                            <option value=""><?php echo $this->lang['select_agence'];?></option>
                            <?php foreach ($agence as $item) { ?>
                                <option <?= ($device->agence_id == $item->rowid) ? "selected" : "" ?> value="<?= $item->rowid ?>"><?= $item->label ?></option>
                            <?php } ?>
                        </select>
                        <span class="help-block with-errors"> </span>
                    </div>

                    <?php if(isset($device->rowid)) {  ?> <input type="hidden" name="id" value="<?= $device->rowid; ?>"><?php } ?>
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
    $(".select2").select2();
</script>

<script>

</script>