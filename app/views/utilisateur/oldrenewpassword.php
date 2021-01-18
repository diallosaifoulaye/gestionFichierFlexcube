<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="row white-box" style="margin-top:0px; margin-bottom: 4px">
                <!--<div class="col-lg-2 col-sm-6 bg-theme text-white" style="height: 40px; vertical-align: middle; padding-top:10px;background-color: #0a7242 !important;">
                    <center><b><?php /*echo $this->lang['alaune'];*/?></b></center>
                </div>-->
              <!--  <div class="col-lg-10 col-sm-6 annulation">
                    <marquee>
                        <a href="">

                        </a>
                    </marquee>

                </div>-->
            </div>
        </div>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="white-box">
                    <form method="post" action="<?php echo WEBROOT ?>utilisateur/saveNewPassword"
                          id="formDegagementfonds">
                        <fieldset style="display: block;" class="scheduler-border">
                            <legend class="scheduler-border"><?= $this->lang['edit_pwd']; ?></legend>

                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-6">
                                        <div class="form-group" style="width: 100%;padding: 10px;">
                                            <label for="oldpwd" class="control-label"><?php echo $this->lang['edit_pwd1']; ?></label>
                                            <input type="password" id="oldpwd" name="oldpwd" class="form-control" placeholder="<?php echo $this->lang['edit_pwd1']; ?>"
                                                   style="width: 100%" required>
                                            <span class="help-block with-errors" id="msg1"> </span>
                                        </div>
                                        <div class="form-group" style="width: 100%;padding: 10px;">
                                            <label for="newpwd" class="control-label"><?php echo $this->lang['edit_pwd2']; ?></label>
                                            <input type="password" data-toggle="validator" data-minlength="6" readonly id="inputPassword" name="pass" class="form-control" placeholder="<?php echo $this->lang['edit_pwd2']; ?>"
                                                   style="width: 100%" required>
                                            <span class="help-block with-errors"> </span>
                                        </div>
                                        <div class="form-group" style="width: 100%;padding: 10px;">
                                            <label for="confirmpwd" class="control-label"><?php echo $this->lang['edit_pwd3']; ?></label>
                                            <input type="password" id="inputPasswordConfirm" data-match="#inputPassword" readonly data-match-error="Confirmation du mot de pass incorrecte" name="confirmpwd" class="form-control" placeholder="<?php echo $this->lang['edit_pwd3']; ?>"
                                                   style="width: 100%" required>
                                            <span id="msg2" class="help-block with-errors"> </span>
                                        </div>
                                        <input type="hidden" name="id" value="<?= $rowid; ?>">
                                    </div>
                                    <div class="col-sm-3"></div>

                                </div>
                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-3">
                                        <button class="btn btn-success" id="btnConfirm" onclick="confirmPass();" disabled type="button"><i class="fa fa-check"></i> <?php echo $this->lang['btnValider']; ?></button>
                                    </div>
                                    <div class="col-sm-3">
                                        <a href="javascript:history.back()">
                                            <button class="btn btn-default" type="button"><i class="fa fa-times"></i> <?php echo $this->lang['btnFermer']; ?> </button>
                                        </a>
                                    </div>
                                    <div class="col-sm-3"></div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</div>

<script>

    $("#inputPassword").click(function(){
        var oldpwd = $('#oldpwd').val();
        var thepass = "<?php echo $rowid ; ?>" ;

            $.ajax({
                type: "POST",
                url: "<?= WEBROOT . 'utilisateur/checkOldPassword'; ?>",
                data: "oldpwd=" + oldpwd +"&thepass=" + thepass,
                success: function (data) {
                    //alert(data);
                    if(data){
                        $('#inputPassword').removeAttr('readonly');
                        $('#inputPasswordConfirm').removeAttr('readonly');
                        $('#msg1').html("<p style='color:#7ACE4C;display: inline;border: 1px solid #7ACE4C'> <?= $this->lang['pass_alert_success']; ?></p>");
                        $("#btnConfirm").removeAttr("disabled","disabled");
                    }
                    else{
                        $('#msg1').html("<p style='color:#F00;display: inline;border: 1px solid #F00'> <?= $this->lang['pass_alert_error']; ?></p>");
                        $("#btnConfirm").attr("disabled","disabled");
                    }
                }
            });
    });

    function confirmPass()
    {
        var mot_de_passe= document.getElementById('inputPassword').value;
        var mot_de_passe1= document.getElementById('inputPasswordConfirm').value;
        if(mot_de_passe == mot_de_passe1){
            $('#msg2').html("<p style='color:#7ACE4C;display: inline;border: 1px solid #7ACE4C'> <?=  $this->lang['confirmpass_alert_success'];  ?></p>");
            $("#valider").removeAttr("disabled","disabled");
            $('#formDegagementfonds').submit();
        }
        else{
            $('#msg2').html("<p style='color:#F00;display: inline;border: 1px solid #F00'> <?= $this->lang['confirmpass_alert_error']; ?></p>");
            $("#valider").attr("disabled","disabled");
        }
    }

</script>