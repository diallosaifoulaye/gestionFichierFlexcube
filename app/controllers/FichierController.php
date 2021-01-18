<?php

/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 15/02/2017
 * Time: 21:11
 */


namespace app\controllers;
use app\core\BaseController;
use app\core\Session;
use app\core\Utils;
use Matrix\Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\XMLWriter;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use app\models\FichierModel ;
use PhpOffice\PhpSpreadsheet ;




class FichierController extends BaseController
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new FichierModel();
    }

    private function initialiseCheet($cheet){

        $styleArray = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ]
        ];
        // Set document properties
        $cheet->getProperties()->setCreator('PhpOffice')
            ->setLastModifiedBy('PhpOffice')
            ->setTitle('Office 2007 XLSX Test Document')
            ->setSubject('Office 2007 XLSX Test Document')
            ->setDescription('PhpOffice')
            ->setKeywords('PhpOffice')
            ->setCategory('PhpOffice');

        $cheet->getDefaultStyle()->applyFromArray($styleArray);


    }

    public function testCsv(){
        $list = array (
            array('aaa', 'bbb', 'ccc', 'dddd'),
            array('123', '456', '789'),
            array('"aaa"', '"bbb"')
        );
        $this->download_send_headers("data_export_" . date("Y-m-d") . ".csv");
        echo $this->array2csv($list);
        die();
    }

    function array2csv(array &$array)
    {

        if (count($array) == 0) {
            return null;
        }
        ob_start();
        $df = fopen("php://output", 'w');
        fputcsv($df, array_keys(reset($array)));
        foreach ($array as $row) {
            //var_dump($row); //exit;
            fputcsv($df, $row);
        }
        fclose($df);
        return ob_get_clean();
    }

    function download_send_headers($filename) {
        // disable caching
        $now = gmdate("D, d M Y H:i:s");
        header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
        header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
        header("Last-Modified: {$now} GMT");

        // force download
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");

        // disposition / encoding on response body
        header("Content-Disposition: attachment;filename={$filename}");
        header("Content-Transfer-Encoding: binary");
    }

    public function editCheetStable(){
        error_reporting(E_ALL);
        try{

            $fileName = "SingleJrnlUpload_Template.xlsm";
            $nameCheet = 'SingleJrnlUpload_Template';
            $targetPath = 'Fichiers/xsl/'.$fileName ;

            //var_dump(\PhpOffice\PhpSpreadsheet\IOFactory::identify($targetPath));exit;
            $excel2 = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');

            //$excel2 =  IOFactory::createReader('Excel5');
            $excel2 = $excel2->load($targetPath); // Empty Sheet
            $excel2->setActiveSheetIndex(0);
            $excel2->getActiveSheet()->setCellValue('C6', '4')
                ->setCellValue('C7', '5')
                ->setCellValue('C8', '6')
                ->setCellValue('C9', '7');

            $excel2->setActiveSheetIndex(1);
            $excel2->getActiveSheet()->setCellValue('A7', '4')
                ->setCellValue('C7', '5');




            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$nameCheet.'.xlsm"');
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');
            // If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0
            $writer = IOFactory::createWriter($excel2, 'Xlsx');
            $writer->save('php://output');
            exit;
        }catch (\Exception $ex){
            var_dump($ex->getMessage());
        }

        // $this->openCheet($excel2, 'fichier');

    }

    public function  test(){
        var_dump($this->_USER->user_flexcube_id); exit;

        $Reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        $targetPath = 'Fichiers/Banque_Mai_2020.xls' ;

        $spreadSheet = $Reader->load($targetPath);
        $excelSheet = $spreadSheet->getActiveSheet();
        $spreadSheetAry = $excelSheet->toArray();
        $sheetCount = count($spreadSheetAry);

        for ($i = 0; $i <= $sheetCount; $i ++) {
            print_r($spreadSheetAry[$i]);
            echo '<br>';
        }

exit;

        $periode = "012020" ;
        $extension =  substr($periode, -4);
        echo $extension." ".substr($periode, 0,strlen($periode) - strlen($extension)) ;
    }
    public function editCheet(){
        error_reporting(E_ALL);
        try{


            $style = array(
                'alignment' => array(
                    'horizontal' => PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                )
            );

            $fichier = $this->getInformationFile($this->paramGET[0]) ;
            $extension =  substr($fichier->libelle, -4);
            $nomFichier = substr($fichier->libelle, 0, -4);

            $fileName = "SingleJrnlUpload_Template.xlsm";
            $nameCheet = 'SingleJrnlUpload_Template';
            $targetPath = 'Fichiers/xsl/'.$fileName ;

            //var_dump(\PhpOffice\PhpSpreadsheet\IOFactory::identify($targetPath));exit;
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');

            //$excel2 =  IOFactory::createReader('Excel5');
            $spreadsheet = $spreadsheet->load($targetPath); // Empty Sheet
            $spreadsheet->setActiveSheetIndex(0);


            $this->createColumnsFirstCheetMacro($spreadsheet) ;
            $spreadsheet->setActiveSheetIndex(1);

            $spreadsheet->getDefaultStyle()->applyFromArray($style);
            //$style = $spreadsheet->getActiveSheet()->getStyle("A3:V3");
            //$spreadsheet->getActiveSheet()->duplicateStyle($spreadsheet->getActiveSheet()->getStyle('A4'), 'A60');
            $spreadsheet->getActiveSheet()->removeRow(3,2);

            $this->createColumnsSecondCheetMacro($spreadsheet , $this->paramGET[0], $fichier->periode) ;
            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
           // $spreadsheet->setActiveSheetIndex(0);

           $this->openCheetMacro($spreadsheet, $nameCheet);
        }catch (\Exception $ex){
            var_dump($ex->getMessage());
        }

    }


    public function openCheetMacro($spread, $nameCheet){

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$nameCheet.'.xlsm"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $writer = IOFactory::createWriter($spread, 'Xlsx');
        $writer->save('php://output');
        exit;
    }
    private function createColumnsFirstCheetMacro($cheet){
        // Add some data
        $cheet->setActiveSheetIndex(0)
            ->setCellValue('A3', $_SESSION['codeAgence'])

            ->setCellValue('B3', 'FLEXCUBE')

            ->setCellValue('C3', '1001')

            ->setCellValue('D3', 'SALARY')

            ->setCellValue('E3', $this->_USER->user_flexcube_id)

            ->setCellValue('F3', 'Y')

            ->setCellValue('G3', 'U')

            ->setCellValue('H3', 'U')

            ->setCellValue('I3', 'O')

            ->setCellValue('J3', '');

        // Rename worksheet
       // $cheet->getActiveSheet()->setTitle($name);


    }

    private function createColumnsSecondCheetMacro($cheet ,$idFichier , $periodeComptable){
        // Add some data
        ini_set('precision', '15');

        $donnees = $this->model->getLineSuccess($idFichier) ;
        $i = 3 ;

        $periode = Utils::moisAnnee(str_pad($periodeComptable, 6, "0", STR_PAD_LEFT)) ;

        $j= 1 ;
        $montantTotal = 0 ;





        foreach ($donnees as $donnee){
            //$date = date_format($donnee->date_creation, 'd-m-Y');
            $date = date('m/d/Y');
            $date = str_replace('-', '', $date);
            $montantTotal = $montantTotal + $donnee->montant ;


            $compte =  str_pad($donnee->compte, 12, "0", STR_PAD_LEFT) ;



            $cheet->getActiveSheet()->setCellValue('A'.$i,  $_SESSION['codeAgence'])
                 ->setCellValue('B'.$i,  'FLEXCUBE')
               ->setCellValue('C'.$i, $j++)
               ->setCellValue('D'.$i, 'U')
                ->setCellValue('E'.$i, 'XOF')
                ->setCellValue('F'.$i, $date)
                ->setCellValue('G'.$i, $donnee->montant)
                ->setCellValueExplicit('H'.$i, trim($compte), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValue('I'.$i, (!empty($donnee->code_agence))?$donnee->code_agence : 240)
                ->setCellValue('J'.$i, 'C')
                ->setCellValue('K'.$i, $donnee->montant)
                ->setCellValue('L'.$i, '')
                ->setCellValue('M'.$i, $date)
                ->setCellValue('N'.$i, '')
                ->setCellValue('O'.$i, 'SAL')
                ->setCellValue('P'.$i, '')
                ->setCellValue('Q'.$i, '')
                ->setCellValue('R'.$i, '')
                ->setCellValue('S'.$i, 'FY'.(($periode) ? $periode['annee'] : ''))
                ->setCellValue('T'.$i, 'M'.(($periode) ? str_pad($periode['mois'], 2, "0", STR_PAD_LEFT)  : ''))
                ->setCellValue('U'.$i, 'SALARY')
                ->setCellValue('V'.$i, '1001')
               // ->setCellValue('W'.$i, '');
                ->setCellValue('W'.$i, '~~END~~') ;
           /* $cheet->getActiveSheet()->duplicateStyle($cheet->getActiveSheet()->getStyle('A2'), 'W'.$i);
            $cheet->getActiveSheet()->getStyle("A3:W".$i)->applyFromArray($style);*/




            $i++;
            //$j++;
        }

        $cheet->setActiveSheetIndex(1)
            ->setCellValue('A'.$i, '240')
            ->setCellValue('B'.$i,  'FLEXCUBE')
            ->setCellValue('C'.$i, $j)
            ->setCellValue('D'.$i, 'U')
            ->setCellValue('E'.$i, 'XOF')
            ->setCellValue('F'.$i, $date)
            ->setCellValue('G'.$i, $montantTotal)
            ->setCellValue('H'.$i, '')
            ->setCellValue('I'.$i, '240')
            ->setCellValue('J'.$i, 'D')
            ->setCellValue('K'.$i, $montantTotal)
            ->setCellValue('L'.$i, '')
            ->setCellValue('M'.$i, $date)
            ->setCellValue('N'.$i, '')
            ->setCellValue('O'.$i, 'SAL')
            ->setCellValue('P'.$i, '')
            ->setCellValue('Q'.$i, '')
            ->setCellValue('R'.$i, '')
            ->setCellValue('S'.$i, 'FY'.(($periode) ? $periode['annee'] : ''))
            ->setCellValue('T'.$i, 'M'.(($periode) ? str_pad($periode['mois'], 2, "0", STR_PAD_LEFT)  : ''))
            ->setCellValue('U'.$i, 'SALARY')
            ->setCellValue('V'.$i, '1001')
           // ->setCellValue('W'.$i, '');
         ->setCellValue('W'.$i, '~~END~~') ;
        /*  $cheet->getActiveSheet()->duplicateStyle($cheet->getActiveSheet()->getStyle('A2'), 'W'.$i);
       $cheet->getActiveSheet()->getStyle("A".$i.":W".$i)->applyFromArray($style);*/



        $cheet->setActiveSheetIndex(1)
            ->setCellValue('A'.($i+1), '~~END~~')
            ->setCellValue('B'.($i+1),  '~~END~~')
            ->setCellValue('C'.($i+1), '~~END~~')
            ->setCellValue('D'.($i+1), '~~END~~')
            ->setCellValue('E'.($i+1), '~~END~~')
            ->setCellValue('F'.($i+1), '~~END~~')
            ->setCellValue('G'.($i+1), '~~END~~')
            ->setCellValue('H'.($i+1), '~~END~~')
            ->setCellValue('I'.($i+1), '~~END~~')
            ->setCellValue('J'.($i+1), '~~END~~')
            ->setCellValue('K'.($i+1), '~~END~~')
            ->setCellValue('L'.($i+1), '~~END~~')
            ->setCellValue('M'.($i+1), '~~END~~')
            ->setCellValue('N'.($i+1), '~~END~~')
            ->setCellValue('O'.($i+1), '~~END~~')
            ->setCellValue('P'.($i+1), '~~END~~')
            ->setCellValue('Q'.($i+1), '~~END~~')
            ->setCellValue('R'.($i+1), '~~END~~')
            ->setCellValue('S'.($i+1), '~~END~~')
            ->setCellValue('T'.($i+1), '~~END~~')
            ->setCellValue('U'.($i+1), '~~END~~')
            ->setCellValue('V'.($i+1), '~~END~~')
            ->setCellValue('W'.($i+1), '~~END~~') ;



       /* foreach (range('A', 'W') as $column){
            $cheet->getActiveSheet()->duplicateStyle($cheet->getActiveSheet()->getStyle('A2'), $column.($i+1));
        }*/



    }





    public function uploadExcel(){

        try{


            $this->model->beginTransaction() ;

            $nomFichier = $this->paramFILE['file']['name'] ;

            $idFichierGenered = $this->model->get(["table"=>"fichier_genere","champs"=>["rowid"],"condition"=>["libelle = "=>trim($nomFichier)]])[0]->rowid;
            if($idFichierGenered)
                throw new \Exception("Un fichier avec ce même nom est deja généré") ;


            $idFile = $this->saveFileGenered($nomFichier) ;

            if (!($idFile > 0))
                throw new \Exception('Exception: table fichier_genere : creation') ;


            $allowedFileType = [
                'application/vnd.ms-excel',
                'text/xls',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            ];

            if (in_array($this->paramFILE['file']["type"], $allowedFileType)) {

                $targetPath = 'Fichiers/' . $this->paramFILE['file']['name'];
                move_uploaded_file($this->paramFILE['file']['tmp_name'], $targetPath);
                $Reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();

                $spreadSheet = $Reader->load($targetPath);
                $excelSheet = $spreadSheet->getActiveSheet();
                $spreadSheetAry = $excelSheet->toArray();
                $sheetCount = count($spreadSheetAry);

                $montantTotal = 0 ;
                $nbreSuccess = 0 ;
                $nombreLigne = $sheetCount ;

                $resultatInsertSuccess = 0 ;
                $libelle_virement = '';

                for ($i = 1; $i <= $sheetCount; $i ++) {
                    $type_virement = "";
                    if (isset($spreadSheetAry[$i][0])) {
                        $type_virement = $spreadSheetAry[$i][0];
                    }
                    $reference = "";
                    if (isset($spreadSheetAry[$i][1])) {
                        $reference = $spreadSheetAry[$i][1];
                    }
                    $compte_debite = "";
                    if (isset($spreadSheetAry[$i][2])) {
                        $compte_debite = $spreadSheetAry[$i][2];
                    }

                    $compte_credite = "";
                    if (isset($spreadSheetAry[$i][3])) {
                        $compte_credite = $spreadSheetAry[$i][3];
                    }

                    $nom_beneficiaire = "";
                    if (isset($spreadSheetAry[$i][4])) {
                        $nom_beneficiaire = $spreadSheetAry[$i][4];
                    }

                    $montant = "";
                    if (isset($spreadSheetAry[$i][5])) {
                        $montant = $spreadSheetAry[$i][5];
                    }
                    //$libelle_virement = "";
                    if (isset($spreadSheetAry[$i][6])) {
                        $libelle_virement = $spreadSheetAry[$i][6];
                    }


                    if (! empty($type_virement) || ! empty($reference) || ! empty($compte_debite) || ! empty($compte_credite) || ! empty($nom_beneficiaire) || ! empty($montant) || ! empty($libelle_virement)) {
                        $nbreSuccess ++ ;
                        $montantTotal = $montantTotal + $montant ;
                        $array = array('type_virement'=>$type_virement, 'reference'=>$reference, 'compte_debite'=>$compte_debite, 'compte_credite'=>$compte_credite, 'nom_beneficiaire'=>$nom_beneficiaire, 'montant'=>$montant, 'libelle_virement' => $libelle_virement, 'fk_rowid_fichier'=> $idFile,'etat'=>1) ;
                        $resultatInsertSuccess = $this->model->set(["table"=>"fichier_excel_detail","champs" => $array]);
                        if (!($resultatInsertSuccess > 0))
                            throw new \Exception($this->lang["echec_add_element"].' table fichier_excel_detail, numéro:') ;
                    }



                }
            } else {
                $message = "Invalid File Type. Upload Excel File.";
                throw new \Exception($message) ;

            }


            $param['condition'] = ["rowid = " => $idFile];
            $arrayU['nb_ligne'] = intval($nbreSuccess);
            $arrayU['fk_type_fichier'] = 2;
            $arrayU['nb_succes'] = intval($nbreSuccess);
            $arrayU['montant'] = intval($montantTotal) ;
            $arrayU['periode'] =  $libelle_virement;
            $param['champs'] = $arrayU ;

            $resultat = $this->model->updateFileGenered($param);
            if (!($resultat > 0))
                throw new \Exception('Exception: Update table fichier_genere') ;


            if (($resultat > 0) && ($resultatInsertSuccess > 0)){
                Utils::setMessageALert(["success","Fichier charger avec succés"]);
                $this->model->commit() ;
            }else
                throw new \Exception('Exception: Echec chargement ficher') ;

        }catch (\Exception $e){
            //var_dump($e->getMessage());exit;
            $this->model->rollBack() ;
            Utils::setMessageALert(["danger",$e->getMessage()]);
            //Utils::redirect("fichier", "listeExcel");
        }
        Utils::redirect("fichier", "listeExcel");


    }

    public function traiterFichier()
    {
        try{

            $this->model->beginTransaction() ;
            $sizeOneLine = 60 ;
            if ( $sizeOneLine > filesize($this->paramFILE['file']['tmp_name']) )
                throw new \Exception($this->lang["file_must_content_line"]);

            $nomFichier = $this->paramFILE['file']['name'];
            $idPartenaire = $this->paramPOST['fk_partenaire'];

            $annee = $this->paramPOST['annee'];
            $mois = $this->paramPOST['mois'];
            $periode = strval(intval($mois).intval($annee));
            $idFichierGenered = $this->model->get(["table"=>"fichier_genere","champs"=>["rowid"],"condition"=>["libelle = "=>trim($nomFichier), "etat = "=>1]])[0]->rowid;
           // if($idFichierGenered)
                //throw new \Exception("Un fichier avec ce même nom est deja généré") ;


            $inputsFile =  file($this->paramFILE['file']['tmp_name'], FILE_SKIP_EMPTY_LINES);
            $extension =  substr($nomFichier, -4);


            if($idTypeFile = $this->isExtensionAuthorize($extension, $idPartenaire)){
                $idFile = $this->saveFileGenered($nomFichier,$idPartenaire) ;
                $infoGeneration = $this->traiterValiderFichier($idFile , $idTypeFile , $inputsFile) ;
                $infoGeneration['periode'] = $periode ;
                //var_dump($infoGeneration['periode']); exit;
                $this->updateFileGenered($idFile, $infoGeneration);
                $nomFileUplode = $this->uploadFile($this->paramFILE['file']) ;
                if ($nomFileUplode == false)
                    throw new \Exception("Le fichier n'a pas été téléchargé") ;

                $this->model->commit() ;
            }else
                throw new \Exception("Cette extension n\'est pas encore pris en compte pour ce partenaire") ;
            Utils::setMessageALert(["success",$this->lang["succes_charged"]]);
            Utils::redirect("fichier", "detailFichier/".base64_encode($idFichierGenered));
        }catch (\Exception $e){
            $this->model->rollBack() ;
            //var_dump($e->getMessage());exit;
            Utils::setMessageALert(["danger",$e->getMessage()]);
            Utils::redirect("fichier", "liste");
        }

        Utils::redirect("fichier", "liste");

    }
    /**
     * @param $idFile
     * @param $idTypeFile
     * @param $inputs
     * @throws \Exception
     */
    private function traiterValiderFichier($idFile, $idTypeFile, $inputs){
        $reglesValidation = $this->getReglesValidation($idTypeFile) ;
        $nombreLigne= 0 ;
        $montantTotal = 0 ;
        $nbSuccess = 0 ;
        $nbError = 0 ;
        $periode = '' ;


        $statGeneralValidation = array('nbSuccess'=> 0 ,'montantTotal'=>0);
        foreach ($inputs as $rowIndex => $line) {
            if(!empty(trim($line))){
                $nombreLigne++ ;
                $infosLine = $this->validerLine($nombreLigne, $line , $idFile , $reglesValidation) ;
                if (count($infosLine) > 1){
                    $montantTotal = $montantTotal + intval($infosLine[1]) ;
                    $periode = $infosLine[2] ;
                    $nbSuccess = $nbSuccess + 1 ;
                }else{
                    $nbError = $nbError + 1 ;
                }
            }

        }
//exit;
        $array = [] ;
        $array['nb_ligne']  = $nombreLigne;
        $array['nb_succes'] = $nbSuccess;
        $array['montant'] = $montantTotal;
        $array['periode'] = $periode;

        return $array ;

    }

    public function validerLine($numero ,$line , $idFile , $regles){

        $message = '' ;
        $numColonne = 1 ;
        $isCorrect = true ;
        $montant = 0 ;
        $MATRICULE = '' ; $PRENOM = '' ; $NOM = '' ; $COMPTE = '' ;  $MONTANT = 0 ; $DATEPAIE = '' ; $ETAB=''; $MATR =''; $CATEG=''; $REG=''; $code_agence = '' ; $num_compte = '' ;
        foreach ($regles as $regle){
            ${$regle->libelle} = trim(substr($line,$regle->de - 1,$regle->longueur)) ;
            if ($regle->libelle == 'MATRICULE'){
                $row = $this->model->get(["table"=>"dictionnaire_mat_compte_banque" , "champs"=>["count(rowid) as nombre, num_compte, code_agence"] , "condition" => ["matricule ="=>trim($MATRICULE) ]])[0];

                if ($row->nombre > 0){
                    $code_agence = $row->code_agence ;
                    //$num_compte = substring($row->num_compte,5,12)  ;
                    $num_compte = substr($row->num_compte,5,12)  ;
                }else{
                    $message .= $MATRICULE." : Ce numéro ne figure pas sur la liste des comptes" ;
                    $isCorrect = false ;
                }

            }

            if ($regle->type == 1){
                if (!is_numeric(${$regle->libelle})){
                    $message .= "Colonne (".$numColonne."):". $regle->libelle. " , valeur =".${$regle->libelle}." , est type incorrect ;" ;
                    $isCorrect = false ;
                }else{
                    if ($regle->libelle == 'MONTANT'){
                        $montant = intval(trim(${$regle->libelle})) ;
                    }
                }
            }
            $numColonne ++ ;
        }

        if ($num_compte != '')
            $COMPTE = $num_compte ;
//echo 'Matricule :'.$MATRICULE.'<br>' ;
        if ($isCorrect){
            $arraySuccess = [] ;
            $arraySuccess['fk_fichier'] = $idFile ;
            $arraySuccess['matricule'] = $MATRICULE ;
            $arraySuccess['prenom'] = $PRENOM ;
            $arraySuccess['nom'] = $NOM ;
            $arraySuccess['compte'] =  $COMPTE ;
            $arraySuccess['montant'] = $MONTANT ;
            $arraySuccess['date_paie'] = $DATEPAIE ;
            $arraySuccess['etab'] = $ETAB ;
            $arraySuccess['matr'] = $MATR ;
            $arraySuccess['catr'] = $CATEG ;
            $arraySuccess['reg'] = $REG ;
            $arraySuccess['line'] = $numero ;
            $arraySuccess['line_text'] = $line ;
            $arraySuccess['code_agence'] = $code_agence ;
           // var_dump($arraySuccess);exit;

            $resultatInsertSuccess = $this->model->set(["table"=>"fichier_line_success","champs" => $arraySuccess]);
            if (!($resultatInsertSuccess > 0))
                throw new \Exception($this->lang["echec_add_element"].' table fichier_line_success, numéro:'.$numero) ;

            //On retourne un tableau : true et le montant de la ligne
            return array($isCorrect , $montant, $arraySuccess['date_paie']) ;
        }else{
            $arrayError = [] ;
            $arrayError['fk_fichier'] = $idFile ;
            $arrayError['line'] = $numero ;
            $arrayError['line_text'] = $line ;
            $arrayError['commentaire'] = $message  ;

            $resultatInsertError = $this->model->set(["table"=>"fichier_line_error","champs" => $arrayError]);
            if (!($resultatInsertError > 0))
                throw new \Exception($this->lang["echec_add_element"].' table fichier_line_error, numéro:'.$numero) ;

            return array($isCorrect) ;

        }


    }

    public function getReglesValidation($idFile){
        $reglesValidation = $this->model->get(["table"=>"fichier_format" , "champs"=>["*"] , "condition" => ["fk_type_fichier ="=>$idFile ]]);
        if (count($reglesValidation) > 0)
            return $reglesValidation ;
        else  throw new \Exception('Exception: Aucune régle de validation définie') ;
    }

    private function uploadFile($file){
        $nomFichier = substr($file['name'], 0, -4);
        return Utils::setUploadFiles($file ,'Fichiers',$nomFichier);
    }

    private function saveFileGenered($nomFile, $fk_partenaire =''){
        $array = array('libelle'=>$nomFile , 'lien'=>$nomFile, 'fk_partenaire'=>$fk_partenaire);
        $resultat = $this->model->insertFileGenered(["champs"=>$array]);
        if (!($resultat > 0))
            throw new \Exception('Exception: Ajout table fichier_genere') ;
        return $resultat ;
    }

    private function updateFileGenered($idFile , $infos){

        $param['condition'] = ["rowid = " => $idFile];
        $array['nb_ligne'] = intval($infos['nb_ligne']);
        $array['fk_type_fichier'] = 1;
        $array['nb_succes'] = intval($infos['nb_succes']);
        $array['montant'] = intval($infos['montant']) ;
        $array['periode'] =  intval($infos['periode']);
        $param['champs'] = $array ;

        $resultat = $this->model->updateFileGenered($param);
        if (!($resultat > 0))
            throw new \Exception('Exception: Update table fichier_genere') ;
        return $resultat ;
    }


    private function isExtensionAuthorize($ext, $idPartenaire = ''){
        if($ext ){
            $idFichier = $this->model->get(["table"=>"fichier_type","champs"=>["rowid"],"condition"=>["extension = "=>$ext, "fk_partenaire="=>$idPartenaire]])[0]->rowid;
            return ($idFichier > 0)  ? $idFichier : false ;
        }
        return false ;

    }

    private function createColumnsFirstCheet($cheet , $name = 'Upload_Master'){
        // Add some data
        $cheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'DETB_UPLOAD_MASTER')
            ->setCellValue('A2', 'BRANCH_CODE')
            ->setCellValue('A3', $_SESSION['codeAgence'])
            ->setCellValue('A4', '~~END~~')

            ->setCellValue('B2', 'SOURCE_CODE')
            ->setCellValue('B3', 'FLEXCUBE')
            ->setCellValue('B4', '~~END~~')

            ->setCellValue('C2', 'BATCH_NO')
            ->setCellValue('C3', '1001')
            ->setCellValue('C4', '~~END~~')

            ->setCellValue('D2', 'BATCH_DESC')
            ->setCellValue('D3', 'SALARY')
            ->setCellValue('D4', '~~END~~')

            ->setCellValue('E2', 'USER_ID')
            ->setCellValue('E3', $this->_USER->user_flexcube_id)
            ->setCellValue('E4', '~~END~~')

            ->setCellValue('F2', 'BALANCING')
            ->setCellValue('F3', 'Y')
            ->setCellValue('F4', '~~END~~')

            ->setCellValue('G2', 'UPLOAD_STAT')
            ->setCellValue('G3', 'U')
            ->setCellValue('G4', '~~END~~')

            ->setCellValue('H2', 'AUTH_STAT')
            ->setCellValue('H3', 'U')
            ->setCellValue('H4', '~~END~~')

            ->setCellValue('I2', 'RECORD_STAT')
            ->setCellValue('I3', 'O')
            ->setCellValue('I4', '~~END~~')

            ->setCellValue('J2', 'ONCE_AUTH')
            ->setCellValue('J3', '')
            ->setCellValue('J4', '~~END~~')


            ->setCellValue('K2', '~~END~~')
            ->setCellValue('K3', '~~END~~')
            ->setCellValue('K4', '~~END~~');


        // Rename worksheet
        $cheet->getActiveSheet()->setTitle($name);


    }

    private function creatHeaderCheet2($cheet){
        $cheet->setActiveSheetIndex(1)
            ->setCellValue('A1', 'UPLOAD_DETAIL')
            ->setCellValue('A2', 'BRANCH_CODE')
            ->setCellValue('B2', 'SOURCE_CODE')
            ->setCellValue('C2', 'CURR_NO')
            ->setCellValue('D2', 'UPLOAD_STAT')
            ->setCellValue('E2', 'CCY_CD')
            ->setCellValue('F2', 'INITIATION_DATE')
            ->setCellValue('G2', 'AMOUNT')
            ->setCellValue('H2', 'ACCOUNT')
            ->setCellValue('I2', 'ACCOUNT_BRANCH')
            ->setCellValue('J2', 'DR_CR')
            ->setCellValue('K2', 'LCY_EQUIVALENT')
            ->setCellValue('L2', 'EXCH_RATE')
            ->setCellValue('M2', 'VALUE_DATE')
            ->setCellValue('N2', 'INSTRUMENT_NO')
            ->setCellValue('O2', 'TXN_CODE')
            ->setCellValue('P2', 'TXN_MIS_1')
            ->setCellValue('Q2', 'TXN_MIS_4')
            ->setCellValue('R2', 'MIS_GROUP')
            ->setCellValue('S2', 'FIN_CYCLE')
            ->setCellValue('T2', 'PERIOD_CODE')
            ->setCellValue('U2', 'ADDL_TEXT')
            ->setCellValue('V2', 'BATCH_NO')
            ->setCellValue('W2', 'TXN_MIS_4')
            ->setCellValue('X2', '~~END~~');

    }

    private function createColumnsSecondCheet($cheet ,$idFichier , $periodeComptable, $name = 'Upload_Detail'){
        // Add some data
        ini_set('precision', '15');
        $this->creatHeaderCheet2($cheet) ;
        $donnees = $this->model->getLineSuccess($idFichier) ;
        $i = 3 ;

        $periode = Utils::moisAnnee(str_pad($periodeComptable, 6, "0", STR_PAD_LEFT)) ;

        $j= 1 ;
        $montantTotal = 0 ;
        foreach ($donnees as $donnee){
            $date = date_format(date_create($donnee->date_creation), 'd/m/Y');
            //$date = str_replace('-', '', $date);
            $montantTotal = $montantTotal + $donnee->montant ;


            $compte = str_pad($donnee->compte, 12, "0", STR_PAD_LEFT) ;

            $cheet->setActiveSheetIndex(1)
                ->setCellValue('A'.$i,  $_SESSION['codeAgence'])
                ->setCellValue('B'.$i,  'FLEXCUBE')
                ->setCellValue('C'.$i, $j++)
                ->setCellValue('D'.$i, 'U')
                ->setCellValue('E'.$i, 'XOF')
                ->setCellValue('F'.$i, $date)
                ->setCellValue('G'.$i, $donnee->montant)
                ->setCellValueExplicit('H'.$i, $compte, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValue('I'.$i, (!empty($donnee->code_agence))?$donnee->code_agence : 240)
                ->setCellValue('J'.$i, 'C')
                ->setCellValue('K'.$i, $donnee->montant)
                ->setCellValue('L'.$i, '')
                ->setCellValue('M'.$i, $date)
                ->setCellValue('N'.$i, '')
                ->setCellValue('O'.$i, 'SAL')
                ->setCellValue('P'.$i, '')
                ->setCellValue('Q'.$i, '')
                ->setCellValue('R'.$i, '')
                ->setCellValue('S'.$i, 'FY'.(($periode) ? $periode['annee'] : ''))
                ->setCellValue('T'.$i, 'M'.(($periode) ? str_pad($periode['mois'], 2, "0", STR_PAD_LEFT)  : ''))
                ->setCellValue('U'.$i, 'SALARY')
                ->setCellValue('V'.$i, '1001')
                ->setCellValue('W'.$i, '')
                ->setCellValue('X'.$i, '~~END~~') ;




            $i++;
            //$j++;
        }

        $cheet->setActiveSheetIndex(1)
            ->setCellValue('A'.$i, '240')
            ->setCellValue('B'.$i,  'FLEXCUBE')
            ->setCellValue('C'.$i, $j)
            ->setCellValue('D'.$i, 'U')
            ->setCellValue('E'.$i, 'XOF')
            ->setCellValue('F'.$i, $date)
            ->setCellValue('G'.$i, $montantTotal)
            ->setCellValue('H'.$i, '')
            ->setCellValue('I'.$i, '240')
            ->setCellValue('J'.$i, 'D')
            ->setCellValue('K'.$i, $montantTotal)
            ->setCellValue('L'.$i, '')
            ->setCellValue('M'.$i, $date)
            ->setCellValue('N'.$i, '')
            ->setCellValue('O'.$i, 'SAL')
            ->setCellValue('P'.$i, '')
            ->setCellValue('Q'.$i, '')
            ->setCellValue('R'.$i, '')
            ->setCellValue('S'.$i, 'FY'.(($periode) ? $periode['annee'] : ''))
            ->setCellValue('T'.$i, 'M'.(($periode) ? str_pad($periode['mois'], 2, "0", STR_PAD_LEFT)  : ''))
            ->setCellValue('U'.$i, 'SALARY')
            ->setCellValue('V'.$i, '1001')
            ->setCellValue('W'.$i, '')
            ->setCellValue('X'.$i, '~~END~~') ;





        $cheet->setActiveSheetIndex(1)
            ->setCellValue('A'.($i+1), '~~END~~')
            ->setCellValue('B'.($i+1),  '~~END~~')
            ->setCellValue('C'.($i+1), '~~END~~')
            ->setCellValue('D'.($i+1), '~~END~~')
            ->setCellValue('E'.($i+1), '~~END~~')
            ->setCellValue('F'.($i+1), '~~END~~')
            ->setCellValue('G'.($i+1), '~~END~~')
            ->setCellValue('H'.($i+1), '~~END~~')
            ->setCellValue('I'.($i+1), '~~END~~')
            ->setCellValue('J'.($i+1), '~~END~~')
            ->setCellValue('K'.($i+1), '~~END~~')
            ->setCellValue('L'.($i+1), '~~END~~')
            ->setCellValue('M'.($i+1), '~~END~~')
            ->setCellValue('N'.($i+1), '~~END~~')
            ->setCellValue('O'.($i+1), '~~END~~')
            ->setCellValue('P'.($i+1), '~~END~~')
            ->setCellValue('Q'.($i+1), '~~END~~')
            ->setCellValue('R'.($i+1), '~~END~~')
            ->setCellValue('S'.($i+1), '~~END~~')
            ->setCellValue('T'.($i+1), '~~END~~')
            ->setCellValue('U'.($i+1), '~~END~~')
            ->setCellValue('V'.($i+1), '~~END~~')
            ->setCellValue('W'.($i+1), '~~END~~') ;






        // Rename worksheet
        $cheet->getActiveSheet()->setTitle($name);

    }

    private function openCheet($cheet , $nameCheet = '01simple', $type ='Xlsx'){

        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$nameCheet.'.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $writer = IOFactory::createWriter($cheet, $type);
        $writer->save('php://output');
        exit;

    }

    public function xslCheet(){

        //var_dump($this->_USER);exit ;

        $fichier = $this->getInformationFile($this->paramGET[0]) ;
        $extension =  substr($fichier->libelle, -4);
        $nomFichier = substr($fichier->libelle, 0, -4);
        if($fichier){
            $spreadsheet = new Spreadsheet();



            $this->initialiseCheet($spreadsheet);
            $spreadsheet->createSheet();
            $this->createColumnsFirstCheet($spreadsheet) ;
            $this->createColumnsSecondCheet($spreadsheet , $this->paramGET[0], $fichier->periode) ;
            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $spreadsheet->setActiveSheetIndex(0);
            $this->openCheet($spreadsheet, $nomFichier) ;

        }else{
            Utils::setMessageALert(["danger",$this->lang["not_file"]]);
            Utils::redirect("fichier", "liste");
        }

    }

    public function getInformationFile($id){

        if( $id > 0 ){
            $fichier = $this->model->get(["table"=>"fichier_genere","champs"=>["rowid, libelle, montant, periode, nom_sequentiel"],"condition"=>["rowid = "=>$id]])[0];
           return $fichier ;
        }
        return null ;
    }

    public function listeExcel()
    {
        Utils::setDefaultSort(1, "DESC");
        $this->views->getTemplate("fichier/listeExcel");
    }

    public function generateXml($nameFile = 'sow'){


        if(isset($this->paramGET[0])) {

            $infoFichier = $this->getInformationFile($this->paramGET[0]) ;
            header('Content-Disposition: attachment; filename='.$infoFichier->nom_sequentiel.';');
            echo file_get_contents('Fichiers/xml/'.$infoFichier->nom_sequentiel);
            exit;

        }else{
            Utils::setMessageALert(["danger",$this->lang["actionechec"]]);
            Utils::redirect("fichier", "listeExcel");
        }



    }

    public function fichierModal__()
    {
        $data['partenaires'] = $this->model->get(["table"=>"gestion_partenaire","champs"=>["id, nom , code"]]);

        $data['tabMois'] = ["01"=>"Jan","02"=>"Fev","03"=>"Mar","04"=>"Avr","05"=>"Mai","06"=>"Jui","07"=>"Juil","08"=>"Aout","09"=>"Sept","10"=>"Oct","11"=>"Nov","12"=>"Dec"];
        $data['tabAnnee'] = ["2020"=>"2020","2021"=>"2021","2022"=>"2022","2023"=>"2023","2024"=>"2024","2025"=>"2025","2026"=>"2026","2027"=>"2027","2028"=>"2028","2029"=>"2029","2030"=>"2030","2031"=>"2031"];

        $this->views->setData($data);

        $this->modal();
    }

    public function getparametrage(){
        $partenaire = $this->paramPOST['partenaire'];
        $nomFile = $this->paramPOST['nomFile'];
        $ext = pathinfo($nomFile, PATHINFO_EXTENSION);
        $nombre = $this->model->get(["table"=>"fichier_type","champs"=>["count(rowid) as nombre"], "condition"=>['fk_partenaire ='=>$partenaire, 'extension='=>'.'.$ext]])[0]->nombre;
        echo ($nombre > 0) ? 1 : 0 ;
    }

    public function validateFichierExcel(){
        if(isset($this->paramGET[0])) {

            $infoFichier = $this->getInformationFile($this->paramGET[0]) ;
            $lines = $this->model->getLinesExcelSuccess($infoFichier->rowid) ;
            $nomFichier = $this->createXml($lines, $infoFichier->montant );
            //var_dump($lines); exit;

            $etat = 1 ;
            $id = $this->paramGET[0] ;
            $result = $this->model->set(["table"=>"fichier_genere", "champs"=>['etat'=>$etat, "nom_sequentiel" => $nomFichier ], "condition"=>["rowid =" => $id]]);
            if($result !== false)
                Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
            else
                Utils::setMessageALert(["danger",$this->lang["actionechec"]]);
        }
        Utils::redirect("fichier", "listeExcel");
    }

    private function createXml($array = array(),$montantTotal = '300000', $employeur="POSTEFINANCES"){
       // echo '<pre>' ;
        //var_dump($array); exit;

        $date = Date('Y-m-d H:i:s');
        $dateFormatT = str_replace(' ','T',$date);

        $date = str_replace(' ','',$date);
        $date = str_replace('-','',$date);
        $date = str_replace(':','',$date);
        //echo $date; exit;


        $nomFichierXml = "PAIN001V01".$date.".xml" ;
        $xml = new  XMLWriter();

        $xml->openURI('Fichiers/xml/'.$nomFichierXml);
        $xml->setIndent(true);
        chmod(__DIR__ . '/../Fichiers/xml/'.$nomFichierXml, 777);

        $xml->startDocument('1.0', 'utf-8');

            $xml->startElement("Document");
                $xml->writeAttribute('xmlns:xsi', "http://www.w3.org/2001/XMLSchema-instance");
                $xml->writeAttribute('xmlns', "urn:iso:std:iso:20022:tech:xsd:pain.001.001.03");
        $xml->startElement("CstmrCdtTrfInitn");

                    //HEADER START
                    $xml->startElement("GrpHdr");
                        $xml->writeElement('MsgId','MESSAGEID'.$date);
                        $xml->writeElement('CreDtTm', $dateFormatT);
                        $xml->writeElement('NbOfTxs',count($array));
                        //$xml->writeElement('CtrlSum',number_format($montantTotal));
                        $xml->writeElement('CtrlSum',$montantTotal);

                    $xml->startElement("InitgPty");
                        $xml->writeElement('Nm',$employeur);
                    $xml->endElement();

                    $xml->endElement();
                    //HEADER END

                    //BODY LOOP START
                    foreach ($array as $item => $itemData){
                        $item1 = $item + 1 ;

                        $xml->startElement("PmtInf");
                            $xml->writeElement('PmtInfId','BATCHIDID'.$date.$item1);
                            $xml->writeElement('PmtMtd','TRF');
                            $xml->writeElement('NbOfTxs',$item1);
                            //$xml->writeElement('CtrlSum',number_format($itemData->montant));
                            $xml->writeElement('CtrlSum',$itemData->montant);

                        $xml->startElement("PmtTpInf");
                            $xml->writeElement('InstrPrty','NORM');

                        $xml->startElement("SvcLvl");
                            $xml->writeElement('Cd','ACH');
                        $xml->endElement();

                        $xml->startElement("LclInstrm");
                            $xml->writeElement('Cd','CCI');
                        $xml->endElement();

                        $xml->startElement("CtgyPurp");
                            $xml->writeElement('Cd','SUPP');
                        $xml->endElement();

                        $xml->endElement();

                        $xml->writeElement('ReqdExctnDt',date('Y-m-d'));

                        $xml->startElement("Dbtr");
                            $xml->writeElement('Nm','DIRECTION FINANCES et COMPTABILITE POSTE');
                        $xml->endElement();

                        $xml->startElement("DbtrAcct");

                        $xml->startElement("Id");

                        $xml->startElement("Othr");
                            $xml->writeElement('Id',substr($itemData->compte_debite,5,12));

                        $xml->startElement("SchmeNm");
                            $xml->writeElement('Cd','BBAN');
                        $xml->endElement();

                            $xml->writeElement('Issr','COMPTE POSTEFINANCES DEBITE');
                        $xml->endElement();

                        $xml->endElement();

                        $xml->endElement();


                        $xml->startElement("DbtrAgt");

                        $xml->startElement("FinInstnId");
                            $xml->writeElement('BIC','OSTSND1000');
                        $xml->endElement();

                        $xml->endElement();


                        $xml->startElement("CdtTrfTxInf");

                        $xml->startElement("PmtId");
                            $xml->writeElement('InstrId','INSTRID201912131040000059');
                            $xml->writeElement('EndToEndId','E2EID201912131040000059');
                        $xml->endElement();

                        $xml->startElement("Amt");
                            $xml->writeAttribute('Ccy', "XOF");
                            //$xml->writeElement('InstdAmt',number_format($itemData->montant));
                            $xml->writeElement('InstdAmt',$itemData->montant);
                        $xml->endElement();

                        $xml->writeElement('ChrgBr','SLEV');

                        $xml->startElement("CdtrAgt");

                        $xml->startElement("FinInstnId");
                            $xml->writeElement('BIC','POSTSND1000');
                        $xml->endElement();

                        $xml->endElement();

                        $xml->startElement("Cbtr");
                            $xml->writeElement('Nm',$itemData->nom_beneficiaire);
                        $xml->endElement();

                        $xml->startElement("CdtrAcct");

                        $xml->startElement("Id");
                            $xml->writeElement('IBAN', $itemData->compte_credite);
                        $xml->endElement();

                        $xml->endElement();

                        $xml->startElement("Purp");
                            $xml->writeElement('Cd','BEXP');
                        $xml->endElement();

                        $xml->endElement();

                        $xml->endElement();
                        //BODY LOOP END
                    }

        $xml->endElement();
        $xml->endDocument();
        $xml->flush();

        return $nomFichierXml ;

    }


    public function listeExcelProcessing__()
    {
        $param = [
            "button"=> [
                "modal" => [],
                "default" => [
//                    ["fichier/deleteFichier/","fa fa-trash"],
                    ["champ"=>"etat",
                        "val"=>
                            ["0"=>  ["fichier/validateFichierExcel/","fa fa-check-circle"]]
                    ],
                    ["champ"=>"etat",
                        "val"=>
                            ["0"=>  ["fichier/rejeterFichier/","fa fa-times-circle"]]
                    ],
                    ["champ"=>"etat",
                        "val"=>
                            [
                                "1"=>  ["fichier/rejeterFichier/","fa fa-times-circle"],
                                "2"=>  ["fichier/rejeterFichier/","fa fa-check-circle"]
                            ]
                    ],

                    ["fichier/detailFichier/","fa fa-search"],

                    ["champ"=>"etat",
                        "val"=>
                            ["1"=>  ["fichier/generateXml/","fa fa-file-code-o"]]
                    ]
                ],
                "custom" => []
            ],
            "tooltip"=> [
                "modal" => [
                    $this->lang["tooltipModif"]
                ],
                "default" => [
                    $this->lang["valide"],$this->lang["rejet"],$this->lang["rapport"],$this->lang["generer_excel"]
                ]
            ],
            "classCss"=> [
                "modal" => [],
                "default" => ["confirm","confirm"]
            ],
            "attribut"=> [
                "modal" => [],
                "default" => []
            ],
            "args"=>null,
            "dataVal"=>[
                ["champ"=>"etat","val"=>[
                    0=>["<span style='.temp::before{text-align: right;}' class='temp text-info'>". $this->lang['en_attente'] ."</span>"],
                    2=>["<span style='.temp::before{text-align: right;}' class='temp text-danger'>". $this->lang['rejet'] ."</span>"],
                    1=>["<span  class='temp text-success' >". $this->lang['valide'] ."</span><style>.temp::before{text-align: right;}</style>"]]]
            ],
            "fonction"=>[
                "date_creation"=>"getDateFR",
                "libelle"=>"afficherLienExcel/alldata",
                "nb_ligne"=>"alignCenter",
                "nb_error"=>"alignCenterDanger",
                "montant"=>"alignCenterMontantInfo"

            ]
        ];
        $this->processing($this->model, "getListeExcelProcess", $param);
    }



    /**
     * @droit Liste module - 1
     */
    public function liste()
    {
        Utils::setDefaultSort(1, "DESC");
        $this->views->getTemplate();
    }




    public function formats(){

        if($this->paramGET[0]){
            $data['fichier'] = $this->model->get(["table"=>"fichier_type","champs"=>["rowid, libelle, extension"],"condition"=>["rowid = "=>$this->paramGET[0]]])[0];
            $data['idTypeFichier']= $this->paramGET[0] ;
            $this->views->setData($data);
        }

        $this->views->getTemplate('fichier/formats');
    }


    public function ajoutFormat()
    {
        //parent::validateToken("exemples", "exemples");
        //var_dump($this->paramPOST); exit;

        if((isset($this->paramPOST["libelle"])) && isset($this->paramPOST["extension"])) {
            $result = $this->model->insertType(["champs"=>$this->paramPOST]);
            if($result !== false) Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
            else Utils::setMessageALert(["danger",$this->lang["actionechec"]]);
        }
        Utils::redirect("fichier", "type");
    }


    public function ajoutColonne()
    {



        if((isset($this->paramPOST))) {
            $result = $this->model->set(["table"=>"fichier_format","champs" => $this->paramPOST]);
            if($result !== false) Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
            else Utils::setMessageALert(["danger",$this->lang["actionechec"]]);
        }
        Utils::redirect("fichier", "formats/".base64_encode($this->paramPOST['fk_type_fichier']));
    }

    public function formatModal__()
    {
        if($this->paramGET[2]){
            $data['type'] = $this->model->getType(["condition"=>["rowid = "=>$this->paramGET[2]]])[0];
            $this->views->setData($data);
        }
        $this->modal();
    }

    public function infosfichierModal__()
    {
        $idTypeFichier = $this->paramGET[0];

        $param1 = $this->paramGET[1] ;
        $param2 = $this->paramGET[2] ;

        $this->paramGET[0] = $param1 ;
        $this->paramGET[1] = $param2 ;


        $Maxid = $this->model->get(["table"=>"fichier_format","champs"=>["Max(rowid) as maxid"], "condition"=>["fk_type_fichier= "=>$idTypeFichier]])[0]->maxid;

        $data['lastLine'] = $this->model->get(["table"=>"fichier_format","champs"=>["*"], "condition"=>["rowid= "=> $Maxid]])[0];

        $position = (isset($data['lastLine']->position)) ? (intval($data['lastLine']->position )+ 1) : 1 ;

        //$data['libelles'] = $this->model->get(["table"=>"colonne_fichier","champs"=>["rowid, libelle"], "condition"=>["rowid >="=>$position]]);
        $data['libelles'] = $this->model->get(["table"=>"colonne_fichier","champs"=>["rowid, libelle"]]);
        /*if($position > 2){
            $object = (object) ['rowid' => '2', 'libelle'=>'BLANC'];
           array_unshift($data['libelles'], $object);
        }*/

        $data['idFichier'] = $idTypeFichier ;

        $this->views->setData($data);
        $this->modal();
    }
        public function deleteFormat()
    {
        //parent::validateToken("exemples", "exemples");

        if(isset($this->paramGET[0])) {
            $param['condition'] = ["rowid = "=>$this->paramGET[0]];
            $result = $this->model->deleteType($param);
            if($result !== false) Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
            else Utils::setMessageALert(["danger",$this->lang["actionechec"]]);
        }
        Utils::redirect("fichier", "type");
    }



    public function modifFormat()
    {
        //parent::validateToken("exemples", "exemples");

        if((isset($this->paramPOST["libelle"])) && isset($this->paramPOST["extension"])) {
            $param['condition'] = ["rowid = "=>$this->paramPOST['rowid']];
            unset($this->paramPOST['rowid']);
            $param['champs'] = $this->paramPOST;
            $result = $this->model->updateType($param);
            if($result !== false) Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
            else Utils::setMessageALert(["danger",$this->lang["actionechec"]]);
        }
        Utils::redirect("fichier", "type");
    }



    public function deleteFormatDetails(){
        //parent::validateToken("exemples", "exemples");

        if(isset($this->paramGET[0])) {
            $param['condition'] = ["rowid = "=>$this->paramGET[0]];
            $file = $this->model->get(["table"=>"fichier_format","champs"=>["fk_type_fichier"], "condition"=>["rowid= "=> $this->paramGET[0]]])[0];

            $result = $this->model->deleteFormatDetails($param);
            if($result !== false) Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
            else Utils::setMessageALert(["danger",$this->lang["actionechec"]]);
        }
        Utils::redirect("fichier", "formats/".base64_encode($file->fk_type_fichier));
    }


    public function updateModificationFormat(){

        $fk_type_fichier = $this->paramPOST['idTypeFichier'] ;
        $id = $this->paramPOST['rowid'] ;
        //var_dump($id);exit;
        if((isset($this->paramPOST["position"]))) {
            $param = [] ;
           // $param['condition'] = ["rowid = "=>$this->paramPOST['rowid']];
            unset($this->paramPOST['rowid']);
            unset($this->paramPOST['idTypeFichier']);
            $params = $this->paramPOST;

            //var_dump($param);exit;
            //$result = $this->model->set(["table"=>"fichier_genere", "champs"=>['etat'=>$etat], "condition"=>["rowid =" => $id]]);
            $result = $this->model->set(["table"=>"fichier_format", "champs"=>$params,  "condition"=>["rowid =" => $id]]);
            if($result !== false)
                Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
            else
                Utils::setMessageALert(["danger",$this->lang["actionechec"]]);

            if($result !== false) Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
            else Utils::setMessageALert(["danger",$this->lang["actionechec"]]);
        }
        Utils::redirect("fichier", "formats/".base64_encode($fk_type_fichier));

    }

    public function modifinfosModal(){

        $data['colonne'] = $this->model->get(["table"=>"fichier_format","champs"=>["*"], "condition"=>["rowid = "=>$this->paramGET[2]]])[0];

        $data['libelles'] = $this->model->get(["table"=>"colonne_fichier","champs"=>["rowid, libelle"]]);

        $this->views->setData($data);
        $this->modal();

    }


    public function listeFormatProcessing__()
    {
        $param = [
            "button"=> [

                "modal" => [
                    ["fichier/modifinfosModal","fichier/modifinfosModal","fa fa-edit"]
                ],
                "default" => [
                    ["fichier/deleteFormatDetails/","fa fa-trash"]
                ],
                "custom" => []
            ],
            "tooltip"=> [
                "modal" => [
                    $this->lang["tooltipModif"]
                ],
                "default" => [
                    $this->lang["remove"], $this->lang["formats"]
                ]
            ],
            "classCss"=> [
                "modal" => [],
                "default" => ["confirm"]
            ],
            "attribut"=> [
                "modal" => [],
                "default" => []
            ],
            "args"=>$this->paramGET,
            "dataVal"=>[
                ["champ"=>"etat","val"=>["0"=>["<span style='.temp::before{text-align: right;}' class='temp text-danger'>". $this->lang['btn_desactiver'] ."</span>"],"1"=>["<span  class='temp text-success' >". $this->lang['btn_activer'] ."</span><style>.temp::before{text-align: right;}</style>"]]]
            ],
            "fonction"=>["type"=>"getType"]
        ];
        $this->processing($this->model, "getListeFormatProcess", $param);
    }




    public function type(){
        $this->views->getTemplate('fichier/listeType');
    }

    /**
     * @droit Ajouter module - 1
     */
    public function ajoutType()
    {
        //parent::validateToken("exemples", "exemples");
        //var_dump($this->paramPOST); exit;

        if((isset($this->paramPOST["fk_partenaire"])) && isset($this->paramPOST["extension"])) {
            $this->paramPOST["libelle"] = substr($this->paramPOST["extension"], 1);
            $result = $this->model->insertType(["champs"=>$this->paramPOST]);
            if($result !== false) Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
            else Utils::setMessageALert(["danger",$this->lang["actionechec"]]);
        }
        Utils::redirect("fichier", "type");
    }

    public function typeModal__()
    {
        $data['partenaires'] = $this->model->get(["table"=>"gestion_partenaire","champs"=>["id, nom , code"]]);

        if($this->paramGET[2]){
            $data['type'] = $this->model->getType(["champs"=>["*"],  "condition"=>["rowid = "=>$this->paramGET[2]]])[0];
            //var_dump($data['type']); exit;

        }
        $this->views->setData($data);
        $this->modal();
    }


    public function deleteType()
    {
        //parent::validateToken("exemples", "exemples");

        if(isset($this->paramGET[0])) {
            $param['condition'] = ["rowid = "=>$this->paramGET[0]];
            $result = $this->model->deleteType($param);
            if($result !== false) Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
            else Utils::setMessageALert(["danger",$this->lang["actionechec"]]);
        }
        Utils::redirect("fichier", "type");
    }


    /**
     * @droit Modifier module - 1
     */
    public function modifType()
    {
        //parent::validateToken("exemples", "exemples");

        if((isset($this->paramPOST["libelle"])) && isset($this->paramPOST["extension"])) {
            $param['condition'] = ["rowid = "=>$this->paramPOST['rowid']];
            unset($this->paramPOST['rowid']);
            $param['champs'] = $this->paramPOST;
            $result = $this->model->updateType($param);
            if($result !== false) Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
            else Utils::setMessageALert(["danger",$this->lang["actionechec"]]);
        }
        Utils::redirect("fichier", "type");
    }


    public function listeTypeProcessing__()
    {
        $param = [
            "button"=> [

                "modal" => [
                    ["fichier/typeModal","fichier/typeModal","fa fa-edit"]
                ],
                "default" => [
                    ["fichier/deleteType/","fa fa-trash"],
                    ["fichier/formats/","fa fa-search"]
                ],
                "custom" => []
            ],
            "tooltip"=> [
                "modal" => [
                    $this->lang["tooltipModif"]
                ],
                "default" => [
                    $this->lang["remove"], $this->lang["formats"]
                ]
            ],
            "classCss"=> [
                "modal" => [],
                "default" => ["confirm"]
            ],
            "attribut"=> [
                "modal" => [],
                "default" => []
            ],
            "args"=>null,
            "dataVal"=>[
                ["champ"=>"etat","val"=>["Désactiver"=>["<span style='.temp::before{text-align: right;}' class='temp text-danger'>". $this->lang['btn_desactiver'] ."</span>"],"Activer"=>["<span  class='temp text-success' >". $this->lang['btn_activer'] ."</span><style>.temp::before{text-align: right;}</style>"]]]
            ],
            "fonction"=>[]
        ];
        $this->processing($this->model, "getListeTypeProcess", $param);
    }


    public function modiflineModal__()
    {
        if($this->paramGET[2]){
            $line = $this->model->get(["table"=>"fichier_line_error","champs"=>["*"],"condition"=>["rowid =" => $this->paramGET[2]]])[0];

            $idTypeFile = $this->model->getIdTypeFichier($line->fk_fichier);
            $MATRICULE = '' ; $PRENOM = '' ; $NOM = '' ; $COMPTE = '' ;  $MONTANT = 0 ; $DATEPAIE = '' ; $ETAB=''; $MATR =''; $CATEG=''; $REG=''; $code_agence = '' ; $num_compte = '' ;
            $regles = $this->getReglesValidation($idTypeFile) ;
            foreach ($regles as $regle){
                ${$regle->libelle} = trim(substr($line->line_text,$regle->de - 1,$regle->longueur)) ;

                $data[$regle->libelle] = ${$regle->libelle} ;
            }
        }
        $data['idLine'] = $this->paramGET[2] ;
        $data['idFichier'] = $line->fk_fichier ;

        $this->views->setData($data);
        $this->modal();
    }

    public function updateline(){


        try{
            $this->model->beginTransaction() ;

            if(isset($this->paramPOST["matricule"])) {
                $matricule = $this->paramPOST["matricule"] ;
                $idLine = $this->paramPOST["idLine"] ;
                $line = $this->model->get(["table"=>"fichier_line_error","champs"=>["*"],"condition"=>["rowid =" => $idLine]])[0];
                $fichierGenerere = $this->model->get(["table"=>"fichier_genere","champs"=>["*"],"condition"=>["rowid =" => $this->paramPOST["idFichier"]]])[0];
               // var_dump($fichierGenerere);exit;

                $row = $this->model->get(["table"=>"dictionnaire_mat_compte_banque" , "champs"=>["count(rowid) as nombre, num_compte, code_agence"] , "condition" => ["matricule ="=>trim($matricule) ]])[0];

                if (intval($row->nombre) > 0){
                    $code_agence = $row->code_agence ;
                    $num_compte = substr($row->num_compte,5,12)  ;



                    $arraySuccess = [] ;
                    $arraySuccess['fk_fichier'] = $this->paramPOST["idFichier"] ;
                    $arraySuccess['matricule'] = $matricule ;
                    $arraySuccess['prenom'] = '' ;
                    $arraySuccess['nom'] = $this->paramPOST["nom"] ;
                    $arraySuccess['compte'] =  $num_compte ;
                    $arraySuccess['montant'] =$this->paramPOST["montant"] ;
                    $arraySuccess['line'] = $line->line ;
                    $arraySuccess['line_text'] = $line->line_text ;
                    $arraySuccess['code_agence'] = $code_agence ;
                    // var_dump($arraySuccess);exit;

                    $resultatInsertSuccess = $this->model->set(["table"=>"fichier_line_success","champs" => $arraySuccess]);
                    if (!($resultatInsertSuccess > 0))
                        throw new \Exception($this->lang["echec_add_element"].' table fichier_line_success, matricule:'.$matricule) ;


                    $param['condition'] = ["rowid = " => $this->paramPOST["idFichier"]];
                    $array['fk_type_fichier'] = 1;
                    $array['nb_succes'] =  $fichierGenerere->nb_succes + 1 ;
                    $array['montant'] = $fichierGenerere->montant + $this->paramPOST["montant"] ;
                    $param['champs'] = $array ;

                    $resultat = $this->model->updateFileGenered($param);
                    if (!($resultat > 0))
                        throw new \Exception('Exception: Update table fichier_genere') ;

                    $resultUpLine = $this->model->set(["table"=>"fichier_line_error", "champs"=>['etat'=>1], "condition"=>["rowid =" => $idLine]]);
                    if (!($resultUpLine > 0))
                        throw new \Exception('Exception: Update table fichier_line_erro') ;

                    $this->model->commit() ;

                }else
                    throw new \Exception("Cette matricule ne figure pas sur le dictionnaire");



            }


            Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
        }catch (\Exception $e){
            $this->model->rollBack() ;
            Utils::setMessageALert(["danger",$this->lang["actionechec"]." ".$e->getMessage()]);
        }
        Utils::redirect("fichier", "detailFichier/".base64_encode($this->paramPOST["idFichier"]));


    }


    public function listeLineErrorProcessing__()
    {
        $param = [
            "button"=> [

                "modal" => [
                    ["fichier/modiflineModal","fichier/modiflineModal","fa fa-edit"]
                ]
            ],
            "tooltip"=> [
                "modal" => [
                    $this->lang["tooltipModif"]
                ]
            ],
            "args"=>$this->paramGET
        ];
        $this->processing($this->model, "getLineErrorProcess", $param);

    }

    public function listeLineSuccesProcessing__()
    {
        $param = [
            "args"=>$this->paramGET
        ];
        $this->processing($this->model, "getLineSuccesProcess", $param);

    }

    public function createDir(){
        //var_dump(Utils::createDir('Fichiers')); exit;
    }

    public function validateFichier(){
        if(isset($this->paramGET[0])) {
            $etat = 1 ;
            $id = $this->paramGET[0] ;
            $result = $this->model->set(["table"=>"fichier_genere", "champs"=>['etat'=>$etat], "condition"=>["rowid =" => $id]]);
            if($result !== false)
                Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
            else
                Utils::setMessageALert(["danger",$this->lang["actionechec"]]);
        }
        Utils::redirect("fichier", "liste");
    }

    public function rejeterFichier(){
        if(isset($this->paramGET[0])) {
            $etat = 2 ;
            $id = $this->paramGET[0] ;
            $result = $this->model->set(["table"=>"fichier_genere", "champs"=>['etat'=>$etat], "condition"=>["rowid =" => $id]]);
            if($result !== false)
                Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
            else
                Utils::setMessageALert(["danger",$this->lang["actionechec"]]);
        }
        Utils::redirect("fichier", "liste");
    }

    public function detailFichier(){
        if(isset($this->paramGET[0])) {
            $data['fichier'] = $this->model->get(["table"=>"fichier_genere","champs"=>["*"],"condition" => ["rowid = " => $this->paramGET[0]]])[0];
            //var_dump($data['fichier']); exit;
            $this->views->setData($data);
        }else{
            Utils::setMessageALert(["danger",$this->lang["element_absent"]]);
        }
        $this->views->getTemplate('fichier/detailFichier');

    }

    public function exportRapport()
    {
        /*$id = $this->paramPOST['rowid'] ;
        $param['condition'] = ["v.rowid = "=>$id];
        $versement = $this->versement->getVersementById($param);
        $data['versement'] = $versement;

        $details = $this->versement->detailsVersements([0=>$id]);
        $data['details'] = $details ;

        $this->views->setData($data);
        if ($details && $versement ) {
            $this->views->exportToPdf('versement/printRecu');
        } else{
            Utils::setMessageALert(["danger",$this->lang["repech"]]);
            Utils::redirect("transaction", "liste");
        }*/
        $idAgence = $this->_USER->agence;
        $param = [
            "table"=>"agence a",
            "champs"=>["a.responsable", "a.code"],
            "condition"=>["a.rowid = " => $idAgence]
        ];
        $data['agence'] = $this->model->get($param)[0];
        $data['fichier'] = $this->model->get(["table"=>"fichier_genere","champs"=>["*"],"condition" => ["rowid = " => $this->paramPOST['rowid']]])[0];
        //var_dump($data['fichier']);exit;
        $this->views->setData($data);
        $this->views->exportToPdf('fichier/printRapport');

    }


    public function listeProcessing__()
    {
        $param = [
            "button"=> [
                "modal" => [],
                "default" => [
//                    ["fichier/deleteFichier/","fa fa-trash"],
                    ["champ"=>"etat",
                        "val"=>
                            ["0"=>  ["fichier/validateFichier/","fa fa-check-circle"]]
                    ],
                    ["champ"=>"etat",
                        "val"=>
                            ["0"=>  ["fichier/rejeterFichier/","fa fa-times-circle"]]
                    ],
                    ["champ"=>"etat",
                        "val"=>
                            [
                                "1"=>  ["fichier/rejeterFichier/","fa fa-times-circle"],
                                "2"=>  ["fichier/rejeterFichier/","fa fa-check-circle"]
                            ]
                    ],

                    ["fichier/detailFichier/","fa fa-search"],

                    ["champ"=>"etat",
                        "val"=>
                            //["1"=>  ["fichier/xslCheet/","fa fa-file-excel-o"]]
                            ["1"=>  ["fichier/editCheet/","fa fa-file-excel-o"]]
                    ]
                ],
                "custom" => []
            ],
            "tooltip"=> [
                "modal" => [
                    $this->lang["tooltipModif"]
                ],
                "default" => [
                   $this->lang["valide"],$this->lang["rejet"],$this->lang["rapport"],$this->lang["generer_excel"]
                ]
            ],
            "classCss"=> [
                "modal" => [],
                "default" => ["confirm","confirm"]
            ],
            "attribut"=> [
                "modal" => [],
                "default" => []
            ],
            "args"=>null,
            "dataVal"=>[
                ["champ"=>"etat","val"=>[
                    0=>["<span style='.temp::before{text-align: right;}' class='temp text-info'>". $this->lang['en_attente'] ."</span>"],
                    2=>["<span style='.temp::before{text-align: right;}' class='temp text-danger'>". $this->lang['rejet'] ."</span>"],
                    1=>["<span  class='temp text-success' >". $this->lang['valide'] ."</span><style>.temp::before{text-align: right;}</style>"]]]
            ],
            "fonction"=>[
                "date_creation"=>"getDateFR",
                "periode"=>"formaterPeriode",
                "libelle"=>"afficherLien/alldata",
                "nb_ligne"=>"alignCenter",
                "nb_error"=>"alignCenterDanger",
                "montant"=>"alignCenterMontantInfo"

            ]
        ];
        $this->processing($this->model, "getListeProcess", $param);
    }


    public function fichierexcelModal__()
    {
        $this->modal();
    }

    public function testCheet(){

        $spreadsheet = new Spreadsheet();
// Set document properties
        $spreadsheet->getProperties()->setCreator('PhpOffice')
            ->setLastModifiedBy('PhpOffice')
            ->setTitle('Office 2007 XLSX Test Document')
            ->setSubject('Office 2007 XLSX Test Document')
            ->setDescription('PhpOffice')
            ->setKeywords('PhpOffice')
            ->setCategory('PhpOffice');

// Add some data
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Hello')
            ->setCellValue('B2', 'Malick')
            ->setCellValue('C3', 'DIALLO');
// Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('URL Added');

        $spreadsheet->createSheet();

// Add some data
        $spreadsheet->setActiveSheetIndex(1)
            ->setCellValue('A1', 'world!')
            ->setCellValue('B1', 'world!');

// Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('URL Removed');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="01simple.xlsx"');
        header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
// If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }


    public function validerFichier()
    {

       $name = $this->paramFILE['file']['name'];
       $inputs =  file($this->paramFILE['file']['tmp_name']);
       //echo $name ; exit;
       echo '<pre>' ;
       $i= 1 ;
        foreach ($inputs as $rowIndex => $line) {
            if ($i > 5)
                break ;
            echo 'STLN:'.strlen($line);
            // Trim any unwanted leading whitespace, so the resulting array starts with a usable value.
            // preg_split() will split the line on whitespace, and return an array of all column values.
            $cols = preg_split('/[\s]+/', trim($line));

            var_dump($cols);

            // You can now read out the array of column values however you see fit.
           $i++ ;
        }
       var_dump($inputs); exit;

       exit;
    }

    /**
     * @droit Ajouter module - 1
     */
    public function ajoutModule()
    {
        //parent::validateToken("exemples", "exemples");

        if(isset($this->paramPOST["module"])) {
            $result = $this->model->insertModule(["champs"=>$this->paramPOST]);
            if($result !== false) Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
            else Utils::setMessageALert(["danger",$this->lang["actionechec"]]);
        }
        Utils::redirect("module", "liste");
    }

    /**
     * @droit Modifier module - 1
     */
    public function modifModule()
    {
        //parent::validateToken("exemples", "exemples");

        if(isset($this->paramPOST["module"])) {
            $param['condition'] = ["id = "=>$this->paramPOST['id']];
            $param['champs'] = ["module ="=>$this->paramPOST["module"]];
            $result = $this->model->updateModule($param);
            if($result !== false) Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
            else Utils::setMessageALert(["danger",$this->lang["actionechec"]]);
        }
        Utils::redirect("module", "liste");
    }

    /**
     * @droit Supprimer module - 1
     */
    public function deleteModule()
    {
        //parent::validateToken("exemples", "exemples");

        if(isset($this->paramGET[0])) {
            $param['condition'] = ["id = "=>$this->paramGET[0]];
            $result = $this->model->deleteModule($param);
            if($result !== false) Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
            else Utils::setMessageALert(["danger",$this->lang["actionechec"]]);
        }
        Utils::redirect("module", "liste");
    }
}