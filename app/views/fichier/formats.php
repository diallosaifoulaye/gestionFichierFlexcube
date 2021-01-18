    <div id="page-wrapper">
        <div class="container-fluid">

            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title"><?php echo $this->lang['format_file']." ".$fichier->libelle."(".$fichier->extension.")"; ?></h4> </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                    <ol class="breadcrumb">
                        <li><a href="<?= WEBROOT.'administration/index'; ?>">  <?php echo $this->lang['fichiers']; ?></a></li>
                        <li class="active"><?php echo $this->lang['format_file']; ?></li>
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
                                            data-modal-controller="fichier/infosfichierModal/<?= $fichier->rowid ?>"
                                            data-modal-view="fichier/infosfichierModal">
                                        <i class="fa fa-plus"></i> <?php echo $this->lang['ajoutColonne']; ?>
                                    </button>
                                </h3>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table table-bordered table-hover table-responsive processing"
                                       data-url="<?= WEBROOT; ?>fichier/listeFormatProcessing/<?php echo base64_encode($fichier->rowid) ;?>">
                                    <thead>
                                    <tr>
                                        <th><?php echo $this->lang['position']; ?></th>
                                        <th><?php echo $this->lang['nom_colonne']; ?></th>
                                        <th><?php echo $this->lang['type']; ?></th>
                                        <th><?php echo $this->lang['longueur']; ?></th>
                                        <th><?php echo $this->lang['de']; ?></th>
                                        <th><?php echo $this->lang['a']; ?></th>
                                        <th><?php echo $this->lang['commentaire']; ?></th>
                                        <th><?php echo $this->lang['thEtat']; ?></th>
                                        <th><?php echo $this->lang['labAction']; ?></th>
                                        <!--<th><?php /*echo $this->lang['labAction']; */?></th>-->
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



