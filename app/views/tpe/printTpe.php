
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

    <table  style="text-align: right; padding: 10px;margin-left: 20px; ">
        <tr>
            <td style="text-align: right">

                &nbsp;&nbsp;<?php echo "<b>".$this->lang['tpetexte11']."</b>".\app\core\Utils::getDateFR(date('Y-m-d')); ?>
            </td>
            <td align="right" valign="right" style="padding-left: 380px;">  &nbsp; &nbsp; &nbsp; &nbsp;</td>
            <td align="right" valign="right">
                [[page_cu]]/[[page_nb]]
            </td>

        </tr>

    </table>
    <table  width="80%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr >
            <td style="text-align: left; padding: 10px 10px 15px 10px; border: 1px solid #0a7242; margin-bottom: 20px;background: #F0FFF0;"><strong><?php echo $this->lang['tpeTitle1'];?></strong></td>
        </tr>
         <tr >
            <td style="padding:8px;">&nbsp;&nbsp;</td>
        </tr>

    </table>

    <table  border="0" cellspacing="0" cellpadding="0" align="center" >

        <tbody>
        <tr>
            <td>
                <?php

                echo $this->lang['tpetexte1']." <b>".$impression->nom_materiel."</b> ". $this->lang['tpetexte2']." <b>".$impression->prenom." ".$impression->nom."</b>".
                    $this->lang['tpetexte3'].\app\core\Utils::getDateFR($impression->datedebut)." ".$this->lang['tpetexte4']." ".$impression->label."  ".$this->lang['tpetexte5'];
                ?>
            </td>

        </tr>

        <tr>
            <td> <?php echo $this->lang['tpetexte6']." ".$impression->heuredebut." ".$this->lang['tpetexte9']." ".$impression->heurefin." ".$this->lang['tpetexte10'] ;  ?></td>
        </tr>
        </tbody>


    </table>

    <br> <br> <br><br><br>



    <table  border="0" cellspacing="0" cellpadding="0" align="center" >
        <tr>
            <td align="left" ><?php echo "<b><u>". $this->lang['tpetexte7']."</u></b>";?>.&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;</td>
            <td style="text-align: right" ><?php echo "<b><u>".$this->lang['tpetexte8']."</u></b>";?></td>
        </tr>

    </table>


    <br> <br> <br><br><br><br><br>
    <hr>

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

    <table  style="text-align: right; padding: 10px;margin-left: 20px; ">
        <tr >
            <td align="right" valign="right">
                &nbsp;&nbsp;<?php echo "<b>".$this->lang['tpetexte11']."</b>".\app\core\Utils::getDateFR(date('Y-m-d')); ?>
            </td>
            <td align="right" valign="right" style="padding-left: 380px;">  &nbsp; &nbsp; &nbsp; &nbsp;</td>
            <td align="right" valign="right">
                [[page_cu]]/[[page_nb]]
            </td>

        </tr>

    </table>
    <table  width="80%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
            <td style="text-align: left; padding: 10px 10px 15px 10px; border: 1px solid #0a7242; margin-bottom: 20px;background: #F0FFF0;"><strong><?php echo $this->lang['tpeTitle1'];?></strong></td>
        </tr>
        <tr>
            <td style="padding:8px;">&nbsp;&nbsp;</td>
        </tr>

    </table>

    <table  border="0" cellspacing="0" cellpadding="0" align="center" >

        <tbody>
        <tr>
            <td>
                <?php

                echo $this->lang['tpetexte1']." <b>".$impression->nom_materiel."</b> ". $this->lang['tpetexte2']." <b>".$impression->prenom." ".$impression->nom."</b>".
                    $this->lang['tpetexte3'].\app\core\Utils::getDateFR($impression->datedebut)." ".$this->lang['tpetexte4']." ".$impression->label."  ".$this->lang['tpetexte5'];
                ?>
            </td>


        </tr>
        <tr>
            <td> <?php echo $this->lang['tpetexte6']." ".$impression->heuredebut." ".$this->lang['tpetexte9']." ".$impression->heurefin." ".$this->lang['tpetexte10'] ;  ?></td>
        </tr>
        </tbody>


    </table>

    <br> <br> <br><br><br>

    <table  border="0" cellspacing="0" cellpadding="0" align="center" >
        <tr>
            <td align="left" ><?php echo "<b><u>".$this->lang['tpetexte7']."</u></b>";?>.&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;</td>
            <td style="text-align: right" ><?php echo "<b><u>".$this->lang['tpetexte8']."</u></b>";?> </td>
        </tr>

    </table>

</page>

