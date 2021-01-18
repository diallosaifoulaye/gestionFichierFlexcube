<!-- ============================================================== -->
<!-- Wrapper -->
<!-- ============================================================== -->
<div id="wrapper">
    <!-- ============================================================== -->
    <!-- Topbar header - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <nav class="navbar navbar-default navbar-static-top m-b-0">
        <div class="navbar-header" style="background: #f6f6f6">

            <div class="top-left-part" style="background: #f6f6f6">
                <!-- Logo -->
                <a class="logo" href="<?php echo WEBROOT . 'home/menu'; ?>">
                    <!-- Logo text image you can use text also -->
                    <span class="hidden-xs">
                        <!--This is dark logo text-->
                        <img src="<?php echo ASSETS; ?>plugins/images/admin-text.png" alt="home" class="dark-logo">
                        <!--This is light logo text-->
                        <img src="<?php echo ASSETS; ?>plugins/images/LogoPosteFinances.png" style="margin-left: 30px; width: 162px; height: 62px;" alt="home" class="light-logo">
                     </span>
                </a>
            </div>


            <!-- /Logo -->
            <!-- Search input and Toggle icon -->
            <ul class="nav navbar-top-links navbar-left">
                <li><a href="javascript:void(0)" class="open-close waves-effect waves-light">
                        <i class="ti-menu" style="color: #1f3b72"></i>
                    </a>
                </li>
                <?php //require_once (ROOT . 'app/views/notify.php'); ?>

            </ul>

            <ul class="nav navbar-top-links navbar-right pull-right">
                <li class="dropdown">
                    <a class="dropdown-toggle profile-pic btn-success" data-toggle="dropdown" href="#">

                        <b class="hidden-xs"><i style="position: relative;top: 5px;right: 5px;" class="fa fa-2x fa-globe"></i><?= $this->lang[\app\core\Session::getAttribut('lang')] ?></b><span class="caret"></span> </a>
                    <ul class="dropdown-menu dropdown-user animated flipInY" style="width: inherit;">
                        <li><a href="javascript:;" class="_lang_" data-lang="fr" style="vertical-align: inherit;">Français</a></li>
                        <li><a href="javascript:;" class="_lang_" data-lang="us" style="vertical-align: inherit;">English</a></li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#">
                        <!--                        <img src="--><?php //echo WEBROOT;?><!--app/pictures/-->
                        <?php //echo $this->_USER->photo ;?><!--" alt="user-img" width="36" class="img-circle">-->
                        <!--                        <img src="-->
                        <?php //echo ASSETS; ?><!--plugins/images/users/varun.jpg" alt="user-img" width="36" class="img-circle">-->
                        <b class="hidden-xs"
                           style="color: #1f3b72"><?php echo $this->_USER->prenom . ' ' . $this->_USER->nom; ?> , </b>
                        <b class="hidden-xs" style="color: #1F4F98"> <?php echo $this->lang['lagence'].' '. $_SESSION['nomAgence']; ?></b>
                        <span class="caret"></span> </a>
                    <ul class="dropdown-menu dropdown-user animated flipInY">
                        <li>
                            <div class="dw-user-box">
                                <!-- <div class="u-img">
                                    <img src="<?php /*echo WEBROOT;*/ ?>app/pictures/<?php /*echo $this->_USER->photo ;*/ ?>" alt="user"/>
                                </div>-->
                                <div class="u-text">
                                    <h4 style="color: #1F4F98"><?php echo $this->_USER->prenom . ' ' . $this->_USER->nom ?></h4>
                                    <p class="text-muted"><?php echo $this->_USER->email; ?></p>
                                </div>
                            </div>
                        </li>
                        <li role="separator" class="divider"></li>
                        <li>
                            <a href="<?php echo WEBROOT . "utilisateur/myProfil/" . base64_encode($this->_USER->id) ?>">
                                <i class="ti-user"></i>&nbsp;&nbsp;<?php echo $this->lang['mon_profil']; ?>
                            </a>
                        </li>

                        <li><a href="<?= WEBROOT ?>home/logout"><i
                                        class="fa fa-power-off"></i>&nbsp;&nbsp;<?php echo $this->lang['se_deconnecter']; ?>
                            </a></li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>

                <!-- /.dropdown -->
            </ul>
        </div>
        <!-- /.navbar-header -->
        <!-- /.navbar-top-links -->
        <!-- /.navbar-static-side -->
    </nav>
    <!-- ============================================================== -->
    <!-- Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <div class="navbar-default sidebar" role="navigation" style="background: #1f3b72">
        <div class="sidebar-nav slimscrollsidebar">
            <div class="sidebar-head">
                <h3>
                <span class="fa-fw open-close"><i class="ti-menu hidden-xs"></i>
                    <i class="ti-close visible-xs"></i>
                </span>
                    <span class="hide-menu">Navigation</span>
                </h3>
            </div>

            <div class="user-profile" style="background: #ffffff">
                <div class="dropdown user-pro-body">
                    <!--<div>
                    <img src="<?php /*echo ASSETS; */ ?>plugins/images/users/varun.jpg" alt="user-img" class="img-circle">
                </div>-->
                    <a href="#" class="dropdown-toggle u-dropdown" style="color: #1F4F98" data-toggle="dropdown"
                       role="button" aria-haspopup="true" aria-expanded="false">
                        <?php echo $this->_USER->prenom . ' ' . $this->_USER->nom; ?>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu animated flipInY">
                        <li>
                            <a href="<?= WEBROOT . "utilisateur/myProfil/" . base64_encode($this->_USER->id) ?>">
                                <i class="ti-user"></i>&nbsp;&nbsp;<?php echo $this->lang['mon_profil']; ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo WEBROOT . "home/logout" ?>">
                                <i class="fa fa-power-off"></i>&nbsp;&nbsp;
                                <?php echo $this->lang['se_deconnecter']; ?>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <ul class="nav" id="side-menu">




             <!--   <?php /*if(\app\core\Utils::authorized(null, null, "Versement")){ */?>
                    <li>
                        <a href="#" class="waves-effect">
                            <i class="fa fa-money fa-fw" data-icon="v"></i>
                            <span class="hide-menu"> <?php /*echo $this->lang['Historique_file']; */?> <span class="fa arrow"></span> </span>
                        </a>
                        <ul class="nav nav-second-level">
                            <?php /*if (\app\core\Utils::authorized('versement', 'collectEncours')) { */?>
                                <li>
                                    <a href="<?php /*echo WEBROOT . "versement/collectEncours" */?>">
                                        <i data-icon="/" class="fa fa-list fa-fw"></i>
                                        <span class="hide-menu"><?php /*echo $this->lang['plat_file']; */?></span>
                                    </a>
                                </li>
                            <?php /*} */?>
                            <?php /*if (\app\core\Utils::authorized('versement', 'historique')) { */?>

                                <li>
                                    <a href="<?php /*echo WEBROOT . "versement/historique" */?>">
                                        <i data-icon="/" class="fa fa-sort-amount-asc fa-fw"></i>
                                        <span class="hide-menu"><?php /*echo $this->lang['rapport']; */?></span>
                                    </a>
                                </li>
                            <?php /*} */?>


                        </ul>
                    </li>
                --><?php /*} */?>

                <?php if(\app\core\Utils::authorized(null, null, "Administration")){ ?>
<!--                    <li>
                        <a href="#" class="waves-effect">
                            <i class="fa fa-cogs fa-fw" data-icon="v"></i>
                            <span class="hide-menu"> <?php /*echo $this->lang['config']; */?> <span
                                        class="fa arrow"></span> </span>
                        </a>
                        <ul class="nav nav-second-level">
                            <?php /*if (\app\core\Utils::authorized('administration', 'listeRegion')) { */?>

                            <li>
                                <a href="<?php /*echo WEBROOT . "administration/listeRegion" */?>">
                                    <i data-icon="/" class="fa fa-flag-o fa-fw"></i>
                                    <span class="hide-menu"><?php /*echo $this->lang['region_list']; */?></span>
                                </a>
                            </li>
                            <?php /*} */?>

                            <?php /*if (\app\core\Utils::authorized('administration', 'listeDept')) { */?>
                            <li>
                                <a href="<?php /*echo WEBROOT . "administration/listeDept" */?>">
                                    <i data-icon="/" class="fa fa-flag-o fa-fw"></i>
                                    <span class="hide-menu"><?php /*echo $this->lang['dept_list']; */?></span>
                                </a>
                            </li>
                            <?php /*} */?>

                            <?php /*if (\app\core\Utils::authorized('administration', 'listeCom')) { */?>
                            <li>
                                <a href="<?php /*echo WEBROOT . "administration/listeCom" */?>">
                                    <i data-icon="/" class="fa fa-flag-o fa-fw"></i>
                                    <span class="hide-menu"><?php /*echo $this->lang['commune_list']; */?></span>
                                </a>
                            </li>
                            <?php /*} */?>

                            <?php /*if (\app\core\Utils::authorized('administration', 'listeDevise')) { */?>

                            <li>
                                <a href="<?php /*echo WEBROOT . "administration/listeDevise" */?>">
                                    <i data-icon="/" class="fa fa-money fa-fw"></i>
                                    <span class="hide-menu"><?php /*echo $this->lang['devise']; */?></span>
                                </a>
                            </li>
                            <?php /*} */?>


                        </ul>
                    </li>
-->                <?php } ?>



                <?php if(\app\core\Utils::authorized(null, null, "Administration")){ ?>
                <li>
                    <a href="#" class="waves-effect">
                        <i class="mdi mdi-memory fa-fw" data-icon="v"></i>
                        <span class="hide-menu"> <?php echo $this->lang['administration']; ?> <span
                                    class="fa arrow"></span> </span>
                    </a>
                    <ul class="nav nav-second-level">
                        <?php if (\app\core\Utils::authorized('module', 'liste')) { ?>

<!--                        <li>
                            <a href="<?php /*echo WEBROOT . "module/liste" */?>">
                                <i data-icon="/" class="linea-icon linea-basic fa-fw"></i>
                                <span class="hide-menu"><?php /*echo $this->lang['modules']; */?></span>
                            </a>
                        </li>
-->                        <?php } ?>
                        <?php if (\app\core\Utils::authorized('sousModule', 'liste')) { ?>

<!--                        <li>
                            <a href="<?php /*echo WEBROOT . "sousModule/liste" */?>">
                                <i data-icon="/" class="ti-list fa-fw"></i>
                                <span class="hide-menu"><?php /*echo $this->lang['sousmodules']; */?></span>
                            </a>
                        </li>
-->                        <?php } ?>
                        <?php if (\app\core\Utils::authorized('droit', 'liste')) { ?>

                        <li>
                            <a href="<?php echo WEBROOT . "droit/liste" ?>">
                                <i data-icon="/" class="fa fa-user-secret fa-fw"></i>
                                <span class="hide-menu"><?php echo $this->lang['action']; ?></span>
                            </a>
                        </li>
                        <?php } ?>
                        <?php if (\app\core\Utils::authorized('profil', 'liste')) { ?>

                        <li>
                            <a href="<?php echo WEBROOT . "profil/liste" ?>">
                                <i data-icon="/" class="fa fa-street-view fa-fw"></i>
                                <span class="hide-menu"><?php echo $this->lang['profils']; ?></span>
                            </a>
                        </li>
                        <?php } ?>

                        <?php if (\app\core\Utils::authorized('agence', 'liste')) { ?>

                            <li>
                                <a href="<?php echo WEBROOT . "agence/liste" ?>">
                                    <i data-icon="/" class="fa fa-university fa-fw"></i>
                                    <span class="hide-menu"><?php echo $this->lang['agence']; ?></span>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if (\app\core\Utils::authorized('utilisateur', 'liste')) { ?>

                            <li>
                                <a href="<?php echo WEBROOT . "utilisateur/liste" ?>">
                                    <i data-icon="/" class="fa fa-user fa-fw"></i>
                                    <span class="hide-menu"><?php echo $this->lang['utilisateur']; ?></span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if (\app\core\Utils::authorized('administration', 'suiviListe')) { ?>
                            <li>
                                <a href="<?php echo WEBROOT . "administration/suiviListe" ?>">
                                    <i data-icon="/" class="ti-list fa-fw"></i>
                                    <span class="hide-menu"><?php echo $this->lang['suivi_action']; ?></span>
                                </a>
                            </li>
                        <?php } ?>


                        <?php if (\app\core\Utils::authorized('partenaire', 'liste')) { ?>

                        <li>
                            <a href="<?php echo WEBROOT . "partenaire/liste" ?>">
                                <i data-icon="/" class="fa fa-user fa-fw"></i>
                                <span class="hide-menu"><?php echo $this->lang['partenaire']; ?></span>
                            </a>
                        </li>
                        <?php } ?>

                        <?php if (\app\core\Utils::authorized('versement', 'historique')) { ?>

                            <li>
                                <a href="<?php echo WEBROOT . "fichier/type" ?>">
                                    <i data-icon="/" class="fa fa-sort-amount-asc fa-fw"></i>
                                    <span class="hide-menu"><?php echo $this->lang['type_file']; ?></span>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if (\app\core\Utils::authorized('administration', 'dictionnaire')) { ?>
                            <li>
                                <a href="<?php echo WEBROOT . "administration/dictionnaire" ?>">
                                    <i data-icon="/" class="ti-list fa-fw"></i>
                                    <span class="hide-menu"><?php echo $this->lang['dictionnaire']; ?></span>
                                </a>
                            </li>
                        <?php } ?>


                    </ul>
                </li>
                <?php } ?>



                <?php if(\app\core\Utils::authorized(null, null, "Versement")){ ?>
                    <li>
                        <a href="#" class="waves-effect">
                            <i class="fa fa-file fa-fw" data-icon="v"></i>
                            <span class="hide-menu"> <?php echo $this->lang['generation_file']; ?> <span class="fa arrow"></span> </span>
                        </a>
                        <ul class="nav nav-second-level">
                            <?php if (\app\core\Utils::authorized('versement', 'collectEncours')) { ?>
                                <li>
                                    <a href="<?php echo WEBROOT . "fichier/liste" ?>">
                                        <i data-icon="/" class="fa fa-file-text fa-fw"></i>
                                        <span class="hide-menu""><?php echo $this->lang['txt_to_excel']; ?></span>
                                    </a>
                                </li>
                            <?php } ?>


                           <?php if (\app\core\Utils::authorized('versement', 'collectEncours')) {?>
                                <li>
                                    <a href="<?php echo WEBROOT . "fichier/listeExcel" ?>">
                                        <i data-icon="/" class="fa fa-file-excel-o fa-fw"></i>
                                        <span class="hide-menu""><?php echo $this->lang['xls_to_xml']; ?></span>
                                    </a>
                                </li>
                            <?php } ?>

                            <!--                            <?php /*if (\app\core\Utils::authorized('versement', 'historique')) { */?>

                                <li>
                                    <a href="<?php /*echo WEBROOT . "fichier/type" */?>">
                                        <i data-icon="/" class="fa fa-sort-amount-asc fa-fw"></i>
                                        <span class="hide-menu"><?php /*echo $this->lang['type_file']; */?></span>
                                    </a>
                                </li>
                            --><?php /*} */?>

                        </ul>
                    </li>
                <?php } ?>





            </ul>

        </div>
    </div>
