<div id="page-wrapper">
    <div class="container-fluid">

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
                                <?php foreach ($retour as $oneLot){?>
                                <tr>
                                    <td><?php echo $oneLot->num_debut; ?></td>
                                    <td><?php echo $oneLot->num_fin; ?></td>
                                    <td><?php echo $oneLot->stock; ?></td>
                                    <td><a style='margin-left: 15%;' href='' data-toggle="modal" data-target="#retourLot" onclick="setRetourLot('<?= base64_encode($oneLot->id); ?>','<?= $oneLot->num_debut ?>','<?= $oneLot->num_fin ?>','<?= $oneLot->stock ?>')"><i class="fa fa-undo"></i></a></td>
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
                   <!-- <div class="row">
                        <div class="col-sm-4 text-center"><h5><?/*= $data['lang']['num_debut_carte']; */?></h5></div>
                        <div class="col-sm-4 text-center"><h5><?/*= $data['lang']['num_fin_carte']; */?></h5></div>
                        <div class="col-sm-4 text-center"><h5><?/*= $data['lang']['stock_restant']; */?></h5></div>
                    </div>-->
                   <fieldset>

                        <div class="row">
                            <div class="col-sm-3 col-sm-offset-1" id="numDebut"></div>
                            <div class="col-sm-3 col-sm-offset-1" id="numFin"></div>
                            <div class="col-sm-4" id="stock"></div>
                        </div>
                    </fieldset>

                    <br/> <br/>
                    <div class="row">
                        <div class="form-bottom">
                            <div class="col-sm-6">
                                <label>Numéro début</label>
                                <input type="text" onkeypress="return IsNumeric(event);" required class="form-control" placeholder="<?php echo $this->lang['num_debut_carte']; ?>" id="num_debut" name="num_debut" onchange="valideLot(this.value)">
                            </div>
                            <div class="col-sm-6">
                                <label>Numéro Fin</label>
                                <input type="text" onkeypress="return IsNumeric(event);" required class="form-control" placeholder="<?php echo $this->lang['num_fin_carte']; ?>" id="num_fin" name="num_fin" onchange="valideLot(this.value)">
                            </div>



                        </div>
                    </div>
                    <div class="row"><br/><br/>
                        <div class="pull-right">
                            <button id="add" type="button" class="btn btn-info btn-outline btn-circle btn-sm m-r-5" style="background-color:#ececec;margin-left: 30px;"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>

                </div>
                <br/>

                <div class="modal-footer">
                    <input type="hidden" id="idstock" name="stock" />
                    <input type="hidden" id="idreference" name="num_reference"/>
                    <input type="hidden" id="idLot" name="idLot"/>
                    <input type="hidden" name="fk_agence_source" value="<?php echo base64_encode($idagence); ?>"/>
                    <input type="hidden" name="fk_lot_origine" value="<?php echo base64_encode($idlotcarte); ?>"/>
                    <span id="isValide"></span>



                    <h2>Liste des lots de cartes</h2>
                    <table class="table table-bordered table-responsive" id="tableaudist">
                        <tr>

                            <td style="text-align: left"><?php echo $this->lang['num_debut_carte']; ?></td>
                            <td style="text-align: left"><?php echo $this->lang['num_fin_carte']; ?></td>
                            <td style="text-align: right">Quantité</td>

                            <td style="text-align: center"><?php echo $this->lang['actions']; ?></td>
                        </tr>
                    </table>

<br/>
                    <div class="row">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="reset" class="btn btn-default pull-left" data-dismiss="modal"><?= $this->lang['btnAnnuler'] ; ?></button>
                            <button type="submit" id="lebtnValider" style="display: none" value="delete" class="btn btn-success  pull-right"><?= $this->lang['btnRetourner'] ; ?></button>
                        </div>
                    </div>
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
                $('#add').css('display','none');
                $("#isValide").addClass('invalide')
            }
            else if(num >= parseInt(debut) && num > parseInt(fin)) {
            alert('Numero de série saisi invalide');
            $('#add').css('display','none');
            $("#isValide").addClass('invalide')
            }

            else {
                $("#isValide").removeClass('invalide');
                $('#add').css('display','block');
            }

    }
</script>



<script>
    var i =0;
    $('#add').click(function(){


        var num_debut = $("#num_debut").val();
        var num_fin = $("#num_fin").val();
       alert(num_debut+' '+num_fin);

        $('#lebtnValider').attr('disabled','disabled');
         $('#lebtnValider').addClass('disabled');
        if (num_debut != '' && num_fin != '') {

            i++;
            $('#lebtnValider').removeAttr('disabled');
            $('#lebtnValider').css('display','block');

            $('#lebtnValider').removeClass('disabled');
            $('#tableaudist').append(
                '<tr class="" id="row' + i + '">' +
                '<td>' + num_debut + '<input type="hidden" name="num_debut[]" value="' + num_debut + '"></td>' +
                '<input type="hidden" name="num_fin[]" value="' + num_fin + '" >' +
                '<input type="hidden" name="quantite[]" value="' + (num_fin-num_debut +1)  + '">' +
                '<input type="hidden" name="num_fin[]" value="' + num_fin + '">' +
                '<td>' + num_fin + '</td>' +
                '<td>'+(num_fin-num_debut +1)  + '</td>' +
                '<td><button id="minus" data-i="' + i + '" class="btn btn-info btn-outline btn-circle btn-sm m-r-5 btn_remove" style="background-color:#ececec;margin-left: 30px;margin-bottom: 30px;"><i class="fa fa-minus"></i></button></td>' +
                '</tr>');
            document.getElementById('nbrow').value = i + 1;
            //$('#form1')[0].reset();
            $("#num_fin").val("");
            $("#nb_carte_dist").val("");
            $("#num_debut").val("");
            $('#fk_lotreception').prop('selectedIndex',0);
            $('#fk_distributeur_destinataire').prop('selectedIndex',0);


        }
        else {
            $('#lebtnValider').attr('disabled','disabled');
            $('#lebtnValider').addClass('disabled');
            swal({
                title: "<?= $this->lang['distcarte']; ?>",
                text: "<?= $this->lang['msg_err_dist']; ?>",
                type: "warning"
            });
        }

    });

    $(document).on('click', '.btn_remove', function(){
        var button_id = $(this).data('i');
        $('#row'+button_id+'').remove();
        document.getElementById('nbrow').value = parseInt(document.getElementById('nbrow').value)-1 ;
        if( parseInt(nbrow)==1){
            $('#lebtnValider').attr('disabled','disabled');
            $('#lebtnValider').addClass('disabled');
        }


    });

</script>
