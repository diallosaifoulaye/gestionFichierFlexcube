<form id="validation" class="form-inline form-validator" data-type="update" role="form" action="<?= WEBROOT ?>fichier/<?= ((isset($type->rowid)) ? "modifType" : "ajoutType") ?>" method="post">

    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['ajoutType']; ?></h4>
    </div>

    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">

                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="form-group" style="width: 100%;padding: 10px;">

                        <label for="fk_partenaire" class="control-label"><?php echo $this->lang['partenaire']; ?></label>
                        <select name="fk_partenaire" id="partenaire" class="form-control select2" style="width: 100%" required>
                            <?php foreach ($partenaires as $item) { ?>
                                <option <?= ($item->fk_partenaire == $type->fk_partenaire) ? "selected" : "" ?>  value="<?php echo $item->id; ?>"><?php echo $item->nom .'('. $item->code .')'; ?></option>
                            <?php } ?>
                        </select>


                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">

                        <label for="extension" class="control-label"><?php echo $this->lang['extention']; ?></label>

                        <select name="extension" id="extension" class="form-control select2" style="width: 100%" required>
                            <option  <?= ($item->extension === '.txt') ? "selected" : "" ?>  value=".txt">.txt</option>
                            <option <?= ($item->extension === '.xls') ? "selected" : "" ?> value=".xls">.xls</option>
                            <option <?= ($item->extension === '.PRN') ? "selected" : "" ?> value=".PRN">.PRN</option>
                            <option <?= ($item->extension === '.csv') ? "selected" : "" ?> value=".csv">.csv</option>
                        </select>

                    </div>

                    <?php if(isset($type->rowid)){  ?> <input type="hidden" name="rowid" value="<?= $type->rowid; ?>"><?php } ?>
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
