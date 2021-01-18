<div id="page-wrapper">
    <div class="container-fluid">

        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title"><?php echo $this->lang['retour_lot_carte']; ?></h4></div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo WEBROOT . 'carte/reception'; ?>">  <?php echo $this->lang['gestioncarte']; ?></a>
                    </li>
                    <li class="active"><?php echo $this->lang['retour_lot_carte']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <div class="row">



                            <div class="row">
                                <div class="form-group col-sm-3"></div>
                                <div id="thediv"  class="col-sm-6">

                                    <fieldset style="display: block;" class="scheduler-border">
                                        <legend class="scheduler-border"><?= $this->lang['retour_lot_carte']; ?></legend>

                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group" style="width: 100%;">
                                                        <label for="numero" class="control-label"><?php echo $this->lang['num_debut_carte']; ?></label>
                                                        <input  id="numDebut" name="numero" placeholder="<?php echo $this->lang['num_carte_serie']; ?>" style="width: 100%" required  onblur="valideLot(this.value)"  />
                                                        <span class="font-13 text-muted">Format: 999999999999</span>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group" style="width: 100%;">
                                                        <label for="numero_serie" class="control-label"><?php echo $this->lang['num_fin_carte']; ?></label>
                                                        <input  id="numFin" name="numero_serie" placeholder="<?php echo $this->lang['num_carte_serie']; ?>" style="width: 100%" required  onblur="valideLot(this.value)"  />
                                                        <span class="font-13 text-muted">Format: 999999999999</span>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="form-group" style="width: 100%;padding: 10px;">
                                                    <label for="lot" class="control-label"><?php echo $this->lang['motif'];?></label>
                                                    <select name="agence" id="motif" class="form-control select2" style="width: 100%">
                                                        <option value=""><?php echo $this->lang['select_motif']; ?></option>
                                                        <?php foreach ($motif as $item) { ?>
                                                            <option  value="<?= $item->rowid."&".$item->libellemotif?>"><?= $item->libellemotif ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row"><br/><br/>
                                                <div class="pull-right">
                                                    <button id="add" type="button" class="btn btn-info btn-outline btn-circle btn-sm m-r-5" style="background-color:#ececec;margin-left: 30px;"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>


                                        </div>

                                    </fieldset>

                                    <div class="alert alert-danger alert-dismissable " id="msgErreur2" style="display: none; font-size: 12px;" >
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    </div>



                                </div>
                                <div class="modal-footer">

                                    <span id="isValide"></span>

                                    <form method="post" action="<?= WEBROOT ?>carte/retournerLot" onsubmit="return valideForm(); ">

                                    <!--<h2>Liste des lots de cartes</h2>-->
                                    <table class="table table-bordered table-responsive" id="tableaudist">
                                        <tr>

                                            <td style="text-align: left"><?php echo $this->lang['agence']; ?></td>
                                            <td style="text-align: left"><?php echo $this->lang['num_lot']; ?></td>
                                            <td style="text-align: left; width: 180px;"><?php echo $this->lang['num_debut_carte']; ?></td>
                                            <td style="text-align: left; width: 180px;"><?php echo $this->lang['num_fin_carte']; ?></td>
                                            <td style="text-align: right"><?php echo $this->lang['quantite']; ?></td>
                                            <td style="text-align: right"><?php echo $this->lang['motif']; ?></td>

                                            <td style="text-align: center"><?php echo $this->lang['actions']; ?></td>
                                        </tr>
                                    </table>
                                        <input type="hidden" id="date_retour" name="date_retour" value="<?= date('Y-m-d'); ?>">


                                    <br/>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <a href="<?= WEBROOT ?>carte/reception">
                                                <h3 class="panel-title pull-right">
                                                    <button type="button" class="btn btn-success"
                                                    <i class="fa fa-arrow-left"></i> <?php echo $this->lang['btnAnnuler']; ?>
                                                    </button>
                                                </h3>
                                            </a>

                                        </div>
                                        <div class="col-sm-6">
                                        <button type="submit" id="lebtnValider" style="display: none" value="delete" class="btn btn-success  pull-right"><?= $this->lang['btnRetourner'] ; ?></button>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
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
    $('#add').click(function()
    {



        var num_debut = $("#numDebut").val();
        var num_fin = $("#numFin").val();
        var motif = $("#motif").val();
        var quantite = (num_fin-num_debut +1);


        $('#lebtnValider').attr('disabled','disabled');
        $('#lebtnValider').addClass('disabled');
        if (num_debut != '' && num_fin != '' && motif !='')
        {
           var motifnomtab = motif.split("&");
            var motifnom = motifnomtab[1];
            var motifid = motifnomtab[0];

            $.ajax({
                type: "POST",
                url: "<?= WEBROOT ?>carte/verifNumeroSerie",

                data: "num_debut="+num_debut+"&num_fin="+num_fin+"&stock="+quantite,
                success: function(data) {
                    data = JSON.parse(data);
                    if(data){
                        //$.each(data, function(cle, valeur)
                        //{
                            i++;
                            $('#lebtnValider').removeAttr('disabled');
                            $('#lebtnValider').css('display','block');

                            $('#lebtnValider').removeClass('disabled');
                            $('#tableaudist').append(
                                '<tr class="" id="row' + i + '">' +
                                '<td style="text-align: left" >' + data.label + '</td>' +
                                '<td style="text-align: center" >' + data.fk_lot_origine + '</td>' +
                                '<td>' + num_debut + '<input type="hidden" name="num_debut[]" value="' + num_debut + '"></td>' +
                                '<input type="hidden" name="num_fin[]" value="' + num_fin + '" >' +
                                '<input type="hidden" name="stock[]" value="' + (num_fin-num_debut +1)  + '">' +
                                '<input type="hidden" name="motif[]" value="' + motifid + '">' +
                                '<input type="hidden" name="fk_agence_dest[]" value="' + data.rowid + '">' +
                                '<input type="hidden" name="num_reference[]" value="' + data.num_reference + '">' +
                                '<input type="hidden" name="fk_lot_origine[]" value="' + data.fk_lot_origine + '">' +
                                '<input type="hidden" name="id[]" value="' + data.id + '">' +

                                '<td>' + num_fin + '</td>' +
                                '<td>'+ quantite  + '</td>' +
                                '<td>'+ motifnom + '</td>' +

                                '<td><button id="minus" data-i="' + i + '" class="btn btn-info btn-outline btn-circle btn-sm m-r-5 btn_remove" style="background-color:#ececec;margin-left: 30px;margin-bottom: 30px;"><i class="fa fa-minus"></i></button></td>' +
                                '</tr>');


                       // })
                    }
                    else{
                        swal({
                            title: "<?= $this->lang['distcarte']; ?>",
                            text: "<?= $this->lang['alertStock']; ?>",
                            type: "warning"
                        });
                    }

                }
            });


        }
        else {

            $('#lebtnValider').attr('disabled','disabled');
            $('#lebtnValider').addClass('disabled');
            swal({
                title: "<?= $this->lang['retour_lot_carte']; ?>",
                text: "<?= $this->lang['alertStock']; ?>",
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