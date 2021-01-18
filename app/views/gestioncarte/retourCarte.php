<div id="page-wrapper">
    <div class="container-fluid">

   

        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title"><?php echo $this->lang['carte_retournee']; ?></h4></div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo WEBROOT . 'carte/reception'; ?>">  <?php echo $this->lang['gestioncarte']; ?></a>
                    </li>
                    <li class="active"><?php echo $this->lang['carte_retournee']; ?></li>
                </ol>

            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <form method="post" action="<?php echo WEBROOT.'carte/validerRetour'; ?>">
                        <fieldset style="display: block;" class="scheduler-border">
                            <div class="container-fluid">
                                <div class="form-group" style="width: 100%;padding: 10px;">
                                    <label for="agence" class="control-label"><?php echo $this->lang['agence'];?></label>
                                    <select class="form-control select2" required name="rowid" style="width: 100%;" id="agence" onchange="request(this.value);">
                                        <option value=""> <?php echo $this->lang['selectagence'];?> </option>
                                        <?php foreach ($agences as $item) {?>
                                            <option value="<?php echo $item->rowid;?>"> <?php echo $item->label;?> </option>
                                        <?php }?>
                                    </select>
                                </div>
                                <div class="form-group" style="width: 100%;padding: 10px;">
                                    <label for="lot" class="control-label"><?php echo $this->lang['lotcarte'];?></label>
                                    <select class="form-control select2" required name="lotCarte" style="width: 100%;" id="lot">
                                        <option value=""> <?php echo $this->lang['selectlot'];?> </option>
                                    </select>
                                </div>


                                <div class="form-group" style="width: 100%;padding: 10px;">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<script>

    function request(agence) {
        $.post (
            "<?php echo WEBROOT; ?>carte/getLotCarteByAgence",
            {
                idagence:agence
            },
            function(data){
                $('#lot').html(data);
            }
        );
    }
</script>