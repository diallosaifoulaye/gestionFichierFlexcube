    <div id="page-wrapper">
        <div class="container-fluid">

            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title"><?php echo $this->lang['detail_fichier_charge']; ?></h4> </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                    <ol class="breadcrumb">
                        <li><a href="<?= WEBROOT.'administration/index'; ?>">  <?php echo $this->lang['administration']; ?></a></li>
                        <li class="active"><?php echo $this->lang['detail_fichier_charge']; ?></li>
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">

                        <ul class="nav nav-tabs tabs customtab">
                            <li class=" tab active">
                                <a href="#info" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs"><?= $this->lang['info_fichier']; ?></span> </a>
                            </li>
                            <li class="tab">
                                <a href="#home" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs"><?= $this->lang['lines_non_charge']; ?></span> </a>
                            </li>
                            <li class="tab">
                                <a href="#lines_charge" data-toggle="tab" aria-expanded="false"> <span class="visible-xs">
                                    <i class="fa fa-cog"></i></span> <span class="hidden-xs"><?= $this->lang['lines_charge']; ?></span> </a>
                            </li>


                        </ul>
                        <!-- /.tabs -->
                        <div class="tab-content">
                            <!-- .tabs3 -->

                            <div class="tab-pane active" id="info">

                                <div class="white-box">
                                    <!--                    <div class="user-bg"> <img width="100%" alt="user" src="../plugins/images/large/img1.jpg"> </div>-->
                                    <div class="col-sm-7" align="center"> <img class="img-circle" width="200"  > </div>
                                    <div class="user-btm-box">

                                        <div class="row text-center m-t-10">
                                            <div class="col-md-6 b-r"><strong><?= $this->lang['libelle']; ?></strong>
                                                <p><?= $fichier->libelle." ".$fichier->rowid; ?></p>
                                            </div>
                                            <div class="col-md-6"><strong><?= $this->lang['periode']; ?></strong>
                                                <p><?= $fichier->periode; ?></p>
                                            </div>
                                        </div>
                                        <!-- /.row -->
                                        <hr>
                                        <!-- .row -->
                                        <div class="row text-center m-t-10">
                                            <div class="col-md-6 b-r"><strong><?= $this->lang['nb_ligne']; ?></strong>
                                                <p><?= $fichier->nb_ligne; ?></p>
                                            </div>
                                            <div class="col-md-6"><strong><?= $this->lang['lien']; ?></strong>
                                                <p><?= $fichier->lien; ?></p>
                                            </div>
                                        </div>
                                        <!-- /.row -->
                                        <hr>

                                        <div class="row text-center m-t-10">
                                            <div class="col-md-6 b-r"><strong><?= $this->lang['nb_success']; ?></strong>
                                                <p class="text-success"><?= $fichier->nb_succes; ?></p>
                                            </div>
                                            <div class="col-md-6"><strong><?= $this->lang['lines_non_charge']; ?></strong>
                                                <p class="text-danger"><?= $fichier->nb_ligne - $fichier->nb_succes; ?></p>
                                            </div>
                                        </div>
                                        <!-- /.row -->
                                        <hr>

                                        <div class="row text-center m-t-10">
                                            <div class="col-md-6 b-r"><strong><?= $this->lang['date_chargement']; ?></strong>
                                                <p><?= \app\core\Utils::getDateFR($fichier->date_creation) ; ?></p>
                                            </div>
                                            <div class="col-md-6"><strong><?= $this->lang['duree_chargement']; ?></strong>
                                                <p>25<?/*= $fichier->montant; */?></p>
                                            </div>
                                        </div>
                                        <!-- /.row -->
                                        <hr>
                                        <!-- .row -->
                                        <div class="row text-center m-t-10">
                                            <div class="col-md-6 b-r"><strong><?= $this->lang['thEtat']; ?></strong>
                                                <?php

                                                if ($fichier->etat == 2 ){
                                                    $text =strtoupper($this->lang['rejet']);
                                                    $classe = 'text-danger' ;

                                                }elseif($fichier->etat == 1 ){
                                                    $text = strtoupper($this->lang['valide']);
                                                    $classe = 'text-success' ;
                                                }else{
                                                    $text = strtoupper($this->lang['en_attente']);
                                                    $classe = 'text-info' ;
                                                }
                                                ?>
                                                <p><?= $fichier->numero_serie; ?> (<span class="<?= $classe ?>"><?=  $text ?></span>)</p>
                                            </div>
                                            <div class="col-md-6"><strong><?= $this->lang['montant']; ?></strong>
                                                <p><?= \app\core\Utils::getFormatMoney($fichier->montant)." ".$this->lang['currency'] ; ?></p>
                                            </div>

                                        </div>

                                        <hr>

                                    </div>



                                </div>


                                <br>
                                <div class="row">

                                    <div class="col-md-3">
                                        <a  style="background: #325186; border:1px solid #325186" class="btn btn-info" href="<?php echo WEBROOT . "fichier/liste" ?>"><?= $this->lang['btnRetour'] ; ?></a>

                                    </div>
                                   <!-- <div class="col-md-3">

                                        <?php /*if ($fichier->etat == 0){ */?>

                                            <button type="button" style="background: #325186; border:1px solid #325186" class="btn btn-info" data-toggle="modal"
                                                    data-target="#activerCarte"><?/*= $this->lang['valide'] ; */?></button>

                                            <button type="button" style="background: #325186; border:1px solid #325186" class="btn btn-info" data-toggle="modal"
                                                    data-target="#blockerCarte"><?/*= $this->lang['rejet'] ; */?></button>
                                        <?/*}*/?>

                                        <?php /*if ($fichier->etat == 2){ */?>

                                            <button type="button" style="background: #325186; border:1px solid #325186" class="btn btn-info" data-toggle="modal"
                                                    data-target="#activerCarte"><?/*= $this->lang['valide'] ; */?></button>
                                        <?/*}*/?>
                                        <?php /*if ($fichier->etat == 1){ */?>
                                            <button type="button" style="background: #325186; border:1px solid #325186" class="btn btn-info" data-toggle="modal"
                                                    data-target="#blockerCarte"><?/*= $this->lang['rejet'] ; */?></button>
                                        <?/*}*/?>

                                    </div>-->
                                    <div class="col-md-2  pull-right">

                                            <form action="<?= WEBROOT.'fichier/exportRapport/'; ?>"  method="post" name="form2" target="_blank">

                                               <input name="rowid" type="hidden" value="<?= $fichier->rowid ?>" />
                                                <!--<input name="fk_client" type="hidden" value="<?/*= $data['retrait']['fk_client'] */?>" />-->

                                                <button name="PDF" type="submit" value="PDF" class="btn btn-default text-red" title="<?= $data['lang']['imprimer']; ?>">
                                                    <i class="fa fa-2x fa-file-pdf-o"></i>
                                                </button>

                                            </form>

                                    </div>


                                </div>





                            </div>

                            <div class="tab-pane " id="home">


                                <div class="row">
                                    <div class="col-lg-12">

                                        <table class="table table-bordered table-hover table-responsive processing"
                                               data-url="<?= WEBROOT; ?>fichier/listeLineErrorProcessing__/<?= base64_encode($fichier->rowid) ?>">
                                            <thead>
                                            <tr>
                                                <th> <?php echo $this->lang['num_line']; ?></th>
                                                <th> <?php echo $this->lang['line']; ?></th>
                                                <th> <?php echo $this->lang['commentaire']; ?></th>
                                                <th> <?php echo $this->lang['labAction']; ?></th>

                                            </tr>
                                            </thead>
                                        </table>

                                    </div>
                                </div>

                            </div>


                            <div class="tab-pane " id="lines_charge">

                                <div class="row">
                                    <div class="col-lg-12">

                                        <table class="table table-bordered table-hover table-responsive processing"
                                               data-url="<?= WEBROOT; ?>fichier/listeLineSuccesProcessing__/<?= base64_encode($fichier->rowid) ?>">
                                            <thead>
                                            <tr>
                                                <th> <?php echo $this->lang['num_line']; ?></th>
                                                <th> <?php echo $this->lang['line']; ?></th>

                                            </tr>
                                            </thead>
                                        </table>

                                    </div>
                                </div>


                            </div>


                            <!-- /.tabs3 -->
                            <!-- .tabs3 -->

                            <!-- /.tabs3 -->
                        </div>





                    </div>
                </div>

            </div>

        </div>

    </div>



