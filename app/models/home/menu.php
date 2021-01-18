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
                <h4 class="page-title"><?php echo $this->lang['menu_list']; ?></h4></div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo WEBROOT . 'home/menu'; ?>">  <?php echo $this->lang['home']; ?></a>
                    </li>
                    <li class="active"><?php echo $this->lang['menu_list']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>


        <div class="white-box">
            <div class="row">
                <?php if(\app\core\Utils::authorized(null, null, "Administration")){ ?>
                <div class="col-lg-3 col-sm-6">
                    <?php if (\app\core\Utils::authorized('utilisateur', 'liste')) { ?>
                        <div class="panel-wrapper collapse in">
                            <div class="panel-body">
                                <center>
                                    <a href="<?php echo WEBROOT.'utilisateur/liste';?>">
                                        <img src="<?php echo ASSETS.'plugins/images/002-partner.png';?>" alt="" width="64" height="64">
                                    </a>
                                </center>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (\app\core\Utils::authorized('utilisateur', 'liste')) { ?>
                        <a href="<?php echo WEBROOT.'utilisateur/liste';?>">
                            <div class="panel-heading boite">
                                <center><?php echo $this->lang['administration'];?></center>
                            </div>
                        </a>
                    <?php } ?>
                    </div>
                <?php } ?>
                <?php if(\app\core\Utils::authorized(null, null, "Paramètrage")){ ?>

                <div class="col-lg-3 col-sm-6">
                    <?php if (\app\core\Utils::authorized('administration', 'listeRegion')) { ?>
                        <div class="panel-wrapper collapse in">
                            <div class="panel-body">
                                <center>
                                    <a href="<?php echo WEBROOT.'administration/listeRegion';?>">
                                        <img src="<?php echo ASSETS.'plugins/images/001-gears.png';?>" alt="" width="64" height="64">
                                    </a>
                                </center>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (\app\core\Utils::authorized('administration', 'listeRegion')) { ?>
                        <a href="<?php echo WEBROOT.'administration/listeRegion';?>">
                            <div class="panel-heading boite">
                                <center><?php echo $this->lang['config'];?></center>
                            </div>
                        </a>
                    <?php } ?>
                    </div>
                <?php } ?>
                <?php if(\app\core\Utils::authorized(null, null, "Gestion des cartes")){ ?>

                <div class="col-lg-3 col-sm-6">
                    <?php if (\app\core\Utils::authorized('carte', 'reception')) { ?>
                        <div class="panel-wrapper collapse in">
                            <div class="panel-body">
                                <center>
                                    <a href="<?php echo WEBROOT.'carte/reception';?>">
                                        <img src="<?php echo ASSETS.'plugins/images/004-credit-cards-payment.png';?>" alt="" width="64" height="64">
                                    </a>
                                </center>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (\app\core\Utils::authorized('carte', 'reception')) { ?>
                        <a href="<?php echo WEBROOT.'carte/reception';?>">
                            <div class="panel-heading boite">
                                <center><?php echo $this->lang['gestioncarte'];?></center>
                            </div>
                        </a>
                    <?php } ?>
                    </div>
                <?php } ?>
                <?php if(\app\core\Utils::authorized(null, null, "Gestion des TPE")){ ?>

                <div class="col-lg-3 col-sm-6">
                    <?php if (\app\core\Utils::authorized('tpe', 'liste')) { ?>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <center>
                                <a href="<?php echo WEBROOT.'tpe/liste';?>"
                                    <i class="fa fa-mobile fa-fw-5x" style="font-size: 65px;" data-icon="v"></i>
                                </a>




                            </center>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if (\app\core\Utils::authorized('tpe', 'liste')) { ?>
                    <a href="<?php echo WEBROOT.'tpe/liste';?>">
                        <div class="panel-heading boite">
                            <center><?php echo $this->lang['ges_tpe'];?></center>
                        </div>
                    </a>
                    <?php } ?>
                </div>
                <?php } ?>

            </div>

        </div>





    </div>
</div>