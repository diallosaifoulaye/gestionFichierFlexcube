<style>
    .param {
        margin-bottom: 7px;
        line-height: 1.4;
        font-size: 19px;
    }
    .param-inline dt {
        display: inline-block;
    }
    .param dt {
        margin: 0;
        margin-right: 40px;
        font-weight: 600;
        color: black;
    }
    .param-inline dd {
        vertical-align: baseline;
        display: inline-block;
    }

    .param dd {
        margin: 0;
        margin-right: 40px;
        vertical-align: baseline;
    }

    .shopping-cart-wrap .price {
        color: #007bff;
        font-size: 18px;
        font-weight: bold;
        margin-right: 5px;
        display: block;
    }
    var {
        font-style: normal;
    }

    .media img {
        margin-right: 1rem;
    }
    .img-sm {
        width: 90px;
        max-height: 75px;
        object-fit: cover;
    }
</style>

<div id="page-wrapper">

    <div class="container-fluid">

        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title"><?php echo $this->lang['detail_versement']; ?></h4></div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li>
                        <a href="#">  <?php echo $this->lang['versement']; ?></a>
                    </li>
                    <li class="active"><?php echo $this->lang['detail_versement']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>



        <div class="row">

            <div class="white-box">

                <ul class="nav nav-tabs tabs customtab">
                    <li class="tab active">
                        <a href="#mesinfos" data-toggle="tab" >
                <span class="visible-xs">
                    <i class="fa fa-info"></i>
                </span>
                            <span class="hidden-xs"><?php echo $this->lang['infos_versement']; ?></span>
                        </a>
                    </li>
                    <li class="tab">
                        <a href="#mdp" data-toggle="tab" >
                <span class="visible-xs">
                    <i class="fa fa-lock"></i>
                </span>
                            <span class="hidden-xs"><?php echo $this->lang['detail_versement']; ?></span>

                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="mesinfos">
                        <?php //var_dump($versement);exit;?>

                        <table>
                            <tr class="param param-inline small">
                                <td style="text-align: right" ><dt><?php echo $this->lang['date_versement']; ?> : </dt></td>
                                <td style="text-align: left"><dd style=": left"><?php echo \app\core\Utils::getDateFR($versement->date_creation) ; ?></dd></td>
                            </tr>
                            <?php if($versement->nb_collecte == 1){ ?>
                                <tr class="param param-inline small">
                                    <td style="text-align: right" ><dt><?php echo $this->lang['collecte']; ?> : </dt></td>
                                    <td style="text-align: left"><dd style=": left"><?php echo \app\core\Utils::getDateFR($versement->date_versement) ; ?></dd></td>
                                </tr>
                            <?}?>
                            <?php if($versement->nb_collecte > 1){ ?>
                                <tr class="param param-inline small">
                                    <td style="text-align: right" ><dt><?php echo $this->lang['nb_jour']; ?> : </dt></td>
                                    <td style="text-align: left"><dd style=": left"><?php echo $versement->nb_collecte; ?></dd></td>
                                </tr>
                            <?}?>
                            <tr class="param param-inline small">
                                <td style="text-align: right" ><dt><?php echo $this->lang['montant']; ?> : </dt></td>
                                <td style="text-align: left"><dd style=": left"><?php echo \app\core\Utils::getFormatMoney($versement->montant).' (XOF)' ; ?></dd></td>
                            </tr>
                            <tr class="param param-inline small">
                                <td style="text-align: right" ><dt><?php echo $this->lang['collecteur']; ?> : </dt></td>
                                <td style="text-align: left"><dd style=": left"><?php echo $versement->label; ?></dd></td>
                            </tr>
                        </table>

                    </div>

                    <div class="tab-pane" id="mdp" >

                        <br/><br/>

                        <table class="table table-bordered table-hover table-responsive processing"
                               data-url="<?= WEBROOT; ?>versement/detailsProcess/<?php echo $versement->rowid ?>">
                            <thead>
                            <tr>
                                <th><?php echo $this->lang['collecte']; ?></th>
                                <th><?php echo $this->lang['collectteur']; ?></th>
                                <th style="text-align: right"><?php echo $this->lang['montant']; ?> (XOF)</th>

                            </tr>
                            </thead>
                        </table>



                    </div>


                    <br> <br> <br> <br> <br> <br> <br>
                    <div class="col-lg-12">

                        <div class="col-lg-6">
                            <div class="col-sm-2 pull-left">
                                <form action="<?= WEBROOT.'versement/exportRecu/'; ?>"  method="post" name="form2" target="_blank">

                                    <input name="rowid" type="hidden" value="<?= $versement->rowid ?>" />
                                    <!--<input name="fk_client" type="hidden" value="<?/*= $data['retrait']['fk_client'] */?>" />-->

                                    <button name="PDF" type="submit" value="PDF" class="btn btn-default text-red" title="<?= $data['lang']['recu']; ?>">
                                        <i class="fa fa-2x fa-file-pdf-o"></i>
                                    </button>

                                </form>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <a href="<?= WEBROOT ?>versement/historique">
                                <h3 class="panel-title pull-right">
                                    <button type="button" class="btn btn-success"
                                    <i class="fa fa-arrow-left"></i> <?php echo $this->lang['versements']; ?>
                                    </button>
                                </h3>
                            </a>
                        </div>

                    </div>

                    <br> <br> <br> <br>

                </div>


                    </div>

                </div>
            </div>


        </div>

