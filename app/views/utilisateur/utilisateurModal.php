
<form id="validation" class="form-inline form-validator" data-type="update" role="form" action="<?= WEBROOT ?>utilisateur/<?= ((isset($utilisateur->id)) ? "modifUtilisateur" : "ajoutUtilisateur") ?>" method="post">

    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?= ((isset($utilisateur->id)) ? $this->lang['btnEditUser'] : $this->lang['btnAjouterUtilisateur']) ?></h4>
    </div>

    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="fk_profil" class="control-label"><?php echo $this->lang['profils'].'   (*)'; ?></label>
                        <select name="fk_profil" id="fk_profil" class="form-control select2" style="width: 100%" onchange="authorized(this.value);">
                            <option value=""><?php echo $this->lang['select_profil']; ?></option>
                            <?php foreach ($profil as $item) { ?>
                                <option <?= ($utilisateur->fk_profil == $item->id) ? "selected" : "" ?> value="<?= $item->id ?>"><?= $item->profil ?></option>
                            <?php } ?>
                        </select>
                        <span class="help-block with-errors"> </span>
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="fk_profil" class="control-label"><?php echo $this->lang['agence']; ?> (*)</label>
                        <select name="agence" id="agence" class="form-control select2" style="width: 100%" required>
                            <option value=""><?php echo $this->lang['select_agence']; ?></option>
                            <?php foreach ($agence as $item) { ?>
                                <option <?= ($utilisateur->agence == $item->rowid) ? "selected" : "" ?> value="<?= $item->rowid ?>"><?= $item->label ?></option>
                            <?php } ?>
                        </select>
                        <span class="help-block with-errors"> </span>
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px; display: none" id="codecollecteur">
                        <label for="code_collecteur" class="control-label"><?php echo $this->lang['labcode']; ?> (*).</label>
                        <input type="text" id="code_collecteur" name="code_collecteur" required onchange="verifeDoublon(this)" class="form-control" placeholder="<?php echo $this->lang['labcode']; ?>"
                               value="<?= $utilisateur->code_collecteur; ?>" style="width: 100%" required>
                        <span id="msgcode_collecteur"></span>

                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="email" class="control-label"><?php echo $this->lang['labemail']; ?> (*)</label>
                        <input type="email" id="email" onchange="verifeDoublon(this)" name="email" class="form-control" placeholder="<?php echo $this->lang['labemail']; ?>"
                               value="<?= $utilisateur->email; ?>" style="width: 100%" required>
                        <span id="msgemail"></span>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="prenom" class="control-label"><?php echo $this->lang['labprenom']; ?> (*)</label>
                        <input type="text" id="prenom" name="prenom" class="form-control" placeholder="<?php echo $this->lang['labprenom']; ?>"
                               value="<?= $utilisateur->prenom; ?>" style="width: 100%" required>
                        <span class="help-block with-errors"> </span>
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="nom" class="control-label"><?php echo $this->lang['labnom']; ?> (*)</label>
                        <input type="text" id="nom" name="nom" class="form-control" placeholder="<?php echo $this->lang['labnom']; ?>"
                               value="<?= $utilisateur->nom; ?>" style="width: 100%" required>
                        <span class="help-block with-errors"> </span>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="nom" class="control-label"><?php echo $this->lang['user_flexcube_id']; ?> (*)</label>
                        <input type="text" id="user_flexcube_id" name="user_flexcube_id" class="form-control" placeholder="<?php echo $this->lang['user_flexcube_id']; ?>"
                               value="<?= $utilisateur->user_flexcube_id; ?>" style="width: 100%" required>
                        <span class="help-block with-errors"> </span>
                    </div>


                    <?php if($utilisateur->fk_profil == 2){ ?>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="code_collecteur" class="control-label"><?php echo $this->lang['labcodeCollect']; ?> (*)</label>
                        <input type="text" id="code_collecteur" name="code_collecteur" class="form-control" placeholder="<?php echo $this->lang['labcodeCollect']; ?>"
                               value="<?= $utilisateur->code_collecteur; ?>" style="width: 100%" required >
                        <span class="help-block with-errors"> </span>
                        <input type="hidden" name="fk_profil" value="<?= $utilisateur->fk_profil; ?>">
                    </div>



                    <div class="form-group" style="width: 100%;padding: 10px;">


                        <fieldset>
                            <legend class="control-label" style="color: #333; font-size: 15px; font-weight: 500;"><?php echo $this->lang['labplafond']; ?></legend>
                            <br>
                            <label for="depot" class="control-label"><?php echo $this->lang['lblDepot']; ?> (*)</label><br>
                            <span style="font-size: 11px; font-weight: normal; color: #097242; vertical-align: bottom;" id="lblmntMIN"><?php echo $this->lang['mntMIN']; ?></span><br>
                            <input type="number"  onkeyup="myNumberSupDepot(), letterConvert()" onkeypress="return isNumberKey(event)" id="minDepot" name="minDepot" class="form-control" placeholder="<?php echo $this->lang['mntMIN']; ?>"
                                   value="<?= $utilisateur->minDepot; ?>" style="width: 100%; height: 32px;" required /><br>
                            <span style="font-size: 11px; font-weight: normal; color: #097242; vertical-align: bottom;" id="lblmntMAX"><?php echo $this->lang['mntMAX']; ?></span><br>
                            <input type="number" onkeyup="myNumberSupDepot(), letterConvertMax()" onkeypress="return isNumberKey(event)" id="maxDepot" name="maxDepot" class="form-control" placeholder="<?php echo $this->lang['mntMAX']; ?>"
                                   value="<?= $utilisateur->maxDepot; ?>" style="width: 100%; height: 32px;" required /><br><br>
                            <label for="code_collecteur" class="control-label"><?php echo $this->lang['lblRetrait']; ?> (*)</label><br>
                            <span style="font-size: 11px; font-weight: normal; color: #D2691E; vertical-align: bottom;" id="lblmntMINR"><?php echo $this->lang['mntMIN']; ?></span><br>
                            <input type="number" onkeyup="myNumberSupRetrait(), letterConvertMinR()" onkeypress="return isNumberKey(event)" id="minRetrait" name="minRetrait" class="form-control" placeholder="<?php echo $this->lang['mntMIN']; ?>"
                                   value="<?= $utilisateur->minRetrait; ?>" style="width: 100%; height: 32px;" required /><br>
                            <span style="font-size: 11px; font-weight: normal; color: #D2691E; vertical-align: bottom;" id="lblmntMAXR"><?php echo $this->lang['mntMAX']; ?></span><br>
                            <input type="number" onkeyup="myNumberSupRetrait(), letterConvertMaxR()" onkeypress="return isNumberKey(event)" id="maxRetrait" name="maxRetrait" class="form-control" placeholder="<?php echo $this->lang['mntMAX']; ?>"
                                   value="<?= $utilisateur->maxRetrait; ?>" style="width: 100%; height: 32px;" required />
                        </fieldset>


                        <span class="help-block with-errors" id="mntNo"> </span>
                    </div>



                    <?php }?>




                    <?php if(isset($utilisateur->id)) { ?> <input type="hidden" name="id" value="<?= $utilisateur->id; ?>"><?php } ?>
                    <?php if(!isset($utilisateur->id)) { ?> <input type="hidden" id="flag_authorized" name="flag_authorized"> <?php } ?>
                </div>
                <div class="col-sm-3"></div>

            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button class="btn btn-success confirm" id="boutton" data-form="my-form" type="button"><i class="fa fa-check"></i> <?php echo $this->lang['btnValider']; ?></button>
        <button class="btn btn-default" type="button" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo $this->lang['btnFermer']; ?> </button>
    </div>

</form>
<script>
    $(".select2").select2();
</script>
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

    function authorized(a) {
        console.log('0==> '+a);
        if (parseInt(a) !== 2 && parseInt(a) !== 3){
            $("#flag_authorized").val('1');
            $("#codecollecteur").css("display","none");
            $("#code_collecteur").removeAttr("name");
        }
        if (parseInt(a) === 2){
            console.log('1==> '+a);
            $("#flag_authorized").val('0');
            $("#codecollecteur").css("display","block");
        }
        if (parseInt(a) === 3){
            $("#flag_authorized").val('2');
            $("#codecollecteur").css("display","block");
        }
    }
</script>
<script>


    function verifeDoublon(element) {
       // alert(element) ;
        var nom = element.name ;
        var valeur = element.value ;
        $.ajax({
            type: 'POST',
            data:{ champ : nom, valeur:valeur },
            url: '<?php echo WEBROOT ?>utilisateur/verifie',
            success: function(data) {
                var donnees = JSON.parse(data);
                if (parseInt(donnees) === 1) {

                    $('#msg'+nom).html("<p style='color:#F00;display: inline; #F00'>Cet email est déjà utilisé</p>");
                    $("#boutton").attr('disabled','disabled');
                }
                else {
                    $('#msg'+nom).html("");
                    $("#boutton").removeAttr('disabled');
                }
            },
            error: function() {
                alert('La requête n\'a pas abouti'); }

        });
        //alert(name+' '+value);  \app\core\Utils::ConvNumberLetter($transactT[0]->mnt,'','')
    }


</script>

<script type="text/javascript">

    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    function myNumberSupDepot() {
        var min =  $("#minDepot").val();
        var max =  $("#maxDepot").val();

        if( parseInt(min) > parseInt(max)){
            $("#mntNo").css("display","block");
            $("#boutton").attr('disabled','disabled');
            $("#minDepot").css("border", "#F00 solid 1px");
            $('#mntNo').html("<p style='color:#F00;display: inline; #F00'>Minimum dépôt supérieur au Maximum.</p>");
        }else {
            $("#boutton").removeAttr('disabled');
            $("#mntNo").css("display","none");
            $("#minDepot").css("border", "#e4e7ea solid 1px");
        }
    }

    function myNumberSupRetrait() {
        var min =  $("#minRetrait").val();
        var max =  $("#maxRetrait").val();

        console.log(max)

        if( parseInt(min) > parseInt(max)){
            $("#mntNo").css("display","block");
            $("#boutton").attr('disabled','disabled');
            $("#minRetrait").css("border", "#F00 solid 1px");
            $('#mntNo').html("<p style='color:#F00;display: inline; #F00'>Minimum retrait supérieur au Maximum.</p>");
        }else {
            $("#boutton").removeAttr('disabled');
            $("#mntNo").css("display","none");
            $("#minRetrait").css("border", "#e4e7ea solid 1px");
        }
    }

   /* function letterConvert() {
        var min =  $("#minDepot").val();
        console.log(min);

        var n = " //echo \app\core\Utils::ConvNumberLetter("+min+",'','') ?>";
        console.log(n);
        $("#lblmntMIN").html(min);

    }*/


</script>


<script>

    /*--------------------------MIN DEPÔT-------------------------------*/

    function letterConvert() {

        var valeur =  $("#minDepot").val();

        $.ajax({
            type: 'POST',
            data:{ valeur:valeur },
            url: '<?php echo WEBROOT ?>utilisateur/convertToLetter',
            success: function(data) {

                if (!$.trim(data)){
                    console.log("What follows is blank: " + data);
                }
                else{
                    var lbl = '<?php echo $this->lang['mntMINL'] ;?>';
                    lbl = lbl+data;
                    $("#lblmntMIN").html(lbl);
                }

            },
            error: function() {
                alert('La requête n\'a pas abouti'); }

        });
    }
   /*---------------------------MAX DEPÔT------------------------------*/
    function letterConvertMax() {

        var valeur =  $("#maxDepot").val();

        $.ajax({
            type: 'POST',
            data:{ valeur:valeur },
            url: '<?php echo WEBROOT ?>utilisateur/convertToLetter',
            success: function(data) {

                if (!$.trim(data)){
                    console.log("What follows is blank: " + data);
                }
                else{
                    var lbl = '<?php echo $this->lang['mntMAXL'] ;?>';
                    lbl = lbl+data;
                    $("#lblmntMAX").html(lbl);
                }

            },
            error: function() {
                alert('La requête n\'a pas abouti'); }

        });
    }
    /*---------------------------MIN RETRAIT------------------------------*/

    function letterConvertMinR() {

        var valeur =  $("#minRetrait").val();

        $.ajax({
            type: 'POST',
            data:{ valeur:valeur },
            url: '<?php echo WEBROOT ?>utilisateur/convertToLetter',
            success: function(data) {

                if (!$.trim(data)){
                    console.log("What follows is blank: " + data);
                }
                else{
                    var lbl = '<?php echo $this->lang['mntMINL'] ;?>';
                    lbl = lbl+data;
                    $("#lblmntMINR").html(lbl);
                }

            },
            error: function() {
                alert('La requête n\'a pas abouti'); }

        });
    }

    /*---------------------------MAX RETRAIT------------------------------*/

    function letterConvertMaxR() {

        var valeur =  $("#maxRetrait").val();

        $.ajax({
            type: 'POST',
            data:{ valeur:valeur },
            url: '<?php echo WEBROOT ?>utilisateur/convertToLetter',
            success: function(data) {

                if (!$.trim(data)){
                    console.log("What follows is blank: " + data);
                }
                else{
                    var lbl = '<?php echo $this->lang['mntMAXL'] ;?>';
                    lbl = lbl+data;
                    $("#lblmntMAXR").html(lbl);
                }

            },
            error: function() {
                alert('La requête n\'a pas abouti'); }

        });
    }


</script>




<style>
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>

<script type="text/javascript">
    $(document).ready(function () {
        $( "#boutton" ).click(function() {
            $( "#validation" ).submit();
        });
    });
</script>