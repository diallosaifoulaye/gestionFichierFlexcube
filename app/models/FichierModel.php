<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 27/02/2017
 * Time: 16:03
 */

namespace app\models;

use app\core\BaseModel;

class FichierModel extends BaseModel
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

    public function getLastRow($idTypeFichier){
        $this->table = "fichier_format";
        $this->champs = ["*"];
        $this->condition = ["fk_type_fichier = "=>$idTypeFichier] ;

        return $this->__select();
    }

    /**
     * @param $param
     * @return bool|mixed
     */
    public function insertType($param)
    {
        $this->table = "fichier_type";
        $this->__addParam($param);
        return $this->__insert();
    }

    public function insertFileGenered($param)
    {
        $this->table = "fichier_genere";
        $this->__addParam($param);
        return $this->__insert();
    }

    public function updateFileGenered($param)
    {
        $this->table = "fichier_genere";
        $this->__addParam($param);
        return $this->__update();
    }


    /**
     * Processing module
     */
    public function getListeTypeProcess()
    {
        $this->table = "fichier_type t";
        $this->champs = ["t.rowid","p.nom","t.extension"];
        $this->jointure = ["INNER JOIN gestion_partenaire p ON p.id = t.fk_partenaire"];
        return $this->__processing();
    }

    public function getIdTypeFichier($idFichier)
    {
        $this->table = "fichier_genere fg";
        $this->champs = ["f.rowid"];
        $this->jointure = ["INNER JOIN fichier_type f ON f.fk_partenaire = fg.fk_partenaire"];
        $this->condition = ["fg.rowid = "=>$idFichier] ;
        return $this->__select()[0]->rowid;
    }



    public function getListeProcess()
    {
        $this->table = "fichier_genere";
        $this->champs = ["rowid","date_creation","libelle","periode","nb_ligne","(nb_ligne - nb_succes) as nb_error","montant","etat","lien as _lien_"];
        $this->condition = ["fk_type_fichier = "=> 1];
        return $this->__processing();
    }

    public function getListeExcelProcess()
    {
        $this->table = "fichier_genere";
        $this->champs = ["rowid","date_creation","libelle","periode","nb_ligne","(nb_ligne - nb_succes) as nb_error","montant","etat","nom_sequentiel as _lien_"];
        $this->condition = ["fk_type_fichier = "=> 2];
        return $this->__processing();
    }


    public function getLineErrorProcess($param)
    {
        $id = intval($param[0]);
        $this->table = "fichier_line_error";
        $this->champs = ["rowid","line","line_text","commentaire"];
        if ($id > 0)
            $this->condition = ["fk_fichier = "=> $id, "etat = "=>0];
        return $this->__processing();
    }

    public function getLineSuccesProcess($param)
    {
        $id = intval($param[0]);
        $this->table = "fichier_line_success";
        $this->champs = ["rowid","line","line_text"];
        if ($id > 0)
            $this->condition = ["fk_fichier = "=> $id];
        return $this->__processing();
    }

    public function getLineSuccess($idLine)
    {
        $id = intval($idLine);
        $this->table = "fichier_line_success";
        $this->champs = ["*"];
        if ($id > 0)
            $this->condition = ["fk_fichier = "=> $id];
        return $this->__select();
    }

    public function getLinesExcelSuccess($idFichier)
    {
        $id = intval($idFichier);
        $this->table = "fichier_excel_detail";
        $this->champs = ["*"];
        if ($id > 0)
            $this->condition = ["fk_rowid_fichier = "=> $idFichier , "etat =" => 1];
        return $this->__select();
    }

    public function getListeFormatProcess($param)
    {
        $id = intval($param[0]);
        $this->table = "fichier_format";
        $this->champs = ["rowid","position","libelle","type","longueur","de","a","commentaire", "etat"];
        if ($id > 0)
            $this->condition = ["fk_type_fichier = "=> $id];
        return $this->__processing();
    }

    /**
     * @param null $param
     * @return array|bool
     */
    public function getType($param = null)
    {
        $this->table = "fichier_type";
        $this->__addParam($param);
        return $this->__select();
    }


    /**
     * @param $param
     * @return bool|mixed
     */
    public function updateType($param)
    {
        $this->table = "fichier_type";
        $this->__addParam($param);
        return $this->__update();
    }

    /**
     * @param $param
     * @return null|string
     */
    public function deleteType($param)
    {
        $this->table = "fichier_type";
        $this->__addParam($param);
        return $this->__delete();
    }


    public function deleteFormatDetails($param)
    {
        $this->table = "fichier_format";
        $this->__addParam($param);
        return $this->__delete();
    }


}