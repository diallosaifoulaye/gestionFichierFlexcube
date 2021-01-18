<form id="validation" class="form-inline form-validator" data-type="update" role="form" action="<?= WEBROOT ?>tpe/<?= ((isset($affectation->rowid)) ? "editAffectation" : "createAffectation") ?>" method="post">

    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?= ((isset($affectation->rowid)) ? $this->lang['affectation_update'] : $this->lang['affectation_new']) ; ?></h4>
    </div>

    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="label" class="control-label"><?php echo $this->lang['date_affectation']; ?></label>

                        <input type="date" name="date_debut" required class="form-control" id="date_debut" placeholder="<?= $this->lang['date_affectation']; ?>" value="<?= isset($affectation->date_debut) ?substr($affectation->date_debut, 0, 10) : ''; ?>" style="width: 100%" required>
                        <span class="help-block with-errors"> </span>

                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="fk_profil" class="control-label"><?php echo $this->lang['collecteur']; ?></label>
                        <select name="fk_collecteur" id="collecteur" class="form-control select2" style="width: 100%">
                            <option value=""> <?php echo $this->lang['select_collecteur']; ?> </option>
                            <?php foreach ($collecteurs as $item) { ?>
                                <option <?= ($affectation->prenom." ".$affectation->nom  /*$affectation->fk_collecteur*/ == $item->prenom." ".$item->nom) ? "selected" : "" ?> value="<?= $item->id ?>"><?= $item->prenom." ".$item->nom ?></option>
                            <?php } ?>
                        </select>
                        <span class="help-block with-errors"> </span>
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="fk_profil" class="control-label"><?php echo $this->lang['tpe']; ?></label> (<span style="color: #0a7242; font-weight: 700">Disponible:<?php echo $nombreDevice ; ?></span>)
                        <select name="fk_materiel" id="equipement" class="form-control select2" style="width: 100%">
                            <option value=""> <?php echo $this->lang['select_tpe']; ?> </option>
                            <?php foreach ($devices as $item) { ?>
                                <option <?= ($affectation->fk_materiel == $item->rowid) ? "selected" : "" ?> value="<?= $item->rowid ?>"><?= $item->nom." ".$item->uiid." ".$item->reference ?></option>
                            <?php } ?>
                        </select>
                        <span class="help-block with-errors"> </span>
                    </div>

                    <?php if(isset($affectation->rowid)) {  ?> <input type="hidden" name="id" value="<?= $affectation->rowid; ?>"><?php } ?>
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
   /* $(function() {
        $( "#from" ).datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 1,
            onClose: function( selectedDate ) {
                $( "#to" ).datepicker( "option", "minDate", selectedDate );
            }
        });
    });*/
</script>