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
                <h4 class="page-title"><?php echo $this->lang['ListcardToCust']; ?></h4></div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li>
                        <a href="#">  <?php echo $this->lang['operationcarte']; ?></a>
                    </li>
                    <li class="active"><?php echo $this->lang['ListcardToCust']; ?></li>
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
                                   data-url="<?php echo WEBROOT; ?>carte/carteClientProcessing">
                                <thead>
                                <tr>
                                    <th><?php echo $this->lang['nomclient'].' & '.$this->lang['prenomclient']; ?></th>
                                    <th><?php echo $this->lang['tel_client']; ?></th>
                                    <th><?php echo $this->lang['num_carte']; ?></th>
                                    <th><?php echo $this->lang['date_exp_carte']; ?></th>
<!--                                    <th>--><?php //echo $this->lang['enroller_par']; ?><!--</th>-->
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