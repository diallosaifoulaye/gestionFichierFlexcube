
<form id="validation" class="form-inline form-validator" data-type="update" role="form" action="<?= WEBROOT ?>utilisateur/<?= ((isset($utilisateur->id)) ? "modifUtilisateur" : "ajoutUtilisateur") ?>" method="post">

    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['titleDetails']; ?></h4>
    </div>

    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-1"></div>
                <div class="col-sm-10">
                    <fieldset class="fieldsetDetails">
                        <legend class="legendDetails"><?php echo mb_strtoupper($utilisateur->nom, "UTF-8").' '.ucfirst($utilisateur->prenom); ?></legend>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="nom" class="control-label lblcss"><?php echo $this->lang['labemail']; ?> : </label></br>
                        <label class="labelDetails"><?php echo ucfirst($utilisateur->email); ?></label>
                    </div>




                    <?php if($utilisateur->fk_profil == 2){ ?>
                    </br>
                     <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="nom" class="control-label lblcss"><?php echo $this->lang['labcodeCollect']; ?> : </label></br>
                        <label class="labelDetails"><?php echo ucfirst($utilisateur->code_collecteur); ?></label>
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="nom" class="control-label lblcss"><?php echo $this->lang['labplafond']; ?>  </label>&nbsp;<i class="fa fa-money " aria-hidden="true" style="color:#0a7242;"></i></br>


                        <div class="row">
                            <div class="col-sm-2" style=" background-color: #F5FFFA;" >&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-circle-right" aria-hidden="true" style="color: #097242;"></i><span style="font-size: 11px; font-weight: bold; color: #097242;">&nbsp;&nbsp;<?php echo $this->lang['lblDepot']; ?></span>
                             </div>
                            <div class="col-sm-4" style=" background-color: #F5FFFA;" ><span style="font-size: 11px; font-weight: normal; color: #097242; vertical-align: bottom;"><?php echo $this->lang['mntMIN']; ?></span><span style="font-size: 18px; font-weight: bold; color: #097242; float: right;"><?php echo \app\core\Utils::getFormatMoney($utilisateur->minDepot);?></span></div>
                            <div class="col-sm-4" style=" background-color: #F5FFFA;"><span style="font-size: 11px; font-weight: normal; color: #097242; vertical-align: bottom;"><?php echo $this->lang['mntMAX']; ?></span><span style="font-size: 18px; font-weight: bold; color: #097242; float: right;"><?php echo \app\core\Utils::getFormatMoney($utilisateur->maxDepot);?></span></div>
                        </div>

                        <div class="row">
                            <div class="col-sm-2" style=" background-color: #FDF5E6;">&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-circle-right" aria-hidden="true" style=" color: #097242;"></i><span style="font-size: 11px; font-weight: bold; color: #D2691E;">&nbsp;&nbsp;<?php echo $this->lang['lblRetrait']; ?> </span>
                                </div>
                            <div class="col-sm-4" style=" background-color: #FDF5E6;" ><span style="font-size: 11px; font-weight: normal; color: #D2691E; vertical-align: bottom;"><?php echo $this->lang['mntMIN']; ?></span><span style="font-size: 18px; font-weight: bold; color: #D2691E; float: right;"><?php echo \app\core\Utils::getFormatMoney($utilisateur->minRetrait);?></span></div>
                            <div class="col-sm-4" style=" background-color: #FDF5E6;"><span style="font-size: 11px; font-weight: normal; color: #D2691E; vertical-align: bottom;"><?php echo $this->lang['mntMAX']; ?></span><span style="font-size: 18px; font-weight: bold; color: #D2691E; float: right;"><?php echo \app\core\Utils::getFormatMoney($utilisateur->maxRetrait);?></span></div>
                        </div>


                    </div>
                    <?php }?>








                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="nom" class="control-label lblcss"><?php echo $this->lang['agence']; ?> : </label></br>
                        <label class="labelDetails"><?php echo ucfirst($utilisateur->label); ?></label>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="nom" class="control-label lblcss"><?php echo $this->lang['profils']; ?> : </label></br>
                        <label class="labelDetails"><?php echo ucfirst($utilisateur->profil); ?></label>
                    </div>

                    <?php if(isset($utilisateur->id)) { ?> <input type="hidden" name="id" value="<?= $utilisateur->id; ?>"><?php } ?>
                    <?php if(!isset($utilisateur->id)) { ?> <input type="hidden" id="flag_authorized" name="flag_authorized"> <?php } ?>
                </div>
                </fieldset>
                <div class="col-sm-1"></div>



            </div>
        </div>
    </div>

    <div class="modal-footer">
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
        if (parseInt(a) !== 2 && parseInt(a) !== 3){
            $("#flag_authorized").val('1');
            $("#codecollecteur").css("display","none");
            $("#code_collecteur").removeAttr("name");
        }
        if (parseInt(a) === 2){
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
        //alert(name+' '+value);
    }


</script>

<script type="text/javascript">
    $(document).ready(function () {
        $( "#boutton" ).click(function() {
            $( "#validation" ).submit();
        });
    });
</script>
<style>
    .labelDetails {
        color: #000;
        font-weight: normal;
        display: block;
        width: 100%;
        font-size: 15px;
        margin: 5px;
    }

    .fieldsetDetails {
        font-family: sans-serif;
        border: 3px solid #0a7242;
        background: #F5F5F5;
        border-radius: 5px;
        padding: 5px;
    }
    .fieldsetDetails .legendDetails {
        /*padding: 0.2em 0.5em;
        border:1px solid green;
        color:green;
        font-size:15px;
        text-align:right;*/
        width: auto;
        background: #0a7242;
        color: #fff;
        padding: 5px 10px ;
        font-size: 16px;
        border-radius: 5px;
        box-shadow: 0 0 0 5px #F5F5F5;
        margin-left: 20px;
    }
    .lblcss{
        color: #097242;
        font-weight: bold;
    }
</style>