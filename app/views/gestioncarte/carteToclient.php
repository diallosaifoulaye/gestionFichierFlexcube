<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="row white-box" style="margin-top:0px; margin-bottom: 4px">
                <!--<div class="col-lg-2 col-sm-6 bg-theme text-white" style="height: 40px; vertical-align: middle; padding-top:10px;background-color: #0a7242 !important;">
                    <center><b><?php /*echo $this->lang['alaune'];*/?></b></center>
                </div>-->
                <div class="col-lg-10 col-sm-6 annulation">
                    <marquee>
                        <a href="">

                        </a>
                    </marquee>

                </div>
            </div>
        </div>
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title"><?php echo $this->lang['searchCust']; ?></h4></div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo WEBROOT . 'carte/reception'; ?>">  <?php echo $this->lang['gestioncarte']; ?></a>
                    </li>
                    <li class="active"><?php echo $this->lang['searchCust']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <div class="row">
                            <div class="row">
                                <div class="form-group col-sm-4"></div>
                                <div class="form-group col-sm-3">
                                    <input type="text" data-toggle="validator" class="form-control" id="code_client" placeholder="<?php echo $this->lang['codeclient']; ?>" required>
                                    <span class="help-block with-errors" id="msg1"> </span>
                                </div>
                                <div class="form-group col-sm-1">
                                    <button type="button" id="sendCheck" class="btn btn-primary"
                                            style="background-color: #0a7242;border-bottom-color: #0a7242">
                                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                    </button>
                                </div>
                                <div class="form-group col-sm-4"></div>
                            </div>

                        <form data-toggle="validator" method="post" novalidate action="<?php echo WEBROOT . 'carte/saveClientCard' ?>">
                            <div class="row">
                                <input type="hidden" id="code_client1" name="code_client" class="form-control">
                                <div class="form-group col-sm-3"></div>
                                <div id="thediv" style="display: none;" class="col-sm-6">

                                    <fieldset style="display: block;" class="scheduler-border">
                                        <legend class="scheduler-border"><?= $this->lang['card_info']; ?></legend>

                                        <div class="container-fluid">
                                            <div class="row">

                                                <div class="form-group" style="width: 100%;padding: 10px;">
                                                    <label for="nom_complet_client"
                                                           class="control-label"><?php echo $this->lang['nom_complet'].' (*)'; ?></label>
                                                    <input type="text" id="nom_complet_client" name="nom_complet_client"
                                                           readonly class="form-control" style="width: 100%" required>
                                                    <span class="help-block with-errors" id="msg1"> </span>
                                                </div>
                                                <div class="form-group" style="width: 100%;padding: 10px;">
                                                    <label for="telephone"
                                                           class="control-label"><?php echo $this->lang['tel_four'].' (*)'; ?></label>
                                                    <input type="tel" id="telephone" name="telephone" class="form-control" placeholder="<?php echo $this->lang['tel_four']; ?>" style="width: 100%" required onkeypress="return IsNumeric(event);">
                                                    <span class="font-13 text-muted">Format: +999999999999 </span>
                                                </div>
                                                <div class="form-group" style="width: 100%;padding: 10px;">
                                                    <label for="numero"
                                                           class="control-label"><?php echo $this->lang['num_carte'].' (*)'; ?></label>
                                                    <input type="text" id="numero" autocomplete="off" name="numero" class="form-control"
                                                           placeholder="<?php echo $this->lang['num_carte']; ?>"
                                                           style="width: 100%" required data-mask="9999999999999999">
                                                    <span class="font-13 text-muted">Format: 9999999999999999</span>
                                                </div>
                                                <div class="form-group" style="width: 100%;padding: 10px;">
                                                    <label for="numero_serie"
                                                           class="control-label"><?php echo $this->lang['num_carte_serie'].' (*)'; ?></label>
                                                    <input type="text" id="numero_serie" autocomplete="off" name="numero_serie" class="form-control" placeholder="<?php echo $this->lang['num_carte_serie']; ?>"
                                                           style="width: 100%" required data-mask="999999999999">
                                                    <span class="font-13 text-muted">Format: 999999999999</span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputPassword4" class="control-label col-sm-3"><?php echo $this->lang['labdatedexpi'].' (*)';?></label>
                                                    <div class="col-sm-4">
                                                        <input type="text" name="moisexp" data-mask="99" data-minlength="2" class="form-control" placeholder="<?php echo $this->lang['moisexp'];?>" required>
                                                        <span class="font-13 text-muted">Mois</span>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <input type="text" name="anexp" data-mask="9999" class="form-control" data-minlength="4" placeholder="<?php echo $this->lang['anexp'];?>" required>
                                                        <span class="font-13 text-muted">Année</span>
                                                    </div>
                                                </div>
                                              <!--  <div class="form-group" style="width: 100%;padding: 10px;">
                                                    <label for="embossage"
                                                           class="control-label"><?php /*echo $this->lang['embossage']; */?></label>
                                                    <input type="text" id="embossage" name="embossage" class="form-control"
                                                           placeholder="<?php /*echo $this->lang['embossage']; */?>"
                                                           style="width: 100%" required>
                                                    <span class="help-block with-errors"> </span>
                                                </div>-->
                                                <div class="form-group" style="width: 100%;padding: 10px;">
                                                    <label for="commentaire"
                                                           class="control-label"><?php echo $this->lang['comment']; ?></label>
                                                    <textarea id="commentaire" name="commentaire" class="form-control"
                                                              style="width: 100%"></textarea>
                                                    <span class="help-block with-errors"> </span>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <button class="btn btn-success" id="btnConfirm" type="submit">
                                                        <i class="fa fa-check"></i> <?php echo $this->lang['btnValider']; ?>
                                                    </button>
                                                </div>
                                                <div class="col-sm-3">
                                                    <a href="javascript:history.back()">
                                                        <button class="btn btn-default" type="button"><i
                                                                class="fa fa-times"></i> <?php echo $this->lang['btnFermer']; ?>
                                                        </button>
                                                    </a>
                                                </div>
                                                <div class="col-sm-3"></div>
                                            </div>

                                        </div>

                                    </fieldset>

                                </div>
                                <div class="form-group col-sm-3"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    $("#sendCheck").click(function () {
        var code = $('#code_client').val();
        //alert(code);

        $.ajax({
            type: "POST",
            url: "<?= WEBROOT . 'carte/searchClient'; ?>",
            data: "code=" + code,
            success: function (data) {
                alert(data);
                if (!data) {
                    $('#msg1').html("<p style='color:#F00;display: inline;border: 1px solid #F00'> <?= $this->lang['unfunded_client']; ?></p>");
                    $('#thediv').css('display', 'none');
                    $('#code_client').val('');
                }
                else {
                    var cc = $('#code_client').val();
                    $('#code_client1').val(cc);
                    $('#code_client').val('');
                    $('#nom_complet_client').val(data);
                    $('#msg1').html("");
                    $('#thediv').css('display', 'block');
                }
            }
        });
    });

    //a verifier
    $("#date_expiration").click(function () {
        var numero = $('#numero').val();
        var serie = $('#numero_serie').val();
        //alert(code);

        $.ajax({
            type: "POST",
            url: "<?= WEBROOT . 'carte/checkCard'; ?>",
            data: "numero=" + numero + "&numero_serie=" + serie,
            success: function (data) {
                //alert(data);
                if (data) {
                    $('#msg1').html("<p style='color:#F00;display: inline;border: 1px solid #F00'> <?= $this->lang['bad_card']; ?></p>");
                    $('#thediv').css('display', 'none');
                    $('#formDegagementfonds').find("input[type=text], textarea").val('');
                }

            }
        });
    });
</script>