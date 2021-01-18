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
                <h4 class="page-title"><?php echo $this->lang['histo_tpe']; ?></h4></div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li>
                        <a href="#">  <?php echo $this->lang['ges_tpe']; ?></a>
                    </li>
                    <li class="active"><?php echo $this->lang['liste_tpe']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border"><?php echo $this->lang['filtre_periodique']; ?></legend><br/>
                        <form class="form-horizontal" method="POST" action="<?php echo WEBROOT ?>tpe/historique">

                            <div  class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                <div class="form-group">
                                    <label for="nom" class="col-lg-3 col-sm-4 control-label"><?php echo $this->lang['du']; ?></label>
                                    <div class="col-lg-9 col-sm-8">
                                        <input type="date" class="form-control" placeholder="dd-mm-yyyy" name="datedebut" id="from" value="<?php echo $datedebut; ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                <div class="form-group">
                                    <label for="nom" class="col-lg-3 col-sm-4 control-label"><?php echo $this->lang['au']; ?></label>
                                    <div class="col-lg-9  col-sm-8">
                                        <input type="date" class="form-control" placeholder="dd-mm-yyyy" name="datefin" id="from" value="<?php echo $datefin; ?>"/>

                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-1">
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
                            <table class="table table-bordered table-hover table-responsive processing"
                                   data-url="<?= WEBROOT; ?>tpe/listehistoAffectationProcessing/<?php echo $datedebut; ?>/<?php echo $datefin; ?>">
                                <thead>
                                <tr>
                                    <th><?php echo $this->lang['date_affectation']; ?></th>
                                    <th><?php echo $this->lang['tpe']; ?></th>
                                    <th><?php echo $this->lang['prenom_collecteur']; ?></th>
                                    <th><?php echo $this->lang['nom_collecteur']; ?></th>
                                    <th><?php echo $this->lang['finAffectation']; ?></th>
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
        margin-bottom: auto;
</style>

<script>
    $(function() {
        $( "#from" ).datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 1,
            onClose: function( selectedDate ) {
                $( "#to" ).datepicker( "option", "minDate", selectedDate );
            }
        });
    });
</script>