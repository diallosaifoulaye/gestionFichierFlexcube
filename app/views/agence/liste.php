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
                <h4 class="page-title"><?php echo $this->lang['agence_list']; ?></h4></div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li>
                        <a href="<?= WEBROOT . 'administration/index'; ?>">  <?php echo $this->lang['administration']; ?></a>
                    </li>
                    <li class="active"><?php echo $this->lang['agence_list']; ?></li>
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
                                <button type="button" class="open-modal btn btn-success"
                                        data-modal-controller="agence/newAgence"
                                        data-modal-view="agence/create">
                                    <i class="fa fa-plus"></i> <?php echo $this->lang['agence_new']; ?>
                                </button>
                            </h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered table-hover table-responsive processing"
                                   data-url="<?= WEBROOT; ?>agence/listeProcessing">
                                <thead>
                                <tr>
                                    <th><?php echo $this->lang['code_cr']; ?></th>
                                    <th><?php echo $this->lang['agence_libelleBis']; ?></th>
                                    <th><?php echo $this->lang['agence_resp']; ?></th>
                                    <th><?php echo $this->lang['commune']; ?></th>
                                    <th><?php echo $this->lang['labadresse']; ?></th>
                                    <th><?php echo $this->lang['tel_four']; ?></th>
                                    <th><?php echo $this->lang['email_four']; ?></th>
                                    <th><?php echo $this->lang['thEtat']; ?></th>
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