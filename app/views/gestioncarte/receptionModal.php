<form id="validation" class="form-inline form-validator" data-type="update" role="form" action="<?php echo WEBROOT; ?>carte/<?= ((isset($reception->id)) ? "modifReception" : "ajoutReception") ?>" method="post">

<div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title"><?= ((isset($reception->id)) ? $this->lang['btnModifierReception'] : $this->lang['btnAjouterReception']) ?></h4>
    </div>

    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>

                <div class="col-sm-6">

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="num_debut" class="control-label"><?php echo $this->lang['num_debut_carte']; ?></label>
                        <input type="text" id="num_debut" name="num_debut" class="form-control" placeholder="<?php echo $this->lang['num_debut_carte']; ?>"
                               value="<?php echo $reception->num_debut; ?>" style="width: 100%" onkeypress="return IsNumeric(event);" required>
                        <span class="help-block with-errors"> </span>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="num_fin" class="control-label"><?php echo $this->lang['num_fin_carte']; ?></label>
                        <input type="text" id="num_fin" name="num_fin" class="form-control" placeholder="<?php echo $this->lang['num_fin_carte']; ?>"
                               value="<?php echo $reception->num_fin; ?>" onkeypress="return IsNumeric(event);" style="width: 100%" required>
                        <span class="help-block with-errors"> </span>
                    </div>

                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="date_reception" class="control-label"><?php echo $this->lang['date_recept_carte']; ?></label>
                        <input type="date" id="date_reception" name="date_reception" class="form-control" placeholder="<?php echo $this->lang['date_recept_carte']; ?>"
                               value="<?php echo $reception->date_reception; ?>" style="width: 100%" required>
                        <span class="help-block with-errors"> </span>
                    </div>


                    <div class="form-group" style="width: 100%;padding: 10px;">
                        <label for="date_reception" class="control-label"><?php echo $this->lang['date_expire_carte']; ?></label>
                        <input type="date" id="dateExp" name="dateExp" class="form-control" placeholder="<?php echo $this->lang['date_recept_carte']; ?>"
                               value="<?php echo $reception->dateExp; ?>" style="width: 100%" required>
                        <span class="help-block with-errors"> </span>
                    </div>




            <!--        <div class="form-group">
                        <?php /*if(isset($reception->id)){
                            $tabexp=explode("-",$reception->dateExp);
                            $mois=$tabexp[1];
                            $annee=$tabexp[0];
                        }
                        */?>
                        <label for="inputPassword4" class="control-label col-sm-3"><?php /*echo $this->lang['dateExp'];*/?></label>
                        <div class="col-sm-4">
                            <input type="text" name="moisexp" data-mask="99" data-minlength="2" class="form-control" placeholder="<?php /*echo $this->lang['moisexp'];*/?>"
                            value="<?php /*if(isset($reception->id)){
                                echo $mois;
                            }else echo ""; */?>" style="width: 100%" required>
                            <span class="font-13 text-muted">Mois</span>
                        </div>
                        <div class="col-sm-4">
                            <input type="text" name="anexp" data-mask="9999" class="form-control" data-minlength="4" placeholder="<?php /*echo $this->lang['anexp'];*/?>"
                            value="<?php /*if(isset($reception->id)){
                                echo $annee;
                            }else echo ""; */?>" style="width: 100%" required>
                            <span class="font-13 text-muted">Année</span>
                        </div>
                    </div>-->


                    <?php if(isset($reception->id)) {  ?> <input type="hidden" name="id" value="<?= $reception->id; ?>"><?php } ?>
                </div>

                <div class="col-sm-3"></div>

            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button class="btn btn-success confirm" data-form="my-form" type="submit"><i class="fa fa-check"></i> <?php echo $this->lang['btnValider']; ?>
        </button>
        <button class="btn btn-default" type="button" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo $this->lang['btnFermer']; ?> </button>
    </div>

</form>


<script>
    $(function() {
        $('.date-picker').datepicker({
            dateFormat: "mm/yy",
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            onClose: function(dateText, inst) {


                function isDonePressed(){
                    return ($('#ui-datepicker-div').html().indexOf('ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all ui-state-hover') > -1);
                }

                if (isDonePressed()){
                    var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                    var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                    $(this).datepicker('setDate', new Date(year, month, 1)).trigger('change');

                    $('.date-picker').focusout()//Added to remove focus from datepicker input box on selecting date
                }
            },
            beforeShow : function(input, inst) {

                inst.dpDiv.addClass('month_year_datepicker')

                if ((datestr = $(this).val()).length > 0) {
                    year = datestr.substring(datestr.length-4, datestr.length);
                    month = datestr.substring(0, 2);
                    $(this).datepicker('option', 'defaultDate', new Date(year, month-1, 1));
                    $(this).datepicker('setDate', new Date(year, month-1, 1));
                    $(".ui-datepicker-calendar").hide();
                }
            }
            })

    });
</script>



<script type="text/javascript">
    var specialKeys = new Array();
    specialKeys.push(8); //Backspace
    function IsNumeric(e) {
        var keyCode = e.which ? e.which : e.keyCode
        var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
        /*document.getElementById("error").style.display = ret ? "none" : "inline";*/
        return ret;
    }
</script>
