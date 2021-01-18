<form id="validation" class="form-inline form-validator" data-type="update" role="form" action="<?= WEBROOT ?>fichier/updateModificationFormat" method="post">

    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['modifDescription']; ?></h4>
    </div>

    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="position" class="control-label"><?php echo $this->lang['position']; ?></label>
                        <input type="text" id="position" readonly name="position" class="form-control" placeholder="<?php echo $this->lang['position']; ?>"
                               value="<?= (isset($colonne->position)) ? intval($colonne->position ) : 1 ?>" style="width: 100%" required>

                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="libelle" class="control-label"><?php echo $this->lang['nom_colonne']; ?></label>
                        <select name="libelle" id="libelle" class="form-control select2" style="width: 100%" required>
                            <?php foreach ($libelles as $item) { ?>
                                <option  <?= ($item->libelle === $colonne->libelle) ? "selected" : "" ?>   value="<?php echo $item->libelle; ?>"><?php echo $item->libelle; ?></option>
                            <?php } ?>
                        </select>
                        <span class="help-block with-errors"> </span>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="libelle" class="control-label"><?php echo $this->lang['type']; ?></label>
                        <select name="type" id="type" class="form-control select2" style="width: 100%" required>
                            <option <?= ($item->type === $colonne->type) ? "selected" : "" ?>  value="2">Alpha Numeric</option>
                            <option  value="1">Numeric</option>

                        </select>
                        <span class="help-block with-errors"> </span>
                    </div>



                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="de" class="control-label"><?php echo $this->lang['de']; ?></label>
                        <input type="number" id="de"  value="<?= (isset($colonne->de)) ? ($colonne->de) : 1 ?>" name="de" class="form-control" placeholder="<?php echo $this->lang['de']; ?>"
                               style="width: 100%" required>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="longueur" class="control-label"><?php echo $this->lang['a']; ?></label>
                        <input type="number"  value="<?= (isset($colonne->a)) ? ($colonne->a) : 1 ?>"  id="a" name="a" class="form-control" placeholder="<?php echo $this->lang['a']; ?>"
                               style="width: 100%" required>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="longueur" class="control-label"><?php echo $this->lang['longueur']; ?></label>
                        <input type="number"  id="longueur" value="<?= (isset($colonne->longueur)) ? ($colonne->longueur) : 1 ?>" name="longueur" class="form-control" placeholder="<?php echo $this->lang['longueur']; ?>"
                               style="width: 100%" required >
                        <span class="help-block with-errors"> </span>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="commentaire" class="control-label"><?php echo $this->lang['commentaire']; ?></label>
                        <input type="text" id="commentaire" value="<?= (isset($colonne->commentaire)) ? ($colonne->commentaire) : '' ?>" name="commentaire" class="form-control" placeholder="<?php echo $this->lang['commentaire']; ?>"
                               style="width: 100%">
                    </div>
                    <input  type="hidden" name="idTypeFichier" value="<?= $colonne->fk_type_fichier ;?>">
                    <input type="hidden" name="rowid" value="<?= $colonne->rowid ;?>">


                </div>
                <div class="col-sm-3"></div>

            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button class="btn btn-success confirm" data-form="my-form" id="submit" type="submit"><i class="fa fa-check"></i> <?php echo $this->lang['btnValider']; ?>
        </button>
        <button class="btn btn-default" type="button" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo $this->lang['btnFermer']; ?> </button>
    </div>

</form>

<script>
    //$("#submit").attr("disabled", true);
    function calculPosition() {

        $(document).ready(function(){
            //$('#submit').prop('disabled', false);

            var de = parseInt($('#de').val());
            var a = parseInt($('#a').val()) ;
            if ( (a > de) && (de > 0 ) && (a > 0)){
                $('#longueur').val(a - de + 1);
                $("#submit").attr("disabled", false);
            }else {
                $("#submit").attr("disabled", true);
            }



        })

    }

</script>