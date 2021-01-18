<div id="page-wrapper">
    <div class="container-fluid">

        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title"><?php echo $this->lang['liste_carte_retournee']; ?></h4></div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo WEBROOT . 'carte/retourcarte'; ?>">  <?php echo $this->lang['gestioncarte']; ?></a>
                    </li>
                    <li class="active"><?php echo $this->lang['liste_des_carte_retournee']; ?></li>
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
                                   data-url="<?php echo WEBROOT; ?>carte/retourcarteProcessing">
                                <thead>
                                <tr>
                                    <th><?php echo $this->lang['ref_carte']; ?></th>
                                    <th><?php echo $this->lang['date_retour']; ?></th>
                                    <th><?php echo $this->lang['agence_retour']; ?></th>
                                    <th><?php echo $this->lang['num_debut_carte']; ?></th>
                                    <th><?php echo $this->lang['num_fin_carte']; ?></th>
                                    <th><?php echo $this->lang['stock_retour']; ?></th>
                                    <th><?php echo $this->lang['motif']; ?></th>
                                    <th><?php echo $this->lang['actions']; ?></th>

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