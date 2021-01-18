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
                <h4 class="page-title"><?php echo $this->lang['mon_profil']; ?></h4></div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li>
                        <a href="<?= WEBROOT . 'administration/index'; ?>">  <?php echo $this->lang['administration']; ?></a>
                    </li>
                    <li class="active"><?php echo $this->lang['mon_profil']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <div class="row">

                        <div class="col-md-12">

                            <table align="center" class="table table-no-bordered table-striped" style="width:75%;">
                                <tbody>
                                <tr>
                                    <td ><strong><?= $this->lang['labprenom']; ?></strong></td>
                                    <td  align="right"><?= $utilisateur->prenom; ?></td>
                                </tr>
                                <tr>
                                    <td ><strong><?= $this->lang['nom']; ?></strong> </td>
                                    <td  align="right"><?= $utilisateur->nom; ?></td>
                                </tr>
                                <tr>
                                    <td ><strong><?= $this->lang['labemail']; ?></strong></td>
                                    <td  align="right"><?= $utilisateur->email; ?></td>
                                </tr>
                                <tr>
                                    <td ><strong><?= $this->lang['labLogin']; ?></strong></td>
                                    <td  align="right"><?= $utilisateur->login; ?></td>
                                </tr>
                                <tr>
                                    <td  ><strong><?= $this->lang['agence']; ?></strong></td>
                                    <td  align="right"><?= $utilisateur->label; ?></td>
                                </tr>
                                <tr>
                                    <td  ><strong><?= $this->lang['labProfil']; ?></strong> </td>
                                    <td  align="right"><?= $utilisateur->profil; ?></td>
                                </tr>

                                </tbody>
                            </table>

                            <br/>

                            <table align="center" style="width:75%;">
                                <tr>
                                    <td  colspan="2" align="center" valign="middle">
                                        <div class="row">

                                            <div class="col-sm-6 col-xs-6 pull-left">

                                                <a href="javascript:history.back()"><button class="btn btn-default"><?= $this->lang['btnAnnuler'] ; ?></button></a>

                                            </div>


                                            <div class="col-sm-6 col-xs-6 pull-right">

                                                <a href="<?= WEBROOT."utilisateur/renewPassword/".$utilisateur->id; ?>"><button class="btn btn-success"><?= $this->lang['Modifier_motpass'] ; ?></button></a>

                                            </div>


                                        </div>
                                    </td>
                                </tr>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>