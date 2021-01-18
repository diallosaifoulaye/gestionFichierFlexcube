<?php var_dump(); ?>
<form id="validation" class="form-inline form-validator" data-type="update" role="form" action="<?php echo WEBROOT; ?>carte/<?= ((isset($distribution->rowid)) ? "modifDistribution" : "ajoutDistribution") ?>" method="post">

<div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?= ((isset($distribution->rowid)) ? $this->lang['btnModifierDistribution'] : $this->lang['btnAjouterDistribution']) ?></h4>
    </div>

    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>

                <div class="col-sm-6">

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="fk_agence_dest" class="control-label"><?php echo $this->lang['agence']; ?></label>
                        <select name="fk_agence_dest" id="fk_agence_dest" class="form-control select2" style="width: 100%" required>
                            <option value=""><?php echo $this->lang['selectagence'];?></option>
                            <?php foreach ($agence as $item) { ?>
                                <option <?= ($distribution->fk_agence_dest == $item->rowid) ? "selected" : "" ?> value="<?php echo $item->rowid; ?>"><?php echo $item->label; ?></option>
                            <?php } ?>
                        </select>
                        <span class="help-block with-errors"> </span>
                    </div>

                    <?php if(isset($distribution->rowid)) {  ?>
                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="fk_lot_origine" class="control-label"><?php echo $this->lang['lotorigine']; ?></label>
                            <select name="fk_lot_origine" id="fk_lot_origine" class="form-control select2" style="width: 100%" required onchange="getSerial()">
                                <option value=""><?php echo $this->lang['selectlot'];?></option>
                                <?php foreach ($lotorigneSS as $item) { ?>
                                    <option <?= ($distribution->fk_lot_origine == $item->id) ? "selected" : "" ?> value="<?php echo $item->id; ?>"><?php echo ($item->num_fin-$item->stock +1).'=>'.$item->num_fin.'-'.'Nb cartes restantes:'.$item->stock; ?></option>
                                <?php } ?>
                            </select>
                            <span class="help-block with-errors"> </span>
                        </div>
                    <?php } ?>

                    <?php if(!isset($distribution->rowid)) { ?>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="fk_lot_origine" class="control-label"><?php echo $this->lang['lotorigine']; ?></label>
                        <select name="fk_lot_origine" id="fk_lot_origine" class="form-control select2" style="width: 100%" required onchange="getSerial()">
                            <option value=""><?php echo $this->lang['selectlot'];?></option>
                            <?php foreach ($lotorigne as $item) { ?>
                                <option <?= ($distribution->fk_lot_origine == $item->id) ? "selected" : "" ?> value="<?php echo $item->id; ?>"><?php echo ($item->num_fin-$item->stock +1).'=>'.$item->num_fin.'-'.'Nb cartes restantes:'.$item->stock; ?></option>
                            <?php } ?>
                        </select>
                        <span class="help-block with-errors"> </span>
                    </div>
                    <?php } ?>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="nombre_carte" class="control-label"><?php echo $this->lang['nbcartetodistribuer']; ?></label>
                        <input type="text" id="nombre_carte" value="<?= ((isset($distribution->rowid)) ? ($distribution->num_fin - $distribution->num_debut)+1 : 0) ?>" class="form-control" placeholder="<?php echo $this->lang['nbcartetodistribuer']; ?>"
                                style="width: 100%" onkeypress="return IsNumeric(event);" required>
                        <span class="help-block with-errors"> </span>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="num_debut" class="control-label"><?php echo $this->lang['num_debut_carte']; ?></label>
                        <input type="text" id="num_debut" name="num_debut" value="<?php echo $distribution->num_debut; ?>" readonly class="form-control" placeholder="<?php echo $this->lang['num_debut_carte']; ?>" style="width: 100%" required>
                        <span class="help-block with-errors"> </span>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="num_fin" class="control-label"><?php echo $this->lang['num_fin_carte']; ?></label>
                        <input type="text" id="num_fin" name="num_fin" class="form-control" placeholder="<?php echo $this->lang['num_fin_carte']; ?>"
                               value="<?php echo $distribution->num_fin; ?>" style="width: 100%" required readonly>
                        <span class="help-block with-errors"> </span>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="date_distribution" class="control-label"><?php echo $this->lang['date_dist_carte']; ?></label>
                        <input type="date" id="date_distribution" name="date_distribution" class="form-control" placeholder="<?php echo $this->lang['date_dist_carte']; ?>"
                               value="<?php echo $distribution->date_distribution; ?>" style="width: 100%" required>
                        <span class="help-block with-errors"> </span>
                    </div>

                    <?php if(isset($distribution->rowid)) {  ?> <input type="hidden" name="id" value="<?= $distribution->rowid; ?>"><?php } ?>
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

    function getSerial() {
        var valueLot= $("#fk_lot_origine").val();
        if(valueLot !== ''){
            var stringsearch=$( "#fk_lot_origine option:selected" ).text();
            var stringsearch1= stringsearch.split('-');
            var recup1 = stringsearch1[0];
            var recup2 = stringsearch1[1];
            var serial=recup1.split('=>');
            var debut=serial[0];
            var fin=serial[1];
            var stock=recup2.split(':');
            var nbcarte=stock[1];
            document.getElementById('nombre_carte').value = nbcarte;
            document.getElementById('num_debut').value = debut;
            document.getElementById('num_fin').value = fin;
        }
            else{
            document.getElementById('nombre_carte').value = '';
            document.getElementById('num_debut').value = '';
            document.getElementById('num_fin').value = '';

        }

    }

    $("#nombre_carte").keyup(function(){
        var nb_carte_dist  = parseInt($("#nombre_carte").val());
        var num_startString  = $("#num_debut").val();
        var lenghtStart=num_startString.length
        var num_start  = parseInt($("#num_debut").val());
        if (nb_carte_dist >0){
            var num_end_end = parseInt(nb_carte_dist+num_start-1);
            var endString = num_end_end.toString();
            var end=endString.padStart(lenghtStart,'0');
            $('#num_fin').val(end);
        }
        // else {
        //   swal({
        //     title: "<?//= $this->lang['distcarte']; ?>",
        //   text: "<?//= $this->lang['distwarning']; ?>",
        // type: "warning"
        //});
        //}
    });

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

<script type="text/javascript">
    var specialKeys = new Array();
    specialKeys.push(8); //Backspace
    function IsNumeric(e) {
        var keyCode = e.which ? e.which : e.keyCode
        var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
        /*document.getElementById("error").style.display = ret ? "none" : "inline";*/
        return ret;
    }
</script>