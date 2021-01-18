
<div id="page-wrapper">
    <div class="container-fluid">

        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title"><?php echo $this->lang['detail_reception']; ?></h4></div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li>
                        <a href="#">  <?php echo $this->lang['gestioncarte']; ?></a>
                    </li>
                    <li class="active"><?php echo $this->lang['detail_reception']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <div class="row">
                        <table class="table table-bordered">

                            <tbody>
                            <tr>
                                <td ><?php echo $this->lang['Carte_stock_initial']; ?>:</td>
                                <td ><?php echo $stock_recu->nbre; ?></td>
                            </tr>
                            <tr >
                                <td ><?php echo $this->lang['Carte_Enstock']; ?>: </td>
                                <td><?php echo $stock_restant->nbre; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo $this->lang['Carte_vendu']; ?>: </td>
                                <td> <?php echo $embosse->nbre; ?></td>
                            </tr>
                            <tr>
                                <td> <?php echo $this->lang['Carte_endommage']; ?>: </td>
                                <td> <?php echo $endommage->nbre; ?></td>
                            </tr>
                            <tr >
                                <td> <?php echo $this->lang['Carte_distribue']; ?>: </td>
                                <td> <?php echo $distribue->nbre; ?></td>
                            </tr>
                           <!-- <tr>
                                <td><?php /*echo $this->lang['Carte_enrole']; */?>: </td>
                                <td><?php /*echo $enrolle->nbre; */?></td>
                            </tr>-->
                            </tbody>
                        </table>


                    </div>

                    </div>
                    <br> <br>
                    <div class="col-lg-12">
                        <a href="<?= WEBROOT ?>carte/reception">
                        <h3 class="panel-title pull-right">
                            <button type="button" class="btn btn-success"
                            <i class="fa fa-arrow-left"></i> <?php echo $this->lang['retour']; ?>
                            </button>
                        </h3>
                        </a>
                        <br> <br>
                    </div>
                <br> <br>
                    <br>
                </div>
            </div>
        </div>

    </div>
</div>