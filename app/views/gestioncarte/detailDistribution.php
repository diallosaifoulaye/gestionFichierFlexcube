
<div id="page-wrapper">
    <div class="container-fluid">

        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title"><?php echo $this->lang['detail_distribution']; ?></h4></div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li>
                        <a href="<?= WEBROOT . 'administration/index'; ?>">  <?php echo $this->lang['administration']; ?></a>
                    </li>
                    <li class="active"><?php echo $this->lang['detail_distribution']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <div class="row">
                        <form id="validation" class="form-inline form-validator" data-type="update" role="form" action="<?= WEBROOT ?>carte/nouveauDistribution" method="post">

                        <table class="table table-bordered">

                                <tbody>
                                <tr>
                                    <td ><?php echo $this->lang['ref_carte']; ?>:</td>
                                    <td ><?php echo $distribution->num_reference; ?></td>
                                </tr>
                                <tr >
                                    <td ><?php echo $this->lang['agence_retour']; ?>: </td>
                                    <td><?php echo $distribution->label ; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang['num_debut_carte']; ?>: </td>
                                    <td> <?php echo $distribution->num_debut; ?></td>
                                </tr>
                                <tr>
                                    <td> <?php echo $this->lang['num_fin_carte']; ?>: </td>
                                    <td> <?php echo $distribution->num_fin; ?></td>
                                </tr>
                                <tr>
                                    <td> <?php echo $this->lang['quantite_retour']; ?>: </td>
                                    <td> <?php echo $distribution->stock; ?></td>
                                </tr>


                                </tbody>
                            </table>

                            <input type="hidden" name="id" value="<?php echo $distribution->rowid ; ?>" >
                            <input type="hidden" name="num_debut" value="<?php echo $distribution->num_debut ; ?>" >
                            <input type="hidden" name="num_fin" value="<?php echo $distribution->num_fin ; ?>" >
                            <input type="hidden" name="stock_init" value="<?php echo $distribution->stock ; ?>" >
                            <input type="hidden" name="stock" value="<?php echo $distribution->stock ; ?>" >
                            <input type="hidden" name="user_add" value="<?php echo $this->_USER->id; ?>" >
                            <input type="hidden" name="date_add" value="<?php echo date('Y-m-d H:i:s') ; ?>" >
                            <input type="hidden" name="date_reception" value="<?php echo date('Y-m-d H:i:s') ; ?>" >


                            <br> <br> <br> <br> <br>
                            <div class="col-sm-6">
                                <a href="<?= WEBROOT ?>carte/listeretourcarte">
                                    <h3 class="panel-title pull-right">
                                        <button type="button" class="btn btn-success"
                                        <i class="fa fa-arrow-left"></i> <?php echo $this->lang['retour']; ?>
                                        </button>
                                    </h3>
                                </a>
                            </div>
                            <div class="col-sm-6">
                                <button  class="btn btn-success" data-form="my-form" type="submit"><i class="fa fa-check"></i> <?php echo $this->lang['distribuer']; ?>
                            </div>
                        </form>



                    </div>

                    </div>

                    <br>
                </div>
            </div>
        </div>

    </div>
</div>