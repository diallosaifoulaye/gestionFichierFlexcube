<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 27/02/2017
 * Time: 16:03
 */

namespace app\models;

use app\core\BaseModel;

class CarteModel extends BaseModel
{

    /**
     * HomeModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * HomeModel destruct.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    //-------------------------RECEPTION DE CARTE
    /************* verif Numero LOT **************/
    public function verifyNumLot($code,$champ,$table)
    {
        $this->table = $table;
        $this->condition=[$champ."="=>$code];
        $nb = count($this->__select());
        if($nb > 0) return 0;//bad
        else return 1;//ok
    }

    public function getReceptionProcess(){
        $this->table    = "lotcarte_reception ";
        $this->champs   = ["id","num_reference","date_reception","dateExp","num_debut","num_fin","stock_init","stock","flag AS _flag_"];
        return $this->__processing();
    }

    public function getOneReception($param = null)
    {
        $this->table = "lotcarte_reception";
        $this->__addParam($param);
        return $this->__select();
    }

    public function insertReception($param)
    {
        $this->table = "lotcarte_reception";
        $this->__addParam($param);
        return $this->__insert();
    }

    public function updateReception($param){
        $this->table = "lotcarte_reception";
        $this->__addParam($param);
        return $this->__update();
    }
    /************* verifier carte chevauchement **************/
    public function chevauchement_reception($serie_debut, $serie_fin)
    {
        $this->table        = "lotcarte_reception";
        $this->champs       = ["COUNT(id) AS nb_return"];
        $this->condition    = ["num_debut = ? OR num_fin = ? "];
        $this->value        = [$serie_debut, $serie_fin];
        $totalrows          = intval($this->__select()[0]->nb_return);

        $this->table        = "lotcarte_reception";
        $this->champs       = ["num_debut","num_fin"];
        $this->condition    = ["num_debut <= ? AND num_fin >= ?"];
        $this->value        = [$serie_debut,$serie_debut];
        $Rq_row_total_serie = count($this->__select());

        $this->table        = "lotcarte_reception";
        $this->champs       = ["num_debut","num_fin"];
        $this->condition    = ["num_debut <= ? AND num_fin >= ?"];
        $this->value        = [$serie_fin,$serie_fin];
        $Rq_row_total_serie1 = count($this->__select());

        if ($Rq_row_total_serie == 0 && $Rq_row_total_serie1 == 0 && $totalrows <= 0)
        {
            return 1;
           // return $Rq_row_total_serie.'   '.$Rq_row_total_serie1.'   '.$totalrows;
        }
        else
        {
            return -1;
           // return $Rq_row_total_serie.'   '.$Rq_row_total_serie1.'   '.$totalrows;
        }

    }


    //---------------------------DISTRIBUTION DE CARTE
    public function chevauchement_distribution($serie_debut, $serie_fin,$agence){

        $this->table        = "lotcarte";
        $this->champs       = ["COUNT(rowid) as nb_return"];
        $this->condition    = ["(num_debut = ? OR num_fin = ?) AND fk_agence_dest = ?"];
        $this->value        = [$serie_debut, $serie_fin, $agence];
        $totalrows          = intval($this->__select()[0]->nb_return);

        $this->table        = "lotcarte";
        $this->champs       = ["num_debut","num_fin"];
        $this->condition    = ["num_debut <= ? AND num_fin >= ? AND fk_agence_dest = ?"];
        $this->value        = [$serie_debut,$serie_debut, $agence];
        $Rq_row_total_serie = count($this->__select());

        $this->table        = "lotcarte";
        $this->champs       = ["num_debut","num_fin"];
        $this->condition    = ["num_debut <= ? AND num_fin >= ? AND fk_agence_dest = ?"];
        $this->value        = [$serie_fin,$serie_fin, $agence];
        $Rq_row_total_serie1 = count($this->__select());

        if ($Rq_row_total_serie == 0 && $Rq_row_total_serie1 == 0 && $totalrows <= 0)
        {
            return 1;
        }
        else
        {
            return -1;
        }

    }

    public function getDistributionProcess(){
        $this->table    = "lotcarte d";
        $this->champs   = ["d.id AS rowid","d.num_reference","d.date_distribution","a.label","d.num_debut","d.num_fin","d.stock"];
        $this->jointure = ["INNER JOIN agence a ON a.rowid = d.fk_agence_dest"];
        return $this->__processing();
    }

    public function insertDistribution($param)
    {

        $this->table = "lotcarte";
        $this->__addParam($param);
        return $this->__insert();
    }

    public function updateDistribution($param){
        $this->table = "lotcarte";
        $this->__addParam($param);
        return $this->__update();
    }

    public function getOneDistribution($param = null)
    {
        $this->table = "lotcarte";
        $this->__addParam($param);
        return $this->__select();
    }

    //------------------------ CARTE
    public function getDisponibiliteProcess($param)
    {
        if($param){
            $cond = ["d.fk_agence_dest ="=>$param[0]];
            $this->table    = "lotcarte d";
            $this->champs   = ["d.id","a.label","SUM(d.stock_init) AS stock_init","SUM(d.nbre_carte_vendue) AS vente", "SUM(d.stock) AS stock", "SUM(d.retour) AS retour", "d.fk_agence_dest"];
            $this->jointure = ["INNER JOIN agence a ON a.rowid = d.fk_agence_dest"];
            $this->condition = $cond ;
            return $this->__processing();
        }else{
            $this->table    = "lotcarte d";
            $this->champs   = ["d.id","a.label","SUM(d.stock_init) AS stock_init","SUM(d.nbre_carte_vendue) AS vente", "SUM(d.stock) AS stock", "SUM(d.retour) AS retour", "d.fk_agence_dest"];
            $this->jointure = ["INNER JOIN agence a ON a.rowid = d.fk_agence_dest"];
            $this->group = ["d.fk_agence_dest"];
            return $this->__processing();
        }

    }

    public function getCarteProcess()
    {
        $etat ="Enroler";
        $this->table    = "carte c";
        $this->champs   = ["c.id","c.nom_complet_client","c.telephone","c.numero","c.date_expiration"];
        $this->condition=["etat="=>$etat];
        //$this->jointure = ["INNER JOIN user u ON u.id=c.user_crea"];
        return $this->__processing();
    }

    public function getDetailCarte($id)
    {

        $this->table    = "carte c";
        $this->champs   = ["c.id","c.nom_complet_client","c.telephone","c.numero","c.numero_serie","c.fk_agence","a.label","c.email","c.code_client"];
        $this->condition=["id="=>$id];
        $this->jointure = ["INNER JOIN agence a ON a.rowid = c.fk_agence"];
        return $this->__select();
    }
    public function getCarteClientProcess()
    {
        $etat = "Activer";
        $etat2 = "Désactiver";
        $this->table    = "carte c";
        $this->champs   = ["c.id","c.nom_complet_client","c.telephone","c.numero","c.date_expiration","c.etat"];
        $this->condition    = ["etat = ? OR etat = ?" ];
        $this->value =[$etat,$etat2];
        return $this->__processing();
    }

    //region Edited by YETE A. Abigail
    public function insertCarte($param)
    {
        $nombre=$this->CarteExiste($param['champs']['numero']);
        if($nombre > 0){
            return -1;
        }
        if($nombre == 0)
        {
            $this->table = "lotcarte";
            $this->champs = ["stock = stock -" => 1];
            $this->condition=["fk_agence_dest = ?  AND (CAST(num_debut AS SIGNED INTEGER ) <=  ? AND CAST(num_fin AS SIGNED INTEGER ) >= ?)"];
            $this->value=[$param['champs']['fk_agence'],$param['champs']['numero_serie'],$param['champs']['numero_serie']];
            $resultupdate=$this->__update();
//var_dump($resultupdate);exit;

            if ($resultupdate !== false) {

                $this->table = "carte";
                $this->__addParam($param);
                $resultinsert=$this->__insert();

                if($resultinsert == false) {
                    return -3;
                }
                else {
                    return 1;
                }
            }
            else {
                return -2;
            }
        }

    }

    public function CarteExiste($num)
    {
        $this->table = "carte";
        $this->champs   = ["numero"];
        $this->condition=["numero="=>$num];
        return count($this->__select());
    }



    /**
     * @param null $param
     * @return array|bool
     */
    public function getCarte($param = null)
    {
        $this->table = "carte";
        $this->__addParam($param);
        return $this->__select();
    }
    //endregion

    //------------------------ RETOUR LOT CARTE
    public function agenceWithLot(){
        $this->table = "agence a";
        $this->champs   = ["DISTINCT (a.rowid)","a.label"];
        $this->jointure = ["INNER JOIN lotcarte lc ON lc.fk_agence_dest = a.rowid"];
        $this->condition = ["a.etat = " => "Activer"];
        return $this->__select();
    }

    public function getLotByAgence($params)
    {
        $this->table = "lotcarte";
        $this->champs   = ["*"];
        $this->condition = ["fk_agence_dest = " => $params];
        return $this->__select();
    }

    public function getLotRetourner($params)
    {
        $this->table = "lotcarte";
        $this->champs   = ["*"];
        $this->condition = ["stock = " => $params];
        return $this->__select();
    }

    public function getCartesSaleByIntevale($data)
    {
        $data['idagence']=intval($data['idagence']);
        $data['debut']=intval($data['debut']);
        $data['fin']=intval($data['fin']);
       // return $data;
        /*$this->requete = "select numero_serie FROM meczy_carte WHERE fk_agence = ? AND (CAST(numero_serie AS SIGNED INTEGER ) BETWEEN ? AND ?) ORDER BY numero_serie ASC";
        $this->value   = [$data['idagence'],$data['debut'],$data['fin']];
        $thedata       = $this->__execute();
        return $thedata;*/

        $this->table = "carte";
        $this->champs   = ["numero_serie"];
        $this->condition = ["fk_agence = ? AND (CAST(numero_serie AS SIGNED INTEGER) BETWEEN ? AND ?)"];
        $this->value = [$data['idagence'],$data['debut'],$data['fin']];
        $rst= $this->__select();

        $result = [];

        //foreach ($rst as $item) array_push($result,str_pad((intval($item['numero_serie'])), 10, "0", STR_PAD_LEFT));
        foreach ($rst as $item) array_push($result,intval($item->numero_serie));

        $data = $this->getLotReception($data['debut'],$data['fin'],$data['idagence']);
        if(count($result) > 0){

            foreach ($data as $item) {
                for($i = 0 ; $i < intval($item->stock_init) ; $i++)
                    //array_push($result,str_pad((intval($item['num_debut']) + $i), 10, "0", STR_PAD_LEFT));
                    array_push($result,intval($item->num_debut) + $i);
            }
        }
        return $result;
    }

    public function getLotReception($data1,$data2,$data3)
    {
        $this->table = "lotcarte_reception";
        $this->champs = ["id","num_reference","date_reception","num_debut","num_fin","stock_init","stock"];
        $this->condition = ["stock > ? AND agence_retour = ? AND (CAST(num_debut AS SIGNED INTEGER ) >= ? AND CAST(num_fin AS SIGNED INTEGER ) <= ?)"];
        $this->value = [0,$data3,$data1,$data2];
        return $this->__select();
    }

    public function updateLotCarte($stock,$id){


        $this->table = "lotcarte";
        $this->champs = ["stock = stock -"=>intval($stock)];
        $this->condition=["id =" =>intval($id)];

        return $this->__update();
    }

    public function updateStockCarte($num_serie,$statut)
    {


        $this->table = "stockCartes";
        $this->champs = ["statut ="=> $statut,"fk_agence ="=>0];
        $this->condition=["numseriecarte = ?"];
        $this->value = [$num_serie];
        return $this->__update();
    }

    public function updateStockCarteBis($num_serie,$a)
    {
        $etat= 1;
        $this->table = "stockCartes";
        $this->champs = ["statut ="=> $etat,"fk_agence ="=>$a];
        $this->condition=["numseriecarte = "=>$num_serie];

        return $this->__update();
    }
    public function insertCarteRetourne($param)
    {
        $this->table = "lotcarte_retour";
        $this->__addParam($param);
        return $this->__insert();
    }

    public function getCarteRetournes()
    {
        $etat = 1;
        $this->table    = "lotcarte_retour d";
        $this->champs   = ["d.id AS rowid","d.num_reference","d.date_retour","a.label","d.num_debut","d.num_fin","d.stock","m.libellemotif"];
        $this->condition = ["statut ="=> $etat];
        $this->jointure = ["INNER JOIN agence a ON a.rowid = d.fk_agence_dest","INNER JOIN motifs m ON m.rowid = d.idmotif"];

        return $this->__processing();
    }
    public function getLotCarteRetourner($numSeriedebut,$numserieFin,$quantite)
    {
        $this->table = "lotcarte ";
        $this->champs = ["lotcarte.id","lotcarte.fk_lot_origine","agence.label","agence.rowid","lotcarte.num_reference","lotcarte.stock"];
        $this->jointure = ["INNER JOIN agence ON  agence.rowid = lotcarte.fk_agence_dest"];
        $this->condition = ["meczy_lotcarte.num_debut  <= ? AND meczy_lotcarte.num_fin   >= ? AND meczy_lotcarte.stock >= ? "];
        $this->value = [$numSeriedebut,$numserieFin,$quantite];
        return $this->__detail();
    }
    public function getMotif()
    {
        $etat = 1;
        $this->table = "motifs ";
        $this->champs = ["*"];
        $this->condition = ["etat = ?"];
        $this->value = [$etat];
        return $this->__select();

    }


    public function getStockRecu($param = null)
    {
        $this->table = "lotcarte_reception ";
        $this->champs = ["stock_init as nbre"];
        $this->condition = ["id = ?"];
        $this->value = [$param];

        return $this->__select();
    }

    public function getStockRestant($param = null)
    {
        $this->table = "lotcarte_reception ";
        $this->champs = ["stock as nbre"];
        $this->condition = ["id = ?"];
        $this->value = [$param];

        return $this->__select();
    }


    public function getStockInitial($param = null)
    {
        $this->table = "stockCartes ";
        $this->champs = ["count(fk_lotreception) as nbre"];
        $this->condition = ["fk_lotreception = ?"];
        $this->value = [$param];

        return $this->__select();
    }


    public function getEnstock($param)
    {
        $etat = 0;
        $this->table = "stockCartes ";
        $this->champs = ["count(fk_lotreception) as nbre"];
        $this->condition = ["fk_lotreception = ? AND statut = ? "];
        $this->value = [$param,$etat];

        return $this->__select();
    }
    public function getDistribue($param )
    {
        $etat = 1;
        $this->table = "stockCartes ";
        $this->champs = ["count(fk_lotreception) as nbre"];
        $this->condition = ["fk_lotreception = ? AND statut = ? "];
        $this->value = [$param,$etat];

        return $this->__select();
    }

    public function getVendu($param )
    {
        $etat = 2;
        $this->table = "stockCartes ";
        $this->champs = ["count(fk_lotreception) as nbre"];
        $this->condition = ["fk_lotreception = ? AND statut = ?"];
        $this->value = [$param,$etat];

        return $this->__select();
    }
    public function getEndommages($param )
    {
        $etat = 4;
        $this->table = "stockCartes ";
        $this->champs = ["count(fk_lotreception) as nbre"];
        $this->condition = ["fk_lotreception = ? AND statut = ? "];
        $this->value = [$param,$etat];

        return $this->__select();
    }

    public function getEnrolle($param )
    {
        $etat = 5;
        $this->table = "stockCartes ";
        $this->champs = ["count(fk_lotreception) as nbre"];
        $this->condition = ["fk_lotreception = ? AND statut = ? "];
        $this->value = [$param,$etat];

        return $this->__select();
    }


    public function getEmbosse($param)
    {
        $etat = 6;
        $this->table = "stockCartes ";
        $this->champs = ["count(fk_lotreception) as nbre"];
        $this->condition = ["fk_lotreception = ? AND statut = ? "];
        $this->value = [$param,$etat];

        return $this->__select();
    }

    public function nombreCarteStock(){
        $fk_lot = 0;
        $this->table = "lotcarte_reception ";
        $this->champs = ["max(id) as nbre"];
        $releve = $this->__select();
        $fk_lot  = $releve[0]->nbre + 1 ;
        return $fk_lot;

    }

    public function DebutCarteStock($debut){
        //var_dump($debut);die;

        $this->table = "stockCartes ";
        $this->champs = ["MIN(numseriecarte) as num_debut, MAX(numseriecarte) as num_fin"];
        $this->condition = ["fk_lotreception ="=>$debut];
        return $this->__select();

    }
    public function FinCarteStock($fin){

        $this->table = "stockCartes ";
        $this->champs = ["MAX(numseriecarte) as num_fin"];
        $this->condition = ["fk_lotreception = ?"];
        $this->value = [$fin];
        return $this->__select();

    }
    public function insertCarteStock($number_card,$date_expire,$num_serie,$code_bar,$fk_lot,$date_reception)
    //public function insertCarteStock($param)

    {
       //echo"<pre>"; var_dump($param);die;


        $this->table = "stockCartes";
        $this->champs = [
            "numseriecarte"=>$num_serie,
            "numcarte"=>$number_card ,
            "dateExp"=>$date_expire,
            "code_bar"=>$code_bar,
            "fk_lotreception"=>$fk_lot,
            "date_reception"=>$date_reception,
            "id_user"=>$this->_USER->id
        ];

        return parent::__insert();


    }

    public function insertReceptionCarte($stock,$num_debut,$num_fin,$ref,$date_expire,$date_reception)

    {

        $this->table = "lotcarte_reception";
        $this->champs = [
            "stock_init"=>$stock,
            "num_debut"=>$num_debut ,
            "num_fin"=>$num_fin,
            "num_reference"=>$ref,
            "dateExp"=>$date_expire,
            "date_reception"=>$date_reception,
            "stock"=>$stock,


        ];

        return parent::__insert();


    }

    public function updateStocks($num_serie)
    {
        $etat = 6;


        $this->table = "stockCartes";
        $this->champs = ["statut ="=> $etat];
        $this->condition=["numseriecarte ="=>$num_serie];
        return $this->__update();
    }

    public function updateEtatCarte($num_serie)
    {
        $etat ="Activer";

        $this->table = "carte";
        $this->champs = ["etat ="=> $etat];
        $this->condition=["numero_serie ="=>$num_serie];
        return $this->__update();
    }

    public function updateStockLotCarte($stock,$id)
    {

        $this->table = "lotcarte";
        $this->champs = ["stock_init = stock_init +"=>intval($stock)];
        $this->condition=["id =" =>intval($id)];

        return $this->__update();
    }

    public function updateStockReception($stock,$fk_lot)
    {

        $this->table = "lotcarte_reception";
        $this->champs = ["stock = stock +"=>intval($stock)];
        $this->condition=["id =" =>intval($fk_lot)];

        return $this->__update();
    }

    public function getDistributionLotCarte($id)
    {
        $this->table    = "lotcarte_retour d";
        $this->champs   = ["d.id AS rowid","d.num_reference","d.date_retour","a.label","d.num_debut","d.num_fin","d.stock","m.libellemotif","d.fk_lot_origine","d.fk_agence_dest","d.fk_lot_origine"];
        $this->condition=["id =" =>intval($id)];
        $this->jointure = ["INNER JOIN agence a ON a.rowid = d.fk_agence_dest","INNER JOIN motifs m ON m.rowid = d.idmotif"];

        return $this->__select();
    }

    public function updateStatutRetourCarte($id)
    {
        $etat =0;

        $this->table = "lotcarte_retour";
        $this->champs = ["statut = "=>$etat];
        $this->condition=["id =" =>$id];

        return $this->__update();
    }

    public function getDateExp($numdeb,$numfin)
    {
        $this->table = "lotcarte_reception";
        $this->champs = ["dateExp"];
        $this->condition=["num_debut >= ? AND num_debut <= ?"];
        $this->value=[$numdeb,$numfin];
        return $this->__detail()->dateExp;
    }

    public function updateStockCarteTer($num_serie,$lot)
    {
        $this->table = "stockCartes";
        $this->champs = ["fk_lotreception ="=> $lot];
        $this->condition=["numseriecarte = "=>$num_serie];
        $this->__update();
    }

    public function updateVenteCarte($num_serie,$agence)
    {
        $this->table = "lotcarte";
        $this->champs = ["nbre_carte_vendue = nbre_carte_vendue + "=>1,"stock = stock - "=>1];
        $this->condition=["num_debut <= ? AND num_fin >= ? AND fk_agence_dest = ?"];
        $this->value=[$num_serie,$num_serie,$agence];
        $this->__update();
    }

    public function updateVenteRetour($num_serie)
    {
        $this->table = "lotcarte";
        $this->champs = ["retour = retour + "=>1];
        $this->condition=["num_debut <= ? AND num_fin >= ?"];
        $this->value=[$num_serie,$num_serie];
        $this->__update();
    }

    public function getAgences(){
        $this->table    = "agence";
        $this->champs   = ["rowid","label"];
        return $this->__select();
    }


}