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
                <h4 class="page-title"><?php echo $this->lang['dispocarte']; ?></h4></div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo WEBROOT . 'carte/reception'; ?>">  <?php echo $this->lang['gestioncarte']; ?></a>
                    </li>
                    <li class="active"><?php echo $this->lang['dispocarte']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>



        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border"><?php echo $this->lang['filtre_agence']; ?></legend><br/>
                        <form class="form-horizontal" method="POST" action="<?php echo WEBROOT ?>carte/disponibilite">

                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <div class="form-group">
                                    <label for="agence" class="col-lg-6 col-sm-6 control-label"><?php echo $this->lang['agence']; ?></label>
                                    <div class="col-lg-6  col-sm-6">
                                        <select name="agence" class="select2" id="agence">
                                            <option value=""><?php echo $this->lang['selectagence']; ?></option>
                                            <?php foreach($agences as $item){ ?>
                                                <option  <?= ($item->rowid == $agence) ? "selected" : "" ?> value="<?php echo $item->rowid ?>"><?php echo $item->label ?></option>
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
                            <table class="table table-bordered table-hover table-responsive processing" data-url="<?php echo WEBROOT; ?>carte/disponibiliteProcessing/<?php echo $agence; ?>">
                                <thead>
                                <tr>
                                    <th><?php echo $this->lang['agence']; ?></th>
                                    <th><?php echo $this->lang['nbcarterecu']; ?></th>
                                    <th><?php echo $this->lang['nbcartevendu']; ?></th>
                                    <th><?php echo $this->lang['nbcarterestante']; ?></th>
                                    <th><?php echo $this->lang['nbcarteretour']; ?></th>
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