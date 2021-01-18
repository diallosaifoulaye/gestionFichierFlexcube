<form id="validation" class="form-inline form-validator" data-type="update" role="form"
      action="<?php echo WEBROOT; ?>administration/<?= ((isset($hour->rowid)) ? "modifHour" : "ajoutHour") ?>"
      method="post">

    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?php echo $this->lang['hours2']; ?></h4>
    </div>

    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="label" class="control-label"><?php echo $this->lang['hours3']; ?></label>
                        <div class="input-group clockpicker " data-placement="left" data-align="top" data-autoclose="true">
                            <input required type="text" name="min" class="form-control" value="<?= ((isset($hour->rowid)) ? $hour->min : date('H:i')) ;?>">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                        </div>
                        <span class="help-block with-errors"> </span>
                    </div>
                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="label" class="control-label"><?php echo $this->lang['hours4'].'  '; ?></label>
                        <div class="input-group clockpicker " data-placement="left" data-align="top" data-autoclose="true">
                            <input required type="text" name="max" class="form-control" value="<?= ((isset($hour->rowid)) ? $hour->max : date('H:i')) ;?>">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                        </div>
                        <span class="help-block with-errors"> </span>
                    </div>
                    <?php if (isset($hour->rowid)) { ?> <input type="hidden" name="id"
                                                               value="<?= $hour->rowid; ?>"><?php } ?>
                </div>
                <div class="col-sm-3"></div>

            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button class="btn btn-success confirm" data-form="my-form" type="submit"><i
                    class="fa fa-check"></i> <?php echo $this->lang['btnValider']; ?>
        </button>
        <button class="btn btn-default" type="button" data-dismiss="modal"><i
                    class="fa fa-times"></i> <?php echo $this->lang['btnFermer']; ?> </button>
    </div>

</form>

<script type="text/javascript">
    $('.clockpicker').clockpicker({
        donetext: 'Done'
        , }).find('input').change(function () {
        console.log(this.value);
    });
</script>
<style>
    .clockpicker-popover{
        z-index: 9999 !important;
    }
</style>