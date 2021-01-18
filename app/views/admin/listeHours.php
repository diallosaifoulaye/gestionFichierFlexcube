<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="row white-box" style="margin-top:0px; margin-bottom: 4px">

                <div class="col-lg-10 col-sm-6 annulation">


                </div>
            </div>
        </div>
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title"><?php echo $this->lang['hoursBis']; ?></h4></div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo WEBROOT . 'adminisration/listeRegion'; ?>">  <?php echo $this->lang['config']; ?></a>
                    </li>
                    <li class="active"><?php echo $this->lang['hoursBis']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3 class="panel-title pull-right">
<!--                                <button type="button" class="open-modal btn btn-success"-->
<!--                                        data-modal-controller="administration/hoursModal"-->
<!--                                        data-modal-view="admin/hourModal">-->
<!--                                    <i class="fa fa-plus"></i> --><?php //echo $this->lang['hours2']; ?>
<!--                                </button>-->
                            </h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered table-hover table-responsive processing"
                                   data-url="<?php echo WEBROOT; ?>administration/hoursProcessing">
                                <thead>
                                <tr>
                                    <th><?php echo $this->lang['hours5']; ?></th>
                                    <th><?php echo $this->lang['hours6']; ?></th>
<!--                                    <th>--><?php //echo $this->lang['labAction']; ?><!--</th>-->
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