
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
        font-size: 12px;
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
    .ok1 {

        border-bottom: 1px solid #000000;
        border-top: 1px solid #000000;
        border-left: 1px solid #000000;
        border-right: 1px solid #000000;
    }
</style>
<page backtop="10mm" backbottom="20mm" backleft="10mm" backright="10mm">
    <table>
        <tr>
            <td align="right" valign="right">
                <img class="img-circle-" style="width: 240px"  src="<?php echo ROOT ?>assets/plugins/images/logo_mec.png"  >
            </td>

        </tr>
        <tr>
            <td style="padding:8px;">&nbsp;&nbsp; </td>

        </tr>
    </table>
    <table  width="80%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr >
            <td style="text-align: left; padding: 10px 10px 15px 10px; border: 1px solid #0a7242; margin-bottom: 20px;background: #F0FFF0;"><strong>Liste des Transactions du <?php echo \app\core\Utils::getDateFR($this->data['debut']).' au '. \app\core\Utils::getDateFR($this->data['fin']); ?> </strong></td>
        </tr>
         <tr >
            <td style="padding:8px;">&nbsp;&nbsp;</td>
        </tr>

    </table>

    <table  border="0" cellspacing="0" cellpadding="0" align="center" >
        <thead>

        <tr style="background-color: #f0f0f0;" width= "100%">
            <th style="text-align: left; padding: 5px 9px 5px 9px" class="tiret" >
                <strong><?php echo $this->lang['num_transact']; ?></strong></th>
            <th style="text-align: left; padding: 5px 9px 5px 9px" class="tiret">
                <strong><?php echo $this->lang['date_transact']; ?></strong></th>
            <th style="text-align: left; padding: 5px 9px 5px 9px" class="tiret">
                <strong><?php echo $this->lang['montant_transact']; ?></strong></th>
            <th style="text-align: left; padding: 5px 9px 5px 9px" class="tiret">
                <strong><?php echo $this->lang['code_client']; ?></strong></th>
            <th style="text-align: left; padding: 5px 9px 5px 9px" class="tiret">
                <strong><?php echo $this->lang['numcompte_client']; ?></strong></th>
<!--            <th style="text-align: left; padding: 5px 9px 5px 9px" class="tiret">-->
<!--                <strong>--><?php //echo $this->lang['collecteur']; ?><!--</strong>-->
<!--            </th>-->
            <th style="text-align: left; padding: 5px 10px 5px 10px" class="tiret">
                <strong><?php echo $this->lang['thEtat']; ?></strong></th>

        </tr>

        </thead>
        <tbody>

        <?php foreach ($this->data['transact'] as $row2) {
            //echo'<pre>', var_dump($row1->code);
            //echo'<pre>', var_dump($row1->idAllcollecteur);
            ?>

            <tr  width= "100%">
                <td colspan="6" style="background-color: #F5F5F5; text-align: left; padding:4px; font-weight: bold; font-size: 11px;" class="ok1"><?php echo $this->lang['collecteur'].' : '.$row2->code.' ### '.$this->lang['lbl_transaction'].' ==>> '.\app\core\Utils::getFormatMoney($row2->NbreTransact);?></td>
            </tr>

        <?php foreach ($row2->idAllcollecteur as $row1) {?>
            <tr>
                <td style="text-align: left; padding:4px;" class="ok"><?php if($row1->statut==1){ echo $row1->num_transac; }else{ echo '<label style="color: #DB1702;">'.$row1->num_transac.'</label>';}?></td>
                <td style="text-align: left; padding:4px;" class="ok"><?php if($row1->statut==1){  echo \app\core\Utils::getDateFR($row1->date_transac);}else{echo '<label style="color: #DB1702;">'.\app\core\Utils::getDateFR($row1->date_transac).'</label>';}?></td>
                <td style="text-align: right; padding:4px;" class="ok"><?php if($row1->statut==1){  echo \app\core\Utils::getFormatMoney($row1->montant_ttc);}else{echo '<label style="color: #DB1702;">'.\app\core\Utils::getFormatMoney($row1->montant_ttc).'</label>';}?></td>
                <td style="text-align: right; padding:4px;" class="ok"><?php if($row1->statut==1){  echo $row1->code_client; }else{ echo '<label style="color: #DB1702;">'.$row1->code_client.'</label>';}?></td>
                <td style="text-align: right; padding:4px;" class="ok"><?php if($row1->statut==1){  echo $row1->numcompte_client; }else{ echo '<label style="color: #DB1702;">'.$row1->numcompte_client.'</label>';}?></td>
<!--                <td style="text-align: left; padding:4px;" class="ok">--><?php //echo $row1->codeCollecteur;?><!--</td>-->
                <td style="text-align: left; padding:4px;" class="ok"><?php if($row1->statut==1){ echo $this->lang['statTransSuccess'];}else{ echo '<label style="color: #DB1702;">'.$this->lang['statTransFail'].'</label>';} ?></td>
            </tr>

            <? } ?>

            <tr style="background-color: #F5F5F5;">
                <td style="text-align: center; padding: 3px 6px 3px 6px; font-size: 10px;" class="tiret" class="ok" colspan="2" > <strong><?php echo $this->lang['montant_transactBis']; ?></strong></td>
                <td style="text-align: right; padding:6px; font-weight: bold;" class="ok"><?php echo \app\core\Utils::getFormatMoney($row2->MntTransact);?></td>
                <td style="text-align: right; padding:3px;" class="ok" colspan="2" >&nbsp;</td>
            </tr>



        <? } ?>
        <tr style="background-color: #F5FFFA; font-weight: bold;">
            <td style="text-align: center; padding: 3px 5px 3px 5px;" class="tiret" class="ok" colspan="2" > <strong><?php echo $this->lang['thmnttBis']; ?></strong></td>
            <td style="text-align: right; padding:6px; " class="ok"><?php echo \app\core\Utils::getFormatMoney($transactT[0]->mnt);?></td>
            <td style="text-align: right; padding:3px;" class="ok" colspan="2" >&nbsp;</td>

        </tr>
        <tr style="background-color: #FFFFFF;">
            <td style="text-align: left; padding:6px; text-decoration: underline; font-size: 10px; font-style: italic;" colspan="6" > <?php echo $this->lang['txtmsgEchecTrans5Bis']. ' ('.\app\core\Utils::ConvNumberLetter($transactT[0]->mnt,'','').' '.$this->lang['txtDevise'].')'; ?><br></td>
        </tr>

        </tbody>

    </table>
  <!--  <page_footer>

        <table  style="text-align: left; padding: 10px;margin-left: 20px; ">
            <tr >
                <td align="center" valign="center">
                    <?php /*echo $this->lang['piedp']; */?>&nbsp;&nbsp;<?php /*echo $this->lang['piedp1']; */?>
                </td>
                <td align="right" valign="right" style="padding-left: 380px;">  &nbsp; &nbsp; &nbsp; &nbsp;</td>
                <td align="right" valign="right">
                    [[page_cu]]/[[page_nb]]
                </td>

            </tr>

        </table>

    </page_footer>
-->
</page>