<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="row white-box" style="margin-top:0px; margin-bottom: 4px">
                <div class="col-lg-2 col-sm-6 bg-theme text-white"
                     style="height: 40px; vertical-align: middle; padding-top:10px;background-color: #0a7242 !important;">
                    <center><b><?php echo $this->lang['alaune'];?></b></center>
                </div>
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
                <h4 class="page-title"><?php echo $this->lang['reception_list']; ?></h4></div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo WEBROOT . 'carte/reception'; ?>">  <?php echo $this->lang['gestioncarte']; ?></a>
                    </li>
                    <li class="active"><?php echo $this->lang['reception_list']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">

                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered table-hover table-responsive">
                                <thead>
                                <tr>
                                    <th><?php echo $this->lang['num_debut_carte']; ?></th>
                                    <th><?php echo $this->lang['num_fin_carte']; ?></th>
                                    <th><?php echo $this->lang['stock_restant_carte']; ?></th>
                                    <th><?php echo $this->lang['labAction']; ?></th>
                                </tr>
                                </thead>
                                <?php foreach ($lotRestant as $oneLot){?>
                                <tr>
                                    <td><?php echo $oneLot['debut']; ?></td>
                                    <td><?php echo $oneLot['fin']; ?></td>
                                    <td><?php echo $oneLot['stock']; ?></td>
                                    <td><a style='margin-left: 15%;' href='' data-toggle="modal" data-target="#retourLot" onclick="setRetourLot('<?= base64_encode($oneLot['idlot']); ?>','<?= $oneLot['debut'] ?>','<?= $oneLot['fin'] ?>','<?= $oneLot['stock'] ?>')"><i class="fa fa-undo"></i></a></td>
                                </tr>
                                <?php }?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" aria-labelledby="gridSystemModalLabel" id="retourLot" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel"><?= $this->lang['retour_lot_carte'] ; ?></h4>
            </div>
            <form method="post" action="<?= WEBROOT ?>carte/retournerLot" onsubmit="return valideForm(); ">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-4 text-center"><h5><?= $data['lang']['num_debut_carte']; ?></h5></div>
                        <div class="col-sm-4 text-center"><h5><?= $data['lang']['num_fin_carte']; ?></h5></div>
                        <div class="col-sm-4 text-center"><h5><?= $data['lang']['stock_restant']; ?></h5></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4" id="numDebut"></div>
                        <div class="col-sm-4" id="numFin"></div>
                        <div class="col-sm-4" id="stock"></div>
                    </div>
                    <div class="row">
                        <div class="form-bottom">
                            <div class="col-sm-6">
<!--                                <input type="text" data-inputmask='"mask": "0009999999"' data-mask required class="form-control" placeholder="--><?//= $data['lang']['num_debut_carte']; ?><!--" id="num_debut" name="num_debut" onchange="valideLot(this.value)">-->
                                <input type="text" onkeypress="return IsNumeric(event);" required class="form-control" placeholder="<?php echo $this->lang['num_debut_carte']; ?>" id="num_debut" name="num_debut" onchange="valideLot(this.value)">
                            </div>
                            <div class="col-sm-6">
<!--                                <input type="text" data-inputmask='"mask": "0009999999"' data-mask required class="form-control" placeholder="--><?//= $data['lang']['num_fin_carte']; ?><!--" id="num_fin" name="num_fin" onchange="valideLot(this.value)">-->
                                <input type="text" onkeypress="return IsNumeric(event);" required class="form-control" placeholder="<?php echo $this->lang['num_fin_carte']; ?>" id="num_fin" name="num_fin" onchange="valideLot(this.value)">
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group" style="width: 100%;padding: 10px;">
                                    <label for="date_reception" class="control-label"><?php echo $this->lang['date_recept_carte']; ?></label>
                                    <input type="date" id="date_reception" name="date_retour" class="form-control" placeholder="<?php echo $this->lang['date_retournee']; ?>"
                                           value="" style="width: 100%" required>
                                    <span class="help-block with-errors"> </span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group" style="width: 100%;padding: 10px;">
                                    <label for="agence" class="control-label"><?php echo $this->lang['agence'];?></label>
                                    <select class="form-control select2" required name="fk_agence_dest" style="width: 100%;" id="agence" onchange="request(this.value);">
                                        <option value=""> <?php echo $this->lang['selectagence'];?> </option>
                                        <?php foreach ($agences as $item) {?>
                                            <option value="<?php echo $item->rowid;?>"> <?php echo $item->label;?> </option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="idstock" name="stock" />
                    <input type="hidden" id="idreference" name="num_reference"/>
                    <input type="hidden" id="idLot" name="idLot"/>
                    <input type="hidden" name="fk_agence_source" value="<?php echo base64_encode($idagence); ?>"/>
                    <input type="hidden" name="fk_lot_origine" value="<?php echo base64_encode($idlotcarte); ?>"/>
                    <span id="isValide"></span>
                    <button type="reset" class="btn btn-default" data-dismiss="modal"><?= $this->lang['btnAnnuler'] ; ?></button>
                    <button type="submit" value="delete" class="btn btn-success"><?= $this->lang['btnRetourner'] ; ?></button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<script>
    function setRetourLot(idLot, debut, fin, stock) {
        $('#idLot').val(idLot);
        $('#numDebut').html('<b>'+debut+'</b>');
        $('#numFin').html('<b>'+fin+'</b>');
        $('#stock').html('<b>'+stock+'</b>');
    }

    function valideForm() {
        return ($("#isValide").hasClass('invalide') || (parseInt($('#num_debut').val()) > parseInt($('#num_fin').val()))) ? false : true;
    }

  /*  function valideLot(num) {
        num = num.replace(/_/g, '');
        if(num.length < 10) {
            alert('Vous devez saisir un numero de série de 10 chiffres');
            $("#isValide").addClass('invalide');
        }else {
            $("#isValide").removeClass('invalide');
            var debut = $('#numDebut')[0].innerText;
            var fin = $('#numFin')[0].innerText;
            if(num < parseInt(debut) || num > parseInt(fin)) {
                alert('Numero de série saisi invalide');
                $("#isValide").addClass('invalide')
            } else
                $("#isValide").removeClass('invalide');
        }
    }*/

    function valideLot(num) {
        num = num.replace(/_/g, '');
            $("#isValide").removeClass('invalide');
            var debut = $('#numDebut')[0].innerText;
            var fin = $('#numFin')[0].innerText;
            if(num < parseInt(debut) || num > parseInt(fin)) {
                alert('Numero de série saisi invalide');
                $("#isValide").addClass('invalide')
            } else
                $("#isValide").removeClass('invalide');
    }
</script>
