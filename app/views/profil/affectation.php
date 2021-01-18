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
                <h4 class="page-title"><?php echo $this->lang['listeProfil']; ?></h4></div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= WEBROOT; ?>administration/index">  <?php echo $this->lang['administration']; ?></a>
                    </li>
                    <li class="active"><?php echo $this->lang['list_service']; ?></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <div class="row">
                        <form action="<?php echo WEBROOT; ?>profil/ajoutAffectation" method="post">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-md-11">
                                            <?php echo $this->lang['service']; ?> : <?= $nomProfil ?>
                                        </div>
                                        <div class="col-md-1">
                                            <?php if (count($droit) > 0){ ?>
                                                <button class="btn btn-success" type="submit">
                                                    <i class="fa fa-check"></i> <?php echo $this->lang['btnValider']; ?>
                                                </button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="idProfil" value="<?= $idProfil ?>">
                                <div class="panel-body">
                                    <?php if (count($droit) == 0) { ?>
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <h3 class="panel-title">Aucun droit ajouté !</h3>
                                                </div>
                                                <div class="col-md-1">
                                                    <a href="<?= WEBROOT ?>droit/liste" class="btn btn-success">Ajouter un droit</a>
                                                </div>
                                                <div class="col-md-9"></div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php $i = 0;
                                    foreach ($droit as $libMod => $module) { ?>

                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title"><?= $libMod; ?></h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="row">
                                                    <?php foreach ($module as $lib_sm => $one_sm) { ?>

                                                        <div class="col-md-6">
                                                            <div id="accor<?= $lib_sm; ?>" class="panel-group">
                                                                <div class="panel panel-default">
                                                                    <div class="panel-heading">
                                                                        <h4 class="panel-title">

                                                                            <a href="#<?= $lib_sm; ?>" data-parent="#accordion"
                                                                               data-toggle="collapse"
                                                                               class="accordion-toggle collapsed"
                                                                               aria-expanded="false"><?= $lib_sm; ?></a>
                                                                        </h4>
                                                                    </div>
                                                                    <div class="panel-collapse collapse" id="<?= $lib_sm; ?>"
                                                                         aria-expanded="false">
                                                                        <div class="panel-body">
                                                                            <?php foreach ($one_sm as $val) { ?>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-check form-check-inline">
                                                                                        <input <?= (intval($val['id_aff']) > 0 && $val['etat_aff'] == 1 ? 'checked' : '') ?>
                                                                                                value="<?= (isset($val['id_aff']) ? $val['id_aff'] : $val['id']) ?>"
                                                                                                name="<?= (isset($val['id_aff']) ? 'update[]' : 'add[]') ?>"
                                                                                                class="form-check-input"
                                                                                                type="checkbox">
                                                                                        <label class="form-check-label">
                                                                                            <?php echo $val['droit'] ?>
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php $i++;
                                    } ?>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>