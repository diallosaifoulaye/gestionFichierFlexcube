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
                <h4 class="page-title"><?php echo $this->lang['list_trans']; ?></h4></div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo WEBROOT . 'transaction/liste'; ?>">  <?php echo $this->lang['ges_trans']; ?></a>
                    </li>
                    <li class="active"><?php echo $this->lang['list_trans']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border"><?php echo $this->lang['valid_trans']; ?></legend>
                    <form name="form1" id="form1" class="form-inline form-validator "   action="<?= WEBROOT ?>transaction/updateValidation" method="post">
                        <div class="form-group" style="width: 100%;padding: 10px;">
                            <label for="label" class="control-label"><?php echo $this->lang['num']; ?> <span style="color: #9A0000;">( * )</span>&nbsp;:&nbsp;</label>
                            <input type="text" id="TransactionMeczy" name="TransactionMeczy" class="form-control onlyNumberAndDot" placeholder="<?php echo $this->lang['num']; ?>"  style="width: 60%" required>
                            <input type="hidden" id="id" name="id" class="form-control" value="<?php echo  $id;?>">

                        </div>
                        <div class="col-md-5 pull-right">
                            <button id="lebtnValider" class="btn btn-success" data-form="my-form" type="submit"><i class="fa fa-check"></i> <?php echo $this->lang['btnValider']; ?></button>

                        </div>

                    </form>
                </fieldset>

                </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {

        $('.onlyNumberAndDot').on('change keyup input blur', function () {
            $(this).val($(this).val().replace(/[^0-9\.]/g,'').replace(/[.](?=.*[.])/g, ""));
        });
    })();


</script>