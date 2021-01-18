

<div id="page-wrapper">

    <div class="container-fluid">

        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title"><?php echo $this->lang['localisationCollecteur']; ?></h4></div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li>
                        <a href="#">  <?php echo $this->lang['ges_tpe']; ?></a>
                    </li>
                    <li class="active"><?php echo $this->lang['localisation']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>



        <div class="row">

            <div class="white-box">


                <div class="tab-content">
                    <div>
                            <table id="datatable" class="table dataTable table-bordered table-hover table-responsive">
                                <thead>
                                <tr>
                                    <th><?php echo $this->lang['prenom']; ?></th>
                                    <th><?php echo $this->lang['nom']; ?></th>
                                    <th><?php echo $this->lang['code']; ?></th>
                                    <th><?php echo $this->lang['date_transact']; ?></th>
                                    <th><?php echo $this->lang['position']; ?></th>
                                    <th><?php echo $this->lang['labAction']; ?></th>

                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($transactions as $transaction){?>
                                    <tr>
                                        <th><?php echo $transaction->prenom; ?></th>
                                        <th><?php echo $transaction->nom; ?></th>
                                        <th><?php echo $transaction->codeCollecteur; ?></th>
                                        <th><?php echo  \app\core\Utils::getDateFR($transaction->date_transac); ?></th>
                                        <th><?php echo $transaction->position; ?></th>
                                        <th><a href="<?= WEBROOT.'transaction/localiser/'; ?><?php echo $transaction->latitudes; ?>/<?php echo $transaction->longitude; ?>/"><i class="fa fa-1x fa fa-search"></i></a></th>
                                    </tr>
                                <?}?>
                                </tbody>
                            </table>



                    </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>




