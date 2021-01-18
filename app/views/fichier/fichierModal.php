<form id="validation" class="form-inline form-validator" enctype="multipart/form-data" data-type="update" role="form" action="<?= WEBROOT ?>fichier/traiterFichier" method="post">

    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['chargementFile']; ?></h4>
    </div>

    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">

                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="form-group" style="width: 100%;padding: 10px;">

                        <label for="profil" class="control-label"><?php echo $this->lang['choiceTxtFile']; ?><br></label>
                        <input required type="file" name="file" id="file" >

                        <span class="help-block with-errors"> </span>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="mois" class="control-label"><?php echo $this->lang['mois_comptable']; ?></label>
                        <select name="mois" id="mois" class="form-control select2" style="width: 100%" required>
                            <?php foreach ($tabMois as $item => $mois) { ?>
                                <option   <?= (intval(date('m')) === intval($item)) ? "selected" : "" ?>  value="<?php echo $item; ?>"><?php echo $mois; ?></option>
                            <?php } ?>
                        </select>

                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="mois" class="control-label"><?php echo $this->lang['annee_comptable']; ?></label>
                        <select name="annee" id="annee" class="form-control select2" style="width: 100%" required>
                            <?php foreach ($tabAnnee as $item => $annee) { ?>
                                <option   <?= (intval(date('Y')) === intval($item)) ? "selected" : "" ?>  value="<?php echo $item; ?>"><?php echo $annee; ?></option>
                            <?php } ?>
                        </select>
                    </div>



                    <div class="form-group" style="width: 100%;padding: 10px;">

                        <label for="fk_partenaire" class="control-label"><?php echo $this->lang['partenaire']; ?>
                            <span id="message" style="color: red; display: none">Veuillez d'abord paramétrer ce type de fichier associé au partenaire</span>
                            <span id="message1" style="color: green; display: none">Le fichier sera traité suivant le paramétrage réservé au partenaire séléctionné </span>
                        </label>
                        <select name="fk_partenaire" id="partenaire" class="form-control select2" onchange="verifieParametrage()" style="width: 100%" required>
                            <option value=""><?php echo $this->lang['select_partenaire'];?></option>
                            <?php foreach ($partenaires as $item) { ?>
                                <option  value="<?php echo $item->id; ?>"><?php echo $item->nom .'('. $item->code .')'; ?></option>
                            <?php } ?>
                        </select>


                    </div>
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
    $("#submit").attr("disabled", true);

    function verifieParametrage()
    {
        var fileName = $('#file').val().replace(/C:\\fakepath\\/i, '') ;
        var partenaire = $('#partenaire').val() ;
        $.ajax({
            type: "POST",
            url: "<?= WEBROOT.'fichier/getparametrage'; ?>",

            data: {'partenaire':partenaire, 'nomFile':fileName} ,
            success: function(data) {
                data = parseInt(JSON.parse(data)) ;
                if (data == 0){
                    $("#submit").attr("disabled", true);
                    $('#message').show();
                    $('#message1').hide();
                }else if (data == 1){
                    $('#message').hide();

                    $('#message1').show();
                    $("#submit").attr("disabled", false);
                }

                //document.getElementById("fk_commune").innerHTML = collect;

            }
        });

    }
</script>
<script>
    $(".select2").select2();

</script>