
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

    <table border="0"  cellpadding="0" cellspacing="0" height="500px">

            <tr  >
                <td width="143" rowspan="2" align="left" valign="middle"  class="borderRIGHT borderLEFT borderTOP borderBOTTOM"  style="width: 115px;"></td>

                <td colspan="3" align="center"  valign="middle" class="textNormal borderRIGHT  borderTOP " style="width: 115px;"><?php echo $this->lang['agence']; ?>:  </td>
            </tr>
            <tr  >
                <td colspan="3" align="center"  valign="middle" class="textNormal borderRIGHT  borderTOP borderBOTTOM" style="width: 115px;"><span class="txt_form1" style="color: green;font-weight: bold"><?php echo $this->lang['recu_versemnt']; ?></span></td>
            </tr>

            <tr>
                <td colspan="4" align="left" valign="middle" nowrap="nowrap" class="txt_form"><!-- <hr align="center" style="border:#999 solid 1px" />-->
                </td>
            </tr>

            <tr >
                <td  align="left" valign="middle" nowrap="nowrap"  class="txt_form borderLEFT "><?php echo $this->lang['date']; ?>: </td>
                <td colspan="3"  align="left" valign="middle" class="txt_resultat  borderLEFT borderRIGHT" ></td>
            </tr>
            <tr >
                <td  align="left" valign="middle" nowrap="nowrap"  class="txt_form borderLEFT "><?php echo $this->lang['montant_collecte']; ?>:</td>
                <td colspan="3"  align="left" valign="middle" class="txt_resultat  borderLEFT borderRIGHT" ><span class="textNormal borderRIGHT borderLEFT borderTOP borderBOTTOM" style="width: 115px;"> XOF</span>                        </td>
            </tr>

            <tr>
                <td colspan="4" align="left" valign="middle" nowrap="nowrap" class="txt_form borderBOTTOM "><span class="txt_form1"></span>
                </td>
            </tr>


    </table>

</page>
