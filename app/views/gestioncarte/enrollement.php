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
                <h4 class="page-title"><?php echo $this->lang['enrollement_carte']; ?></h4></div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo WEBROOT . 'carte/reception'; ?>">  <?php echo $this->lang['gestioncarte']; ?></a>
                    </li>
                    <li class="active"><?php echo $this->lang['enrollement_carte']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <form data-toggle="validator" method="post" action="<?php echo WEBROOT.'carte/enrollement';?>">

                        <div class="row">
                            <div class="form-group col-sm-2"></div>
                            <div class="form-group col-sm-4">
                                <input type="text" class="form-control" id="code_client" name="code_client" readonly>
                            </div>
                            <div class="form-group col-sm-4">
                                <input type="text" class="form-control" id="nom_complet_client" name="nom_complet_client" readonly>
                            </div>
                            <div class="form-group col-sm-2"></div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-2"></div>
                            <div class="form-group col-sm-8">
                                <input type="tel" data-toggle="validator" class="form-control" name="telephone" id="telephone" placeholder="<?php echo $this->lang['tel_client'];?>" required>
                            </div>
                            <div class="form-group col-sm-2"></div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-2"></div>
                            <div class="form-group col-sm-4">
                                <input type="text" data-toggle="validator" class="form-control" id="numero" name="numero" placeholder="<?php echo $this->lang['num_carte'];?>" required>
                            </div>
                            <div class="form-group col-sm-4">
                                <input type="text" data-toggle="validator" class="form-control" id="numero_serie" name="numero_serie" placeholder="<?php echo $this->lang['num_serie'];?>" required>
                            </div>
                            <div class="form-group col-sm-2"></div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-2"></div>
                            <div class="form-group col-sm-4">
                                <input type="date" data-toggle="validator" class="form-control" id="date_expiration" name="date_expiration" placeholder="<?php echo $this->lang['date_exp_carte'];?>" required>
                            </div>
                            <!--<div class="form-group col-sm-4">
                                <input type="text" data-toggle="validator" class="form-control" id="embossage" name="embossage" placeholder="<?php /*echo $this->lang['embossage'];*/?>" required>
                            </div>-->
                            <div class="form-group col-sm-2"></div>
                        </div>
                        <div class="row">
                                <div class="form-group col-sm-5"></div>
                            <div class="form-group col-sm-2">
                                <button class="btn btn-success confirm" data-form="my-form" type="submit"><i class="fa fa-check"></i> <?php echo $this->lang['btnValider']; ?></button>
                                <button class="btn btn-default" type="reset" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo $this->lang['btnAnnuler']; ?> </button>
                            </div>
                            <div class="form-group col-sm-5"></div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('input[type="tel"]').intlTelInput({
        utilsScript: '<?= ASSETS;?>plugins/telPlug/js/utils.js',
        autoPlaceholder: true,
        preferredCountries: ['sn', 'gm', 'gb', 'ci'],
        initialDialCode: true,
        nationalMode: false
    });

</script>