
<div id="page-wrapper">
    <div class="container-fluid">

        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title"><?php echo $this->lang['detail_embosse']; ?></h4></div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li>
                        <a href="<?= WEBROOT . 'administration/index'; ?>">  <?php echo $this->lang['administration']; ?></a>
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
                        <form id="validation" class="form-inline form-validator" data-type="update" role="form" action="<?= WEBROOT ?>carte/updateCarteStock" method="post">

                        <table class="table table-bordered">

                                <tbody>
                                <tr>
                                    <td ><?php echo $this->lang['nomclient'].' & '.$this->lang['prenomclient']; ?>:</td>
                                    <td ><?php echo $detail->nom_complet_client; ?></td>
                                </tr>
                                <tr >
                                    <td ><?php echo $this->lang['tel_client']; ?>: </td>
                                    <td><?php echo $detail->telephone; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang['num_carte']; ?>: </td>
                                    <td> <?php echo $detail->numero; ?></td>
                                </tr>
                                <tr>
                                    <td> <?php echo $this->lang['num_serie']; ?>: </td>
                                    <td> <?php echo $detail->numero_serie; ?></td>
                                </tr>
                                <tr>
                                    <td> <?php echo $this->lang['agence']; ?>: </td>
                                    <td> <?php echo $detail->label; ?></td>
                                </tr>

                                </tbody>
                            </table>
                            <input type="hidden" name="numseriecarte" value="<?php echo $detail->numero_serie; ?>" >
                            <input type="hidden" name="agence" value="<?php echo $detail->fk_agence; ?>" >

                            <br> <br> <br> <br> <br>
                            <div class="col-sm-6">
                                <a href="<?= WEBROOT ?>carte/carteListe">
                                    <h3 class="panel-title pull-right">
                                        <button type="button" class="btn btn-success"
                                        <i class="fa fa-arrow-left"></i> <?php echo $this->lang['retour']; ?>
                                        </button>
                                    </h3>
                                </a>
                            </div>
                            <div class="col-sm-6">
                                <button  class="btn btn-success" data-form="my-form" type="submit"><i class="fa fa-check"></i> <?php echo $this->lang['embosse']; ?>
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