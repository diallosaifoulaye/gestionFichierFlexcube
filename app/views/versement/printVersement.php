
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
                <img class="img-circle-" style="width: 240px"  src="<?= ROOT ?>assets/plugins/images/logo_mec.png"  >
            </td>

        </tr>
        <tr>
            <td style="padding:8px;">&nbsp;&nbsp; </td>

        </tr>
    </table>
    <table  width="80%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr >
            <td style="text-align: left; padding: 10px 10px 15px 10px; border: 1px solid #0a7242; margin-bottom: 20px;background: #F0FFF0;"><strong><?php echo $this->lang['versement_list'] ?>&nbsp;<?php echo  $this->lang['du'] ?> <?php echo \app\core\Utils::getDateFR($debut).' '.$this->lang['au'].' '. \app\core\Utils::getDateFR($fin);?> </strong></td>
        </tr>
         <tr >
            <td style="padding:8px;">&nbsp;&nbsp;</td>
        </tr>

    </table>

    <table  border="0" cellspacing="0" cellpadding="0" align="center" >
        <thead>

        <tr style="background-color: #f0f0f0;" width= "100%">
            <th style="text-align: left; padding: 5px 10px 5px 10px" class="tiret" >
                <strong><?php echo $this->lang['date']; ?></strong></th>
            <th style="text-align: left; padding: 5px 10px 5px 10px" class="tiret">
                <strong><?php echo $this->lang['collecteur']; ?></strong></th>
            <th style="text-align: center; padding: 5px 10px 5px 10px" class="tiret">
                <strong><?php echo $this->lang['nombre']; ?></strong></th>
            <th style="text-align: right; padding: 5px 10px 5px 10px" class="tiret">
                <strong><?php echo $this->lang['montant']; ?> (XOF)</strong></th>



        </tr>

        </thead>
        <tbody>

        <? $total=0; $nb_versement=0; foreach ($this->data['versements'] as $row1) {
            $nb_versement =  $nb_versement + $row1->nb_collecte ;
            $total+= $row1->montant ;
            ?>

            <tr>
                <td style="text-align: left; padding:8px;" class="ok"><?= \app\core\Utils::getDateFR($row1->date_versement);?></td>
                <td style="text-align: left; padding:8px;" class="ok"><?= $row1->label;?></td>
                <td style="text-align: center; padding:8px;" class="ok"><?= \app\core\Utils::getFormatMoney($row1->nb_collecte);?></td>
                <td style="text-align: right; padding:8px;" class="ok"><?= \app\core\Utils::getFormatMoney($row1->montant);?></td>



            </tr>

        <? } ?>
        <tr>
            <td  style="text-align: left; padding:8px;" class="ok">Total</td>
           <!-- <td style="text-align: center; padding:8px;" class="ok">&nbsp;</td>-->
            <td colspan="2" style=" padding-left:283px;" class="ok"><?php echo  \app\core\Utils::getFormatMoney($nb_versement) ;?></td>
            <td style="text-align: right; padding:8px;" class="ok"><?php echo  \app\core\Utils::getFormatMoney($total) ;?></td>
        </tr>

        </tbody>

    </table>
    <page_footer>

        <table  style="text-align: left; padding: 10px;margin-left: 20px; ">
            <tr >
                <td align="center" valign="center">
                    <?php echo $this->lang['piedp']; ?>&nbsp;&nbsp;<?php echo $this->lang['piedp1']; ?>
                    &nbsp;&nbsp;<?php echo $this->lang['export_date']. ': '.\app\core\Utils::getDateFR(date('Y-m-d')); ?>
                </td>
                <td align="right" valign="right" style="padding-left: 380px;">  &nbsp; &nbsp; &nbsp; &nbsp;</td>
                <td align="right" valign="right">
                    [[page_cu]]/[[page_nb]]
                </td>

            </tr>

        </table>

    </page_footer>

</page>