<form id="validation" class="form-inline form-validator" data-type="update" role="form" action="<?= WEBROOT ?>fichier/updateline" method="post">

    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['modifLineNoLoding']; ?></h4>
    </div>

    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="position" class="control-label"><?php echo $this->lang['matricule']; ?></label>
                        <input type="text" id="matricule" name="matricule" class="form-control" placeholder="<?php echo $this->lang['matricule']; ?>"
                               value="<?= (isset($MATRICULE)) ? $MATRICULE : '' ?>" style="width: 100%" required>

                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="position" class="control-label"><?php echo $this->lang['prenom_nom']; ?></label>
                        <input type="text" id="nom" name="nom" class="form-control" placeholder="<?php echo $this->lang['prenom_nom']; ?>"
                            readonly   value="<?= (isset($NOM)) ? $NOM : '' ?>" style="width: 100%" required>

                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="position" class="control-label"><?php echo $this->lang['numcompte']; ?></label>
                        <input type="text" id="numcompte" name="numcompte" class="form-control" placeholder="<?php echo $this->lang['numcompte']; ?>"
                               readonly  value="<?= (isset($COMPTE)) ? $COMPTE : ''?>" style="width: 100%" required>

                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="position" class="control-label"><?php echo $this->lang['montant']; ?></label>
                        <input type="text" id="montant" name="montant" class="form-control" placeholder="<?php echo $this->lang['montant']; ?>"
                               readonly  value="<?= (isset($MONTANT)) ? (intval($MONTANT )) : '' ?>" style="width: 100%" required>

                    </div>


                    <input type="hidden" name="idLine" value="<?= $idLine ;?>">
                    <input type="hidden" name="idFichier" value="<?= $idFichier ;?>">


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

<!--<script>
    $("#submit").attr("disabled", true);
    function verifieLine() {

        $(document).ready(function(){
            //$('#submit').prop('disabled', false);

            var de = parseInt($('#de').val());
            var a = parseInt($('#a').val()) ;
            if ( (a >= de) && (de > 0 ) && (a > 0)){
                $('#longueur').val(a - de + 1);
                $("#submit").attr("disabled", false);
            }else {
                $("#submit").attr("disabled", true);
            }



        })

    }

</script>-->