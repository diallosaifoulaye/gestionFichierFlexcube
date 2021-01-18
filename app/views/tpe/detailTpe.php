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
        <div class="row">
            <div class="row white-box" style="margin-top:0px; margin-bottom: 4px">
                <!--<div class="col-lg-2 col-sm-6 bg-theme text-white" style="height: 40px; vertical-align: middle; padding-top:10px;background-color: #0a7242 !important;">
                    <center><b><?php /*echo $this->lang['alaune'];*/?></b></center>
                </div>-->
                <div class="col-lg-10 col-sm-6 annulation">
                    <marquee>
                        <a href="">

                        </a>
                    </marquee>

                </div>
            </div>
        </div>
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title"><?php echo $this->lang['tpe_detail']; ?></h4></div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li>
                        <a href="<?= WEBROOT . 'tpe/liste'; ?>">  <?php echo $this->lang['ges_tpe']; ?></a>
                    </li>
                    <li class="active"><?php echo $this->lang['tpe_detail']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <div class="row">

                            <!-- Nav tabs --><div class="card">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><?php echo $this->lang['tpe_info']; ?></a></li>
                                    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><?php echo $this->lang['affectations_tpe']; ?></a></li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="home">
                                        <table>
                                            <tr class="param param-inline small">
                                                <td style="text-align: right" ><dt><?php echo $this->lang['tpe_libelle']; ?>: </dt></td>
                                                <td style="text-align: left"><dd style=": left"><?php echo $device->nom; ?></dd></td>
                                            </tr>
                                            <tr class="param param-inline small">
                                                <td style="text-align: right" ><dt><?php echo $this->lang['ref_tpe']; ?>: </dt></td>
                                                <td style="text-align: left"><dd style=": left"><?php echo $device->reference; ?></dd></td>
                                            </tr>
                                            <tr class="param param-inline small">
                                                <td style="text-align: right" ><dt><?php echo $this->lang['uiid']; ?>: </dt></td>
                                                <td style="text-align: left"><dd style=": left"><?php echo $device->uiid; ?></dd></td>
                                            </tr>
                                            <tr class="param param-inline small">
                                                <td style="text-align: right" ><dt><?php echo $this->lang['agence']; ?>: </dt></td>
                                                <td style="text-align: left"><dd style=": left"><?php echo $device->label; ?></dd></td>
                                            </tr>
                                        </table>

                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="profile">


                                        <div class="row">
                                            <div class="col-lg-12">
                                                <table class="table table-bordered table-hover table-responsive processing"
                                                       data-url="<?= WEBROOT; ?>tpe/listeAffectationProcessingTpe/<?php echo $device->rowid; ?>">
                                                    <thead>
                                                    <tr>
                                                        <th><?php echo $this->lang['date_affectation']; ?></th>
                                                        <th><?php echo $this->lang['tpe']; ?></th>
                                                        <th><?php echo $this->lang['prenom_collecteur']; ?></th>
                                                        <th><?php echo $this->lang['nom_collecteur']; ?></th>
                                                        <th><?php echo $this->lang['thEtat']; ?></th>

                                                    </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>




                                    </div>
                                </div>
                            </div>

                    </div>
                    <br> <br> <br> <br> <br> <br> <br>
                    <div class="col-lg-12">
                        <a href="<?= WEBROOT ?>tpe/liste">
                        <h3 class="panel-title pull-right">
                            <button type="button" class="btn btn-success"
                            <i class="fa fa-arrow-left"></i> <?php echo $this->lang['liste_tpe']; ?>
                            </button>
                        </h3>
                        </a>
                    </div>

                    <br>
                </div>
            </div>
        </div>

    </div>
</div>