
<style>
    .borderTOP
    {
        border-top: 1px solid black;

        margin: 0;
    } .borderLEFT
      {
          border-left: 1px solid black;


      } .borderRIGHT
        {
            border-right: 1px solid black;
        } .borderBOTTOM
          { margin: 0;
              border-bottom: 1px solid black;

          }
</style>


<page backtop="5mm" backbottom="5mm"  backright="5mm" backleft="5mm" orientation="L">

    <table border="0"  cellpadding="0" cellspacing="0">
        <tr>
            <td style="width: 500px;" >
                <table cellpadding="0" cellspacing="0">
                    <tr  >
                        <td width="143" rowspan="2" align="left" valign="middle"  class="borderRIGHT borderLEFT borderTOP borderBOTTOM"  style="width: 115px;"><img src="<?= ROOT ?>assets/plugins/images/logo_mec.png"  height="30" width="100" style="margin: 15px; " /></td>

                        <td colspan="3" align="center"  valign="middle" class="textNormal borderRIGHT  borderTOP " style="width: 115px;">Agence: <?php echo $versement->rowid ;?></td>
                    </tr>
                    <tr  >
                        <td colspan="3" align="center"  valign="middle" class="textNormal borderRIGHT  borderTOP borderBOTTOM" style="width: 115px;"><span class="txt_form1" style="color: green;font-weight: bold">Reçu retrait tontine</span></td>
                    </tr>

                    <tr>
                        <td colspan="4" align="left" valign="middle" nowrap="nowrap" class="txt_form"><!-- <hr align="center" style="border:#999 solid 1px" />-->
                        </td>
                    </tr>

                    <tr >
                        <td  align="left" valign="middle" nowrap="nowrap"  class="txt_form borderLEFT ">Date: </td>
                        <td colspan="3"  align="left" valign="middle" class="txt_resultat  borderLEFT borderRIGHT" ><?php echo $versement->rowid?></td>
                    </tr>
                    <tr >
                        <td  align="left" valign="middle" nowrap="nowrap"  class="txt_form borderLEFT ">Tontine:</td>
                        <td colspan="3"  align="left" valign="middle" class="txt_resultat  borderLEFT borderRIGHT" ><span class="textNormal borderRIGHT borderLEFT borderTOP borderBOTTOM" style="width: 115px;"><?php echo 'LIBBRRR';?></span>                        </td>
                    </tr>
                    <tr >

                        <td  align="left" valign="middle" nowrap="nowrap"  class="txt_form borderLEFT ">Offre:</td>
                        <td colspan="3"  align="left" valign="middle" class="txt_resultat  borderLEFT borderRIGHT"><?php echo 'FGFFGF'; ?></td>
                    </tr>

                    <tr>
                        <td align="left" valign="middle" nowrap="nowrap" class="txt_form borderLEFT">Mise:</td>
                        <td colspan="3" align="left" valign="middle" class="txt_lister borderLEFT borderRIGHT"><?php echo 'FFFF'.' XOF'; ?></td>
                    </tr>

                    <tr>
                        <td  align="left" valign="middle" nowrap="nowrap" class="txt_form borderLEFT">Cagnotte:</td>
                        <td colspan="3" align="left" valign="middle" class="txt_lister borderLEFT borderRIGHT"><?php echo 'HHHH'.' XOF'; ?></td>
                    </tr>

                    <tr>
                        <td  align="left" valign="middle" nowrap="nowrap" class="txt_form borderLEFT">Frais adhésion:</td>
                        <td colspan="3" align="left" valign="middle" class="txt_lister borderLEFT borderRIGHT"><?php echo 'TTTTT'.' XOF'; ?></td>
                    </tr>
                    <tr>
                        <td align="left" valign="middle" nowrap="nowrap borderLEFT" class="txt_form borderLEFT">nombre cotisation:</td>
                        <td colspan="3" align="left" valign="middle" class="txt_lister borderLEFT borderRIGHT"><?php echo 'GGGG'; ?></td>
                    </tr>

                    <tr>
                        <td align="left" valign="middle" nowrap="nowrap" class="txt_form borderLEFT">Montant (liquidité):</td>
                        <td colspan="3" align="left" valign="middle" class="txt_lister borderLEFT borderRIGHT"><?php echo 'GGGGG'.' XOF'; ?></td>
                    </tr>
                    <tr>
                        <td align="left" valign="middle" nowrap="nowrap" class="txt_form borderLEFT">Montant en BV:</td>
                        <td colspan="3" align="left" valign="middle" class="txt_lister borderLEFT borderRIGHT"><?php echo 'JJJJ'.' XOF'; ?></td>
                    </tr>
                    <?php if($data['recu']['penalite'] > 0){?>
                        <tr>
                            <td align="left" valign="middle" nowrap="nowrap" style="color: red" class="txt_form borderLEFT">Pénalité:</td>
                            <td colspan="3" align="left" valign="middle" class="txt_lister borderLEFT borderRIGHT"><?php echo 'HHHHHH'.' XOF'; ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="4" align="left" valign="middle" nowrap="nowrap" class="txt_form borderTOP"><span class="txt_form1"></span>
                        </td>
                    </tr>
                    <tr>
                        <td  align="left" valign="middle" nowrap="nowrap" class="txt_form   borderLEFT"><strong>Client</strong></td>
                        <td colspan="3"  align="left" valign="middle" nowrap="nowrap" class="txt_form   borderLEFT borderRIGHT"><span class="txt_form1"></span><span class="txt_lister borderLEFT borderRIGHT"></span></td>
                    </tr>

                    <tr>
                        <td  align="left" valign="middle" nowrap="nowrap " class="txt_form borderLEFT">Prénom & Nom:</td>
                        <td colspan="3"  align="left" valign="middle" class="txt_lister borderLEFT borderRIGHT"><?php echo 'CLIENT'; ?></td>
                    </tr>

                    <tr>
                        <td align="left" valign="middle" nowrap="nowrap" class="txt_form borderLEFT">CNI:</td>
                        <td colspan="3" align="left" valign="middle" class="txt_lister borderLEFT borderRIGHT"><span class="txt_lister borderLEFT borderRIGHT"><?php echo 'GGGG'; ?></span></td>
                    </tr>
                    <tr>
                        <td align="left" valign="middle" nowrap="nowrap" class="txt_form borderLEFT">N&ordm; de t&eacute;l&eacute;phone :</td>
                        <td colspan="3" align="left" valign="middle" class="txt_lister borderLEFT borderRIGHT"><?php echo 'GGGGG'; ?></td>
                    </tr>


                    <tr>
                        <td colspan="4" align="left" valign="middle" nowrap="nowrap" class="txt_form borderBOTTOM "><span class="txt_form1"></span>
                        </td>
                    </tr>
                    <tr>
                        <td  align="left" valign="middle" nowrap="nowrap" class="txt_form  borderLEFT">
                            <span class="txt_form1"><strong>Agent</strong></span></td>

                        <td colspan="3"  align="left" valign="middle" nowrap="nowrap" class="txt_form   borderLEFT borderRIGHT"><span class="txt_form1"></span><span class="txt_lister borderLEFT borderRIGHT"></span></td>
                    </tr>

                    <tr>
                        <td align="left" valign="middle" nowrap class="txt_form borderLEFT">Prénom et nom:</td>
                        <td colspan="3" align="left" valign="middle" class="txt_lister borderLEFT borderRIGHT"><?php echo 'NOM PRENOM'; ?></td>
                    </tr>



                    <tr>
                        <td colspan="4"  align="left" valign="middle" nowrap="nowrap" class="txt_form borderTOP   "><span class="txt_form1"></span>
                        </td>

                    </tr>
                    <tr>
                        <td colspan="3" align="center" valign="top" nowrap class="txt_form1  borderLEFT">&nbsp;</td>
                        <td width="157" align="center" valign="top" nowrap="nowrap" class="txt_form1 borderRIGHT">&nbsp;</td>
                    </tr>

                    <tr>
                        <td colspan="2" align="left" valign="top" nowrap class="txt_form1 borderLEFT">Signature client</td>
                        <td colspan="2" align="center" valign="top" nowrap class="txt_form1  borderRIGHT">Cachet de l'agent</td>
                    </tr>

                    <tr>
                        <td colspan="2" align="center" valign="top" nowrap class="txt_form  borderLEFT "><p>&nbsp;</p>
                            <p>&nbsp;</p></td>
                        <td colspan="2" align="center" valign="top" nowrap="nowrap" class="txt_lister  borderRIGHT">&nbsp;</td>
                    </tr>

                    <tr>
                        <td height="31" align="left" valign="bottom" nowrap class="txt_form borderLEFT">contact :<span style="font-size:13px; color: #666;"><?php echo 'Telephone'?></span></td>
                        <td width="63" height="31" align="left" valign="bottom" nowrap class="txt_form">&nbsp;</td>
                        <td height="31" colspan="2" align="left" valign="bottom" nowrap class="txt_form borderRIGHT">email :<span style="font-size:13px; color: #666;"><?php echo 'email'?> </span></td>
                    </tr>
                    <tr>
                        <td colspan="4" align="center" valign="top" nowrap class="txt_form borderTOP " ></td>
                    </tr>
                </table>
            </td>
            <td style="width: 35px"></td>
            <td style="width: 500px;" >

            </td>
            <td style="width: 25px"></td>
        </tr>
    </table>

</page>
