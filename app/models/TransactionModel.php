<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 27/02/2017
 * Time: 16:03
 */

namespace app\models;

use app\core\BaseModel;

class TransactionModel extends BaseModel
{

    /**
     * TransactionModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * TransactionModel destruct.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Processing transaction
     */
    public function getTransProcess($param)
    {


   // var_dump($param);exit;
        $cond = ["DATE(date_transac) >="=>$param[0], "DATE(date_transac) <="=>$param[1]];
        $this->table = "transaction";
        $this->champs = ["idtransaction as rowid","date_transac","num_transac","montant_ttc","code_client","numcompte_client","codeCollecteur","statut"];
        $this->condition = $cond ;
        return $this->__processing();
    }


    public function getLastTransaction(){
        $this->table = "transaction t";
        $this->champs = ['t.idtransaction as idf,u.prenom, u.nom, t.codeCollecteur,t.date_transac,t.codeCollecteur as code, t.longitude as longitude,t.latitude as latitudes'];
        $this->jointure = ["INNER JOIN meczy_user u ON u.id = t.idcollecteur"];
        $this->condition = ["t.idtransaction IN (SELECT MAX(u.idtransaction) FROM meczy_transaction u WHERE 1 = ?  GROUP BY u.idcollecteur )" ];
        $this->value = [1];
        return $this->__select1();
    }

    public function getLocProcess()
    {


        $this->table = "transaction t";
        $this->champs = ['t.idtransaction as idf,u.prenom, u.nom, t.codeCollecteur,t.date_transac,t.codeCollecteur as code, t.longitude as longitude,t.latitude as latitudes'];
        $this->jointure = ["INNER JOIN meczy_user u ON u.id = t.idcollecteur"];
        $this->condition = ["t.idtransaction IN (SELECT MAX(u.idtransaction) FROM meczy_transaction u WHERE 1 = ?  GROUP BY u.idcollecteur )" ];
        $this->value = [1];

        return $this->__processing();
    }
    public function getTransaction($param = null)
    {
        $this->table = "transaction";
        $this->__addParam($param);
        return $this->__select();
    }
    public function getCollectTransaction($param = null)
    {
        $this->table = "transaction t";
        //$this->champs = ['t.idcollecteur as id, t.codeCollecteur, t.date_transac, t.codeCollecteur as code, t.idcollecteur as Allcollecteur'];
        $this->__addParam($param);
        return $this->__select();
    }
    public function getMontantTTransaction($param = null)
    {
        $this->table = "transaction";
        $this->champs = ['sum(montant_ttc) as mnt'];
        $this->__addParam($param);
        return $this->__select();
    }

    public function TransactParMois($lemois)
    {
        $year = date('Y');
        $this->table = "transaction ";
        $this->champs = ['sum(montant_ttc) as mnt'];
        $this->condition = ["month(date_transac)="=>$lemois,"year(date_transac)="=>$year,"statut="=>1];
        return $this->__select();
    }


    public function TransactNbreParMois($lemois)
    {
        $year = date('Y');
        $this->table = "transaction ";
        $this->champs = ['count(idtransaction) as nbre'];
        $this->condition = ["month(date_transac)="=>$lemois,"year(date_transac)="=>$year,"statut="=>1];
        return $this->__select();
    }

/*
    public function TransactAgenceParJours()
    {
        $day = date('Y-m-d');
        $this->table    = "transaction t";
        $this->champs   = ["ag.code", "ag.label", "count(t.idtransaction) as nb"];
        $this->condition=["date(t.date_transac) ="=>$day];
        $this->jointure = ["INNER JOIN user u ON u.id = t.idcollecteur", "INNER JOIN agence ag ON u.agence = ag.rowid"];
        $this->group = ['ag.rowid'];
        return $this->__select();
    }*/

/****************** Transaction effectuées au niveau des TPEs durant l'année de gestion en cpurs*************/

    public function TransactAgenceAnnuelle()
    {
        $year = date('Y');
        $this->table    = "transaction t";
        $this->champs   = ["ag.code", "ag.label", "count(t.idtransaction) as nb"];
        $this->condition=["Year(t.date_transac) ="=>$year];
        $this->jointure = ["INNER JOIN user u ON u.id = t.idcollecteur", "INNER JOIN agence ag ON u.agence = ag.rowid"];
        $this->group = ['ag.rowid'];
        return $this->__select();
    }




     public function TransactNbreParService($lemois, $leServ)
        {
            $year = date('Y');
            $this->table = "transaction ";
            $this->champs = ['count(idtransaction) as nbre'];
            $this->condition = ["month(date_transac)="=>$lemois,"year(date_transac)="=>$year,"statut="=>1, "service="=>$leServ];
            return $this->__select();
        }


     public function getServicesReporting()
        {
            $this->table = "services ";
            $this->champs = ['rowid as data', 'libelle_service as name'];
            $this->condition = ["etat="=>1];
            $this->sort;
            return $this->__select();
        }

     public function getLeServices()
        {
            $this->table = "services ";
            $this->champs = ['libelle_service'];
            $this->condition = ["etat="=>1];
            $this->sort;
            return $this->__select();
        }

    ///////////////////////// ADD BY BALDE ////////////////////////


    public function TransactNbreParMoisGenre($lemois)
    {
        $year = date('Y');
        $this->table = "transaction ";
        $this->champs = ['count(idtransaction) as nbre', 'genre_client'];
        $this->condition = ["month(date_transac)="=>$lemois,"year(date_transac)="=>$year,"statut="=>1];
        $this->group = ['genre_client'];
        return $this->__select();
    }




    public function TransactNbreParTranch($lemois)
    {
        $year = date('Y');
        $this->table = "transaction ";
        $this->champs = ['count(idtransaction) as nbre'];
        //$this->condition = ["month(date_transac)="=>$lemois,"year(date_transac)="=>$year,"statut="=>1];
        $this->condition = ["((TIMESTAMPDIFF(YEAR, date_naissclient, CURDATE()) >=  ?) AND  (TIMESTAMPDIFF(YEAR, date_naissclient, CURDATE()) <=  ?))","year(date_transac)="=>$year,"statut="=>1];
        $this->value = [$lemois[0],$lemois[1]];
        return $this->__select();
    }

    /************************Nombre d'operation par mois ******************************/
    public function  operationByMonth($entite=[]){

        $this->table = "meczy_transaction as t";
        $this->champs = ['COUNT(t.num_transac) as nbre', 'month(t.date_transac) as lemois', 'SUM(t.montant_ttc) as mntMonth'];
        $this->condition = ["month(t.date_transac)="=>$entite[0], "YEAR(t.date_transac)="=>$entite[1]];
        return $this->__select();
    }

    ///////////////////////// END ADD BY BALDE ////////////////////

    public function updateTransaction($param)
    {
        $this->table = "transaction";
        $this->__addParam($param);
        return $this->__update();
    }

    public function insertLogsTans($param)
    {
        $this->table = "action_utilisateur";
        $array = ['date'=>$param[0], 'action'=>$param[1], 'fk_user'=>$param[2], 'commentaire'=>$param[3], 'fk_agence'=>$param[4]];
        $this->champs = $array;
        return $this->__insert();
    }

    public function getTansactionById($leId)
    {
        $this->table = "transaction t";
        $this->champs   = ["t.idtransaction", "t.num_transac", "t.codeCollecteur", "t.code_client", "t.numcompte_client", "t.montant", "t.date_transac", "u.nom", "u.prenom", "u.nom", "ag.label as agence"];
        $this->jointure = ["INNER JOIN user u ON u.id = t.idcollecteur", "INNER JOIN agence ag ON u.agence = ag.rowid"];
        $this->condition = ["t.idtransaction="=>$leId];
        return $this->__select()[0];
    }


    public function getTransactionMeczy($leNum)
    {
        $this->table = "transaction t";
        $this->champs   = ["t.num_transac", "t.TransactionMeczy"];
        $this->condition = ["t.TransactionMeczy="=>$leNum];
        return $this->__select()[0];
    }

}