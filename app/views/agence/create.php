<form id="validation" class="form-inline form-validator" data-type="update" role="form" action="<?= WEBROOT ?>agence/<?= ((isset($agence->rowid)) ? "edit" : "create") ?>" method="post">

    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?= ((isset($agence->rowid)) ? $this->lang['agence_edit'] : $this->lang['agence_new']) ; ?></h4>
    </div>

    <div class="modal-body">
        <div class="container-fluid">

<div class="col-sm-1"></div>
                <div class="row ">

                        <div class="form-group" style="width: 40%;padding: 10px;">
                            <label for="code" class="control-label"><?php echo $this->lang['thlibCode']; ?> <span style="color: #9A0000;">( * )</span></label>
                            <input type="text" id="code" name="code" class="form-control" placeholder="<?php echo $this->lang['thlibCode']; ?>"
                                   value="<?= $agence->code; ?>" style="width: 100%" required  >
                            <span class="help-block with-errors"> </span>
                        </div>


                        <div class="form-group" style="width: 40%;padding: 10px;">
                            <label for="label" class="control-label"><?php echo $this->lang['agence_libelleBis']; ?> <span style="color: #9A0000;">( * )</span></label>
                            <input type="text" id="label" name="label" class="form-control" placeholder="<?php echo $this->lang['agence_libelle']; ?>"
                                   value="<?= $agence->label; ?>" style="width: 100%" required>
                            <span class="help-block with-errors"> </span>
                        </div>

                </div>
            <div class="col-sm-1"></div>
            <div class="row">
                <div class="form-group" style="width: 40%;padding: 10px;">
                    <label for="responsable" class="control-label"><?php echo $this->lang['agence_resp']; ?> <span style="color: #9A0000;">( * )</span></label>
                    <input type="text" id="responsable" name="responsable" class="form-control" placeholder="<?php echo $this->lang['agence_resp']; ?>"
                           value="<?= $agence->responsable; ?>" style="width: 100%" required>
                    <span class="help-block with-errors"> </span>
                </div>
                <div class="form-group" style="width: 40%;padding: 10px;">
                    <label for="tel" class="control-label"><?php echo $this->lang['tel_four']; ?> <span style="color: #9A0000;">( * )</span></label>
                    <input type="tel" id="tel" name="tel" class="form-control" placeholder="<?php echo $this->lang['tel_four']; ?>"
                           value="<?= $agence->tel; ?>" style="width: 100%" required>
                    <span class="help-block with-errors"> </span>
                </div>
            </div>
            <div class="col-sm-1"></div>
            <div class="row">
                <div class="form-group" style="width: 40%;padding: 10px;">
                    <label for="email" class="control-label"><?php echo $this->lang['email_four']; ?> <span style="color: #9A0000;">( * )</span></label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="<?php echo $this->lang['email_four']; ?>"
                           value="<?= $agence->email; ?>" style="width: 100%" required>
                    <span class="help-block with-errors"> </span>
                </div>

                <?php if(isset($agence->rowid)){ ?>
                    <div class="form-group" style="width: 40%;padding: 10px;">
                        <label for="fk_profil" class="control-label"><?php echo $this->lang['labregion']; ?> <span style="color: #9A0000;">( * )</span></label>
                        <select  id="region_rowid"  class="select2 form-control " style="width: 100%" onchange="getDepartementByRegion()">
                            <option value=""><?php echo $this->lang['select_region'];?></option>
                            <?php foreach ($regions as $item) { ?>
                                <option value="<?= $item->rowid; ?>" <?php if($agence->reg === $item->label) echo 'selected="selected"'; ?>><?= $item->label; ?></option>
                            <?php } ?>
                        </select>
                        <span class="help-block with-errors"> </span>
                    </div>
                <?php } ?>

                <?php if(!isset($agence->rowid)){ ?>
                    <div class="form-group" style="width: 40%;padding: 10px;">
                        <label for="fk_profil" class="control-label"><?php echo $this->lang['labregion']; ?> <span style="color: #9A0000;">( * )</span></label>
                        <select  id="region_rowid"  class="select2 form-control " style="width: 100%" onchange="getDepartementByRegion()">
                            <option value=""><?php echo $this->lang['select_region'];?></option>
                            <?php foreach ($region as $item) { ?>
                                <option  value="<?= $item->rowid ?>"><?= $item->label ?></option>
                            <?php } ?>
                        </select>
                        <span class="help-block with-errors"> </span>
                    </div>
                <?php } ?>


            </div>
            <div class="col-sm-1"></div>
            <div class="row">
                <?php if(isset($agence->rowid)){ ?>

                <div class="form-group" style="width: 40%;padding: 10px;">
                    <label for="fk_profil" class="control-label"><?php echo $this->lang['labdept']; ?> <span style="color: #9A0000;">( * )</span></label>
                    <select  id="dept" disabled="disabled" class="form-control select2" style="width: 100%" onchange="getCommuneBydepartement()">
                        <option value=""><?php echo $this->lang['select_dept'];?></option>
                        <?php foreach ($dpts as $item) { ?>
                            <option value="<?= $item->rowid; ?>" <?php if($agence->dept === $item->label) echo 'selected="selected"'; ?>><?= $item->label; ?></option>
                        <?php } ?>
                    </select>
                    <span class="help-block with-errors"> </span>
                </div>

                <?php } ?>

                <?php if(!isset($agence->rowid)){ ?>

                <div class="form-group" style="width: 40%;padding: 10px;">
                    <label for="fk_profil" class="control-label"><?php echo $this->lang['labdept']; ?> <span style="color: #9A0000;">( * )</span></label>
                    <select  id="dept" disabled="disabled" class="form-control select2" style="width: 100%" onchange="getCommuneBydepartement()">
                        <option value=""><?php echo $this->lang['select_dept'];?></option>
                    </select>
                    <span class="help-block with-errors"> </span>
                </div>

                <?php } ?>

                <?php if(isset($agence->rowid)){ ?>

                    <div class="form-group" style="width: 40%;padding: 10px;">
                    <label for="fk_profil" class="control-label"><?php echo $this->lang['commune']; ?> <span style="color: #9A0000;">( * )</span></label>
                    <select name="fk_commune" id="fk_commune" class="form-control select2" disabled="disabled" style="width: 100%">
                        <option value=""><?php echo $this->lang['select_commune'];?></option>
                        <?php foreach ($coms as $item) { ?>
                            <option value="<?= $item->rowid; ?>" <?php if($agence->commune === $item->libelle) echo 'selected="selected"'; ?>><?= $item->libelle; ?></option>
                        <?php } ?>
                    </select>
                    <span class="help-block with-errors"> </span>
                </div>

                <?php } ?>

                <?php if(!isset($agence->rowid)){ ?>

                    <div class="form-group" style="width: 40%;padding: 10px;">
                    <label for="fk_profil" class="control-label"><?php echo $this->lang['commune']; ?> <span style="color: #9A0000;">( * )</span></label>
                    <select name="fk_commune" id="fk_commune" class="form-control select2" disabled="disabled" style="width: 100%">
                        <option value=""><?php echo $this->lang['select_commune'];?></option>
                    </select>
                    <span class="help-block with-errors"> </span>
                </div>

                <?php } ?>

            </div>

            <div class="col-sm-1"></div>
            <div class="row">
                <div class="form-group" style="width: 40%;padding: 10px;">
                    <label for="label" class="control-label"><?php echo $this->lang['hour_debut']; ?></label><br>
                    <div class="input-group clockpicker " data-placement="left" data-align="top" data-autoclose="true">
                        <input id="iddebut" style="width: 280px;" required type="text" name="heuredebut" class="form-control" value="<?= ((isset($agence->rowid)) ? $agence->heuredebut : date('H:i')) ;?>" ">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                    </div>
                    <span class="help-block with-errors"> </span>
                </div>
                <div class="form-group" style="width: 40%;padding: 10px;">
                    <label for="label" class="control-label"><?php echo $this->lang['hour_fin'].'  '; ?></label><br>
                    <div class="input-group clockpicker " data-placement="left" data-align="top" data-autoclose="true">
                        <input  id="idfin" style="width: 280px;" required type="text" name="heurefin" class="form-control" value="<?= ((isset($agence->rowid)) ? $agence->heurefin : date('H:i')) ;?>"onchange="testHeures();" >
                        <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                    </div>
                    <span class="help-block with-errors"> </span>
                </div>

            </div>
            <div class="col-sm-1"></div>



                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="adresse" class="control-label"><?php echo $this->lang['adresse_four']; ?></label><br>
                        <textarea name="adresse" id="adresse" style="width: 100%"><?= $agence->adresse ;?></textarea>
                        <span class="help-block with-errors"> </span>
                    </div>



                    <div class="alert alert-danger alert-dismissable " id="msgErreur2" style="display: none; font-size: 12px;" >
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    </div>


                    <?php if(isset($agence->rowid)) {  ?> <input type="hidden" name="id" value="<?= $agence->rowid; ?>"><?php } ?>



        </div>
    </div>

    <div class="modal-footer">
        <button id="lebtnValider" class="btn btn-success confirm" data-form="my-form" type="submit"><i class="fa fa-check"></i> <?php echo $this->lang['btnValider']; ?></button>
        <button class="btn btn-default" type="button" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo $this->lang['btnFermer']; ?> </button>
    </div>

</form>
<script>
    function testHeures(){
        var debut= $("#iddebut").val();
        var fin= $("#idfin").val();
        var res_debut = debut.substr(0, 2);
        var res_fin = fin.substr(0, 2);

        if(res_debut > res_fin)  {
            //alert("la date de fin doit etre supérieur à la date de début ")
            document.getElementById('msgErreur2').style.display = "block";
            $('#msgErreur2').html('<span><strong><i class="fa fa-times fa-2x" aria-hidden="true"></i>&nbsp;Erreur !&nbsp;</strong> &nbsp;La date de fin doit etre supérieur à la date de début ...</span>');
            $('#lebtnValider').css('display','none');

        }
        else{
            document.getElementById('msgErreur2').style.display = "none";
            $('#lebtnValider').css('display','block');
        }
    }
    function getDepartementByRegion()
    {

        $.ajax({
            type: "POST",
            url: "<?= WEBROOT.'agence/getDepartementByRegion'; ?>",

            data: "region_rowid="+$('#region_rowid').val(),
            success: function(data) {

                data = JSON.parse(data);
                $("#fk_commune").attr('disabled','disabled');
                $("#dept").removeAttr('disabled');
                var collect = '';
                collect += '<option value="" ><?= $this->lang['select_dept']; ?></option>';
                for(var i = 0; i<data.length; i++){
                    var first1 = data[i].label;
                    var first = data[i].rowid;
                    collect += '<option value="'+first+'">'+first1+'</option>';
                }
                document.getElementById("dept").innerHTML = collect;

            }
        });

    }
    function getCommuneBydepartement()
    {

        $.ajax({
            type: "POST",
            url: "<?= WEBROOT.'agence/getCommuneByDepartement'; ?>",

            data: "dept_rowid="+$('#dept').val(),
            success: function(data) {

                data = JSON.parse(data);
                $("#fk_commune").removeAttr('disabled');
                var collect = '';
                collect += '<option value="" ><?= $this->lang['select_commune']; ?></option>';
                for(var i = 0; i<data.length; i++){
                    var first1 = data[i].libelle;
                    var first = data[i].id;
                    collect += '<option value="'+first+'">'+first1+'</option>';
                }
                document.getElementById("fk_commune").innerHTML = collect;

            }
        });

    }
</script>
<script>
    $(".select2").select2();

</script>
<script>
    $('input[type="tel"]').intlTelInput({
        utilsScript: '<?= ASSETS;?>plugins/telPlug/js/utils.js',
        autoPlaceholder: true,
        preferredCountries: ['sn', 'gm', 'gb', 'ci'],
        initialDialCode: true,
        nationalMode: false
    });

</script>

<script type="text/javascript">
    $('.clockpicker').clockpicker({
        donetext: 'Done'
        , }).find('input').change(function () {
        console.log(this.value);
    });
</script>
<style>
    .clockpicker-popover{
        z-index: 9999 !important;
    }
</style>
<!--<script>
    function verifDate(){
        alert("hhhhh");
        var debut= $("#iddebut").val();
        var fin= $("#idfin").val();
        var res_debut = debut.substr(0, 2);
        var res_fin = fin.substr(0, 2);

        if(res_debut > res_fin  {
            alert("la date de fin doit etre supérieur à la date de début ")
            $('#lebtnValider').css('display','none');

        }
    }

</script>-->