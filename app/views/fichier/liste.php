    <div id="page-wrapper">
        <div class="container-fluid">

            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title"><?php echo $this->lang['listeFileGenered']; ?></h4> </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                    <ol class="breadcrumb">
                        <li><a href="<?= WEBROOT.'administration/index'; ?>">  <?php echo $this->lang['administration']; ?></a></li>
                        <li class="active"><?php echo $this->lang['listeFileGenered']; ?></li>
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">

                        <!--<h3 class="box-title">Blank Starter page</h3> </div>-->

                        <div class="row">
                            <div class="col-lg-12">
                                <h3 class="panel-title pull-right">

                                    <button type="button" class="open-modal btn btn-success"
                                            data-modal-controller="fichier/fichierModal"
                                            data-modal-view="fichier/fichierModal">
                                        <i class="fa fa-plus"></i> <?php echo $this->lang['chargerFile']; ?>
                                    </button>
                                </h3>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table table-bordered table-hover table-responsive processing"
                                       data-url="<?= WEBROOT; ?>fichier/listeProcessing">
                                    <thead>
                                    <tr>
                                        <th><?php echo $this->lang['date_chargement']; ?></th>
                                        <th><?php echo $this->lang['nom_fichier']; ?></th>
                                        <th><?php echo $this->lang['periode']; ?></th>
                                        <th><?php echo $this->lang['nb_ligne']; ?></th>
                                       <!-- <th><?php /*echo $this->lang['nb_success']; */?></th>-->
                                        <th><?php echo $this->lang['nb_error']; ?></th>
                                        <th><?php echo $this->lang['montant']; ?>(XOF)</th>
                                        <th><?php echo $this->lang['thEtat']; ?></th>
                                        <th><?php echo $this->lang['labAction']; ?></th>

                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>



