<form id="validation" class="form-inline form-validator" data-type="update" role="form" action="">

    <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
        <h4 class="modal-title" style="text-align: center"><?= $this->lang['tpe_info'] ?></h4>

    </div>

    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>

                <div class="col-sm-6">

                    <table class="table table-bordered">

                        <tbody>
                        <tr>
                            <td ><?php echo $this->lang['num_debut_carte']; ?>:</td>
                            <td ><?php echo $num_debut; ?></td>
                        </tr>
                        <tr >
                            <td ><?php echo $this->lang['num_fin_carte']; ?>: </td>
                            <td><?php echo $num_fin; ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $this->lang['qte_importer']; ?>: </td>
                            <td> <?php echo $stock; ?></td>
                        </tr>


                        </tbody>
                    </table>

                </div>

                <div class="col-sm-3"></div>

            </div>
        </div>
    </div>

    <div class="modal-footer">
     
        <button class="btn btn-default" type="button" data-dismiss="modal"><i
                    class="fa fa-times"></i> <?php echo $this->lang['btnFermer']; ?> </button>
    </div>

</form>


