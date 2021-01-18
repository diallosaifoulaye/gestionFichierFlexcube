
<form id="validation" class="form-inline form-validator" data-type="update" role="form" action="<?php echo WEBROOT ?>transaction/updateValidation" method="post">

    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['txtmsgTtitle']; ?></h4>
    </div>

    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-1"></div>
                <div class="col-sm-10">
                    <div class="form-group" style="width: 100%;padding: 10px;">

                        <div class="alert alert-warning">
                            <a href="#" class="btn btn-xs btn-warning pull-right" style="font-size: 12px;"><?php echo ' # '.$latransaction->num_transac; ?></a>
                            <strong style="font-size: 15px; text-decoration: underline;"><?php echo $this->lang['txtmsgEchecTrans0']; ?></strong> <?php echo $this->lang['txtmsgEchecTrans1']; ?><br><br>
                            <?php echo $this->lang['txtmsgEchecTrans2'].' <strong>'.$latransaction->codeCollecteur.'</strong> ('.mb_strtoupper($latransaction->nom, 'UTF-8').' '.mb_strtolower($latransaction->prenom, 'UTF-8').')'; ?><br>
                            <?php echo $this->lang['agence'].' : <strong>'.mb_strtoupper($latransaction->agence, 'UTF-8').'</strong>'; ?><br>
                            <?php echo $this->lang['txtmsgEchecTrans3'].' <strong>'.$latransaction->code_client.'</strong>'; ?><br>
                            <?php echo $this->lang['txtmsgEchecTrans4'].' <strong>'.$latransaction->numcompte_client.'</strong>'; ?><br>
                            <?php echo $this->lang['txtmsgEchecTrans5'].' <strong>'.\app\core\Utils::getFormatMoney($latransaction->montant).'</strong>'; ?><br>
                            <?php echo ' ('.\app\core\Utils::ConvNumberLetter($latransaction->montant,'','').' '.$this->lang['txtDevise'].')'; ?><br>
                            <?php echo $this->lang['txtmsgEchecTrans6'].' <strong>'.\app\core\Utils::getDateFR($latransaction->date_transac).'</strong>'; ?><br>
                        </div>
                    </div>


                    <input type="hidden" name="idtransaction" value="<?php echo $latransaction->idtransaction; ?>">
                    <input type="hidden" id="flag_authorized" name="flag_authorized">
                    <div class="oaerror danger" id="MsgErreurSAF">
                        <strong><?php echo $this->lang['Msg_error']; ?></strong> - <?php echo $this->lang['txtErreNumTransact']; ?>
                    </div>
                    <br>
                    <div align="center" id="LebtnValider">
                        <button class="btn " id="ajoutNumSAF" style="background-color: #0a7242; color: #FFF;" type="button" onclick="displayBtnValid();"><i class="fa fa-check"></i> <?php echo $this->lang['txtmsgvaliderTrans']; ?></button>
                    </div>
                    <div align="center" id="numSAF" >
                        <br>
                        <label for="TransactionMeczy" class="control-label"><?php echo $this->lang['txtlblNumTransSAF']; ?>(*)</label>
                        &nbsp;&nbsp;<input type="text" name="TransactionMeczy" id="TransactionMeczy" style="width:40%; border-color: #fcf8e3; background-color: #fcf8e3; color: #9A0000; text-align: center; text-transform: uppercase;" autocomplete="off" placeholder="<?php echo $this->lang['txtlblNumTransSAF']; ?>" onblur="verifNumSAF()" required>
                        <label style="color: #FF0000; font-size: 11px; font-style: italic; font-weight: normal;"><?php echo $this->lang['txtlblNumTransSAFBis']; ?></label>
                    </div>
                </div>
                <div class="col-sm-1"></div>
            </div>
        </div>
    </div>

    <div class="modal-footer" id="divValider" hidden>
        <button class="btn btn-success confirm" id="boutton" data-form="my-form" type="button"><i class="fa fa-check"></i> <?php echo $this->lang['btnCorriger']; ?></button>
        <button class="btn btn-default" type="button" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo $this->lang['annuler']; ?> </button>
    </div>

</form>


<script>

    $(document).ready(function() {
        $('#numSAF').hide();
        $('#MsgErreurSAF').hide();
    });


    function displayBtnValid() {
        var x = document.getElementById("numSAF");
        if (x.style.display === 'none') {
            x.style.display = 'block';
        } else {
            x.style.display = 'none';
        }

    }

    function verifNumSAF() {
        var numSAF = document.getElementById('TransactionMeczy').value;

        if (numSAF.trim() != "") {
            $.ajax({
                type: "POST",
                data: {
                    numSAF:numSAF.trim(),
                },
                url: "<?php echo WEBROOT . 'transaction/getTransactionMeczy'; ?>",
                success: function (data) {

                    data1 = JSON.parse(data)

                    if(data1) {

                        var x = document.getElementById("LebtnValider");
                        var y = document.getElementById("divValider");
                        var z = document.getElementById("MsgErreurSAF");
                        x.style.display = 'none';
                        z.style.display = 'block';
                        y.style.display = 'none';

                        setTimeout(function() {
                            $('#MsgErreurSAF').fadeOut(6000);  //766776
                        }); // <-- time in milliseconds

                        //x.style.display = 'block';


                    }else{

                        var x = document.getElementById("LebtnValider");
                        var y = document.getElementById("divValider");
                        x.style.display = 'none';
                        y.style.display = 'block';

                    }
                }
            });



        }
    }


</script>





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
    .alert-warning {
        color: #8a6d3b;
        background-color: #fcf8e3;
        /*border-color: #faebcc;*/
        font-size: 15px;
    }
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 8px;
    }

    .oaerror {
        width: 60%; /* Configure it fit in your design  */
        margin: 0 auto; /* Centering Stuff */
        background-color: #FFFFFF; /* Default background */
        padding: 5px;
        border: 1px solid #eee;
        border-left-width: 5px;
        border-radius: 3px;
        margin: 0 auto;
        font-family: 'Open Sans', sans-serif;
        font-size: 14px;
        color: #D60000;
    }

    .danger {
        border-left-color: #d9534f; /* Left side border color */
        background-color: rgba(217, 83, 79, 0.1); /* Same color as the left border with reduced alpha to 0.1 */
    }

    .danger strong {
        color:  #d9534f;
    }
</style>

