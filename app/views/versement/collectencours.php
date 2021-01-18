<div id="page-wrapper">
    <div class="container-fluid">

        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title"><?php echo $this->lang['collectnonversees']; ?></h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="#">  <?php echo $this->lang['versements']; ?></a></li>
                    <li class="active"><?php echo $this->lang['do_versement']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="white-box">


                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered table-hover table-responsive processing"
                                   data-url="<?= WEBROOT; ?>versement/versementProcessing">
                                <thead>
                                <tr>
                                    <th><?php echo $this->lang['nom']; ?></th>
                                    <th><?php echo $this->lang['prenom']; ?></th>
                                    <th><?php echo $this->lang['code']; ?></th>
                                    <th><?php echo $this->lang['nb_jour']; ?></th>
                                    <th><?php echo $this->lang['montant_collecte']; ?> (XOF)</th>
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



