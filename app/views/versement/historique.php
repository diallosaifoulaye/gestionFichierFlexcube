<div id="page-wrapper">
    <div class="container-fluid">

        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title"><?php echo $this->lang['histo_versement']; ?></h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="#">  <?php echo $this->lang['versements']; ?></a></li>
                    <li class="active"><?php echo $this->lang['histo_versement']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border"><?php echo $this->lang['filtre_periodique']; ?></legend><br/>
                        <form class="form-horizontal" method="POST" action="<?php echo WEBROOT ?>versement/historique">

                            <div  class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <div class="form-group">
                                    <label for="nom" class="col-lg-3 col-sm-4 control-label"><?php echo $this->lang['du']; ?></label>
                                    <div class="col-lg-9 col-sm-8">
                                        <input type="date" class="form-control" placeholder="dd-mm-yyyy" name="datedebut" id="from" value="<?php echo $datedebut; ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <div class="form-group">
                                    <label for="nom" class="col-lg-6 col-sm-6 control-label"><?php echo $this->lang['au']; ?></label>
                                    <div class="col-lg-6  col-sm-6">
                                        <input type="date" class="form-control" placeholder="dd-mm-yyyy" name="datefin" id="from" value="<?php echo $datefin; ?>"/>

                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                <div class="form-group">
                                    <label for="nom" class="col-lg-6 col-sm-6 control-label"><?php echo $this->lang['collecteur']; ?></label>
                                    <div class="col-lg-6  col-sm-6">
                                        <select name="collecteurT" class="select2">
                                            <option value="">Choisir Collecteur </option>
                                            <?php foreach($collecteurs as $collecteur){ ?>
                                                <option  <?= ($collecteur->id == $collecteurT) ? "selected" : "" ?> value="<?php echo $collecteur->id ?>"><?php echo $collecteur->label ?></option>
                                            <?}?>
                                        </select>

                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                                <button type="submit" class="btn btn-success btn-circle btn-lg" title="Rechercher"><i class="ti-search"></i></button>
                            </div>

                        </form>
                    </fieldset>
                </div>
            </div>

        </div>

        <div class="row">

            <div class="col-md-12">
                <div class="white-box">


                    <div class="row">
                        <div class="col-lg-12">
                            <a href="<?= WEBROOT?>versement/export/<?php echo $datedebut; ?>/<?php echo $datefin; ?>/<?php echo $collecteurT; ?>" target="_blank" class="btn btn-plus pull-right m-l-20  waves-effect waves-light" >
                                <i class="fa fa-file-pdf-o"></i> <?= $this->lang['export']; ?>
                            </a>
                            <table class="table table-bordered table-hover table-responsive processing"
                                   data-url="<?= WEBROOT; ?>versement/historiqueProcessing/<?php echo $datedebut; ?>/<?php echo $datefin; ?>/<?php echo $collecteurT; ?>">
                                <thead>
                                <tr>
                                    <th><?php echo $this->lang['date']; ?></th>
                                    <th style="text-align: right"><?php echo $this->lang['montant']; ?> (XOF)</th>
                                    <th style="text-align: center"><?php echo $this->lang['nombre']; ?></th>
                                    <th><?php echo $this->lang['collectteur']; ?></th>



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
<style>
    legend.scheduler-border {
        font-size: 1.1em !important;
        font-weight: normal !important;
        text-align: left !important;
        border-bottom: none;
        background-color: #0a7242;
        color: #fff;
        padding: 5px 30px;
        display: block;
        width: auto;
        margin-bottom: auto;}

    .btn-plus, .btn-plus.disabled {
        background: #0a7242;!important;
        margin-bottom: 10px;!important;
    }
</style>




