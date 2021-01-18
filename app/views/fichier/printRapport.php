
<style type="text/css">
    body, td, th {
        font-size: 13px;
        font-family: Arial, Helvetica, sans-serif;
    }

    .text_ref {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 10px;
        font-weight: 900;

    }

    a#text_ref {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 10px;
        font-weight: 900;
        text-decoration: none;
    }

    .titre {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 14px;
        font-weight: bold;
        text-align: center;
    }

    tr, td#fd {
        border-left: border: 0.2em thin #4E4E4E;
    }

    td#fi {
        border-left: border: 0.2em thin #4E4E4E;
        /*border-bottom: border:0.2em thin  #D7D7D7;*/
    }

    tr#fa {
        border-top: border: 0.2em thin #4E4E4E;
        border-bottom: border: 0.2em thin #D7D7D7;
    }

    .tiret {
        border-bottom: 1px solid #3c4451;
        border-top: 1px solid #3c4451;
        border-left: 0.5px solid #3c4451;
        border-right: 0.5px solid #3c4451;

    }

    .trait {
        border-left: border: 0.01em thin black;
        border-bottom: border: 0.01em thin black;

    }

    .ok {

        border-bottom: 1px solid #CCCCCC;
        border-top: 1px solid #CCCCCC;
        border-left: 1px solid #CCCCCC;
        border-right: 1px solid #CCCCCC;
    }
</style>
<page backtop="10mm" backbottom="20mm" backleft="10mm" backright="10mm">
    <table>
        <tr>
            <td align="right" valign="right">

                <img src="<?= ROOT ?>assets/plugins/images/pflogo.png"  height="100" width="150" style="margin: 15px; " />
            </td>

        </tr>
        <tr>
            <td style="padding:8px;">&nbsp;&nbsp; </td>

        </tr>
    </table>
    <table  width="80%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr >
            <td style="text-align: left; padding: 10px 10px 15px 10px; border: 0px solid ; margin-bottom: 20px;;"><strong><?= $this->lang['rapport_mensuel']; ?> </strong></td>
        </tr>
        <tr >
            <td style="padding:8px;">&nbsp;&nbsp;</td>
        </tr>

    </table>

    <table  border="0" bgcolor="#f6f6f6" style="border-radius: 20px; width: 500px;" cellspacing="0" cellpadding="0" align="center" >
        <!--        <thead>-->

        <!--        <tr style="background-color: #f0f0f0;" width= "100%">
            <th style="text-align: left; padding: 5px 10px 5px 10px" class="tiret" >
                <strong><?php /*echo $this->lang['num_transact']; */?></strong></th>
            <th style="text-align: left; padding: 5px 10px 5px 10px" class="tiret">
                <strong><?php /*echo $this->lang['date_transact']; */?></strong></th>
            <th style="text-align: left; padding: 5px 10px 5px 10px" class="tiret">
                <strong><?php /*echo $this->lang['montant_transact']; */?></strong></th>
            <th style="text-align: left; padding: 5px 10px 5px 10px" class="tiret">
                <strong><?php /*echo $this->lang['collecteur']; */?></strong></th>
            <th style="text-align: left; padding: 5px 10px 5px 10px" class="tiret">
                <strong><?php /*echo $this->lang['thEtat']; */?></strong></th>
        </tr>
-->
        <!-- <tr style="background-color: #f0f0f0;" width= "100%">
            <th style="text-align: left; padding: 5px 10px 5px 10px" class="tiret" >
                <strong><?php /*echo $this->lang['date']; */?></strong></th>
            <th style="text-align: left; padding: 5px 10px 5px 10px" class="tiret">
                <strong><?php /*echo $this->lang['nom_fichier']; */?></strong></th>
            <th style="text-align: left; padding: 5px 10px 5px 10px" class="tiret">
                <strong><?php /*echo $this->lang['periode']; */?></strong></th>
            <th style="text-align: left; padding: 5px 10px 5px 10px" class="tiret">
                <strong><?php /*echo $this->lang['agence_chargement']; */?></strong></th>
        </tr>

        </thead>
        <tbody>

        <?/* foreach ($this->data['transact'] as $row1) { */?>
            <tr>
                <td style="text-align: left; padding:8px;" class="ok"><?/*= $row1->num_transac;*/?></td>
                <td style="text-align: left; padding:8px;" class="ok"><?/*= \app\core\Utils::getDateFR($row1->date_transac);*/?></td>
                <td style="text-align: right; padding:8px;" class="ok"><?/*= \app\core\Utils::getFormatMoney($row1->montant);*/?></td>
                <td style="text-align: left; padding:8px;" class="ok"><?/*= $row1->codeCollecteur;*/?></td>
                <td style="text-align: left; padding:8px;" class="ok"><?/* if($row1->statut==1) echo"Réussie"; else echo"Echoué";*/?></td>
            </tr>

        <?/* } */?>
        </tbody>-->
        <tr>
            <td style="width: 500px;" >
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td colspan="4" align="left" valign="middle" nowrap="nowrap" class="txt_form"><!-- <hr align="center" style="border:#999 solid 1px" />-->
                        </td>
                    </tr>

                    <tr >
                        <td  align="left" valign="middle" nowrap="nowrap"  class="txt_form borderLEFT "><strong><?php echo $this->lang['date']; ?>: </strong></td>
                        <td colspan="3"  align="left" valign="middle" class="txt_resultat  borderLEFT borderRIGHT" ><?php echo \app\core\Utils::getDateFR(date("Y-m-d")) ; ?></td>
                    </tr>
                    <tr >
                        <td  align="left" valign="middle" nowrap="nowrap"  class="txt_form borderLEFT "><strong><?php echo $this->lang['nom_fichier']; ?>:</strong></td>
                        <td colspan="3"  align="left" valign="middle" class="txt_resultat  borderLEFT borderRIGHT" ><span class="textNormal borderRIGHT borderLEFT borderTOP borderBOTTOM" style="width: 115px;"><?php echo $fichier->libelle;?></span> </td>
                    </tr>
                    <tr>
                        <td  align="left" valign="middle" nowrap="nowrap " class="txt_form borderLEFT"><strong><?php echo $this->lang['periode']; ?> :</strong></td>
                        <td colspan="3"  align="left" valign="middle" class="txt_lister borderLEFT borderRIGHT"><?php echo $fichier->periode; ?></td>
                    </tr>

                    <tr>
                        <td colspan="4" align="left" valign="middle" nowrap="nowrap" class="txt_form borderBOTTOM "><span class="txt_form1"></span>
                        </td>
                    </tr>
                    <tr>
                        <td  align="left" valign="middle" nowrap="nowrap" class="txt_form  borderLEFT">
                            <span class="txt_form1"><strong><?php echo $this->lang['agence_chargement'].':'; ?></strong></span></td>

                        <td  align="left" valign="middle" class="txt_lister borderLEFT borderRIGHT"><?php echo $agence->responsable.'-'.$agence->code; ?></td>
                    </tr>

                    <tr>
                        <td colspan="3" align="left" valign="middle" class="txt_lister borderLEFT borderRIGHT"><?php //echo $this->_USER->prenom.' '.$this->_USER->nom;?></td>
                    </tr>
                </table>
            </td>
        </tr>

    </table>


    <br/>
    <br/>


    <table border="0"  cellpadding="0" cellspacing="0" align="center" >
        <tr>
            <td >
                <table  border="0.1" cellpadding="0" cellspacing="0" >
                    <tr>
                        <td style="width: 520px;" colspan="2" align="center"><strong><?= $this->lang['rapport_mensuel']; ?> </strong></td>
                    </tr>
                    <tr>
                        <td><br/> </td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td ><strong><?= $this->lang['agent_initiateur']; ?> </strong></td>
                        <td ><?= $agence->responsable; ?></td>
                    </tr>
                    <tr>
                        <td ><strong><?= $this->lang['date_heure']; ?> </strong></td>
                        <td ><?=\app\core\Utils::getDateFR($fichier->date_creation); ?></td>
                    </tr>
                    <tr>
                        <td ><strong><?= $this->lang['agent_autorisateur']; ?> </strong></td>
                        <td ><?= $agence->responsable; ?></td>
                    </tr>
                    <tr>
                        <td ><strong><?= $this->lang['date_heure']; ?> </strong></td>
                        <td ><?= \app\core\Utils::getDateFR($fichier->date_creation); ?></td>
                    </tr>
                    <tr>
                        <td><br/> </td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td ><strong><?= $this->lang['date_chargement']; ?> </strong></td>
                        <td ><?= \app\core\Utils::getDateFR($fichier->date_creation) ; ?></td>
                    </tr>
                    <tr>
                        <td ><strong><?= $this->lang['nombre_ligne']; ?> </strong></td>
                        <td><?= $fichier->nb_ligne; ?></td>
                    </tr>
                    <tr>
                        <td ><strong><?= $this->lang['nombre_ligne_charge']; ?> </strong></td>
                        <td><?= $fichier->nb_succes; ?></td>
                    </tr>
                    <tr>
                        <td ><strong><?= $this->lang['nombre_ligne_probleme']; ?> </strong></td>
                        <td><?= $fichier->nb_ligne - $fichier->nb_succes; ?></td>
                    </tr>
                    <tr>
                        <td ><strong><?= $this->lang['montant_apres_chargement']; ?> </strong></td>
                        <td><?= \app\core\Utils::getFormatMoney($fichier->montant)." ".$this->lang['currency'] ; ?></td>
                    </tr>
                    <tr>
                        <td ><strong><?= $this->lang['statut_rapport']; ?> </strong></td>
                        <td align="center">
                            <?php

                            if ($fichier->etat == 2 ){
                                $text =strtoupper($this->lang['rejet']);
                                $classe = 'text-danger' ;

                            }elseif($fichier->etat == 1 ){
                                $text = strtoupper($this->lang['valide']);
                                $classe = 'text-success' ;
                            }else{
                                $text = strtoupper($this->lang['en_attente']);
                                $classe = 'text-info' ;
                            }
                            ?>
                            <span class="<?= $classe ?>"><?=  $text ?></span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>




</page>