<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 17/08/2017
 * Time: 11:01
 */

namespace app\core;

use app\common\CommonModel;

abstract class BaseModel
{
    private   $dbConfig  = null;
    private   $connexion = null;
    protected $appConfig = null;
    protected $_USER     = null;
    protected $table     = null;
    protected $requete   = null;
    protected $db_prefix = null;
    protected $jointure  = [];
    protected $champs    = [];
    protected $value     = [];
    protected $condition = [];
    protected $filter    = [];
    protected $sort      = [];
    protected $limit     = [];
    protected $group     = [];

    protected function __construct()
    {
        try {
            if ($this->connexion === null) {
                $this->appConfig = (object)\parse_ini_file(ROOT . 'config/app.config.ini');
                $this->dbConfig = (object)\parse_ini_file(ROOT . 'config/db.config.ini');
                $this->_USER = (Session::existeAttribut(SESSIONNAME)) ? Session::getAttributArray(SESSIONNAME)[0] : null;
                $dsn = $this->dbConfig->DB_TYPE . ':dbname=' . $this->dbConfig->DB_NAME . ';host=' . $this->dbConfig->DB_HOST;
                $this->db_prefix = (isset($this->dbConfig->DB_PREFIX)) ? $this->dbConfig->DB_PREFIX : "";

                $this->connexion = new \PDO($dsn, $this->dbConfig->DB_USER, $this->dbConfig->DB_PASSWORD, [\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]);
                $this->connexion->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            }
        } catch (\PDOException $ex) {
//            Utils::setMessageError(['500',$ex->getMessage()]);
//            Utils::redirect("error","error");
//            exit();
            Utils::setMessageError(["sql","<div class='text-center'>Erreur de connexion à la base de donnée ! Error : ".$ex->getMessage()." <br/>".$ex->getFile()." - ".$ex->getLine()."</div>"]);
        }
    }

    public function getConnection(){
        if ($this->connexion !=  null)
            return $this->connexion ;
        else return null ;
    }


    protected function __select1($return = 'object')
    {
        $requete = null;
        if (!\is_null($this->table)) {
            $requete = "SELECT * ";

            if (count($this->champs) > 0) $requete = "SELECT " . implode(",", $this->champs);

            $requete .= " FROM " . $this->db_prefix . $this->table." ";

            if (count($this->jointure) > 0) $requete .= implode(" ", $this->jointure)." ";

            if (count($this->condition) > 0) {
                if(count($this->value) == 0){
                    $this->value = array_values($this->condition);
                    $this->condition = array_map(function($one){return $one = $one. ' ?';},array_keys($this->condition));
                }
                $requete .= " WHERE " .implode(" AND ", $this->condition);
            }

            if (count($this->group) > 0)
                $requete .= " GROUP BY ".implode(", ", $this->group);

            if (count($this->sort) > 0)
                $requete .= (count($this->sort) === 1) ? " ORDER BY ".$this->sort[0]." ASC" : " ORDER BY ".$this->sort[0]." ".$this->sort[1];

            if (count($this->limit) > 0)
                $requete .= (count($this->limit) === 1) ? " LIMIT 0, ".$this->limit[0] : " LIMIT ".$this->limit[0]." ,".$this->limit[1];
        }
//echo $requete ;
        if (!\is_null($requete)) {
            try {
                $resultat = $this->connexion->prepare($requete);
                $resultat->execute($this->value);
                $this->__reset();
                return ($return == 'array') ? $resultat->fetchAll(\PDO::FETCH_ASSOC) : $resultat->fetchAll(\PDO::FETCH_OBJ);
            } catch (\PDOException $ex) {
                if($this->throw === true) throw $ex;
                else{
                    Utils::setMessageError(['sql',$requete." ** ".implode("; ",$this->value)." ** ".$ex->getMessage()."<br/>".$ex->getTrace()[2]['file']." - ".$ex->getTrace()[2]['line']."<br/>".$ex->getTrace()[1]['file']." - ".$ex->getTrace()[1]['line']]);
                    $this->__reset();
                    return false;
                }
            }
        }
        $this->__reset();
        return false;
    }


    /**
     * Detruit la connexion à la BD
     */
    protected function __destruct()
    {
        $this->connexion = null;
        $this->__reset();
    }

    private function setPrefix($method)
    {
        if($this->db_prefix !== ''){
            $this->table = implode(" ", array_map(function ($one){return $this->db_prefix.$one; }, Utils::setPurgeArray(explode(" ", $this->table))));

            if($method != "select") {
                foreach ($this->champs as $key => $value) {
                    if(count(explode(".", $key)) == 2) {
                        $this->champs[$this->db_prefix.$key] = $value;
                        unset($this->condition[$key]);
                    }
                }
            }
            else {
                foreach ($this->champs as $key => $value) {
                    $temp = explode(".", $value);
                    if (count($temp) > 1) {
                        for($i = 0 ; $i < (count($temp) - 1) ; $i++) {
                            if(count(explode("(", $temp[$i])) > 1) {
                                $item = explode("(", $temp[$i]);
                                $item[(count($item)-1)] = $this->db_prefix.$item[(count($item)-1)];
                                $item = implode("(", $item);
                                $temp[$i] = $item;
                            }else $temp[$i] = $this->db_prefix.$temp[$i];
                        }
                        $this->champs[$key] = implode(".", $temp);
                    }
                }
            }

            if (count($this->jointure) > 0) {
                $this->jointure = array_map(function ($oneJoin){return Utils::setPurgeArray(explode(" ", $oneJoin));}, $this->jointure);
                $temp = ["inner", "left", "right", "join", "outer"];
                foreach ($this->jointure as $keyJoin => $jointure) {
                    $jointure = array_values($jointure);
                    foreach ($jointure as $key => $one) {
                        if(!in_array(strtolower($one), $temp)) {
                            $jointure[$key] = $this->db_prefix.$one;
                            if(strtolower($jointure[($key + 1)]) != "on") $jointure[($key + 1)] = $this->db_prefix.$jointure[($key + 1)];
                            $jointure[(count($jointure) - 1)] = $this->db_prefix.$jointure[(count($jointure) - 1)];
                            $jointure[(count($jointure) - 3)] = $this->db_prefix.$jointure[(count($jointure) - 3)];
                            $this->jointure[$keyJoin] = implode(" ", $jointure);
                            break;
                        }
                    }
                }
            }

            if (count($this->condition) > 0) {
                foreach ($this->condition as $key => $value) {
                    $temp = explode(".", $key);
                    if (count($temp) > 1) {
                        for($i = 0 ; $i < (count($temp) - 1) ; $i++) {
                            if(count(explode("(", $temp[$i])) > 1) {
                                $item = explode("(", $temp[$i]);
                                $item[(count($item)-1)] = $this->db_prefix.$item[(count($item)-1)];
                                $item = implode("(", $item);
                                $temp[$i] = $item;
                            }else $temp[$i] = $this->db_prefix.$temp[$i];
                        }
                        $this->condition[implode(".", $temp)] = $value;
                        unset($this->condition[$key]);
                    }
                }
            }

            if (count($this->group) > 0){
                $this->group = array_map(function($one) {
                    //$one = explode(".", $one);
                    return (count(explode(".", $one)) == 2) ? $this->db_prefix.implode(".", $one) : $one;
                },$this->group);
            }

            if (count($this->sort) > 0){
                $temp = explode(".", $this->sort[0]);
                if(count($temp) == 2) $this->sort[0] = $this->db_prefix.$this->sort[0];
            }
        }

    }

    /**
     * @param string $return
     * @return array|bool
     */
    protected function __select($return = 'object')
    {
        if (!\is_null($this->table)) {

            $this->setPrefix("select");

            $this->requete = "SELECT * ";

            if (count($this->champs) > 0) $this->requete = "SELECT " . implode(",", $this->champs);

            $this->requete .= " FROM " . $this->table . " ";

            if (count($this->jointure) > 0) $this->requete .= implode(" ", $this->jointure)." ";

            if (count($this->condition) > 0) {
                if(count($this->value) == 0){
                    $this->value = array_values($this->condition);
                    $this->condition = array_map(function($one){return $one = $one. ' ?';},array_keys($this->condition));
                }
                $this->requete .= " WHERE " .implode(" AND ", $this->condition);
            }

            if (count($this->group) > 0) $this->requete .= " GROUP BY ".implode(", ", $this->group);

            if (count($this->sort) > 0)
                $this->requete .= (count($this->sort) === 1) ? " ORDER BY ".$this->sort[0]." ASC" : " ORDER BY ".$this->sort[0]." ".$this->sort[1];

            if (count($this->limit) > 0)
                $this->requete .= (count($this->limit) === 1) ? " LIMIT 0, ".$this->limit[0] : " LIMIT ".$this->limit[0]." ,".$this->limit[1];
        }
        //echo $this->requete ;

        if (!\is_null($this->requete)) {
            try {
                $resultat = $this->connexion->prepare($this->requete);
                $resultat->execute($this->value);
                $this->__reset();
                return ($return == 'array') ? $resultat->fetchAll(\PDO::FETCH_ASSOC) : $resultat->fetchAll(\PDO::FETCH_OBJ);
            } catch (\PDOException $ex) {
                Utils::setMessageError(['sql',$this->requete." ** ".implode("; ",$this->value)." ** ".$ex->getMessage()."<br/>".$ex->getTrace()[2]['file']." - ".$ex->getTrace()[2]['line']."<br/>".$ex->getTrace()[1]['file']." - ".$ex->getTrace()[1]['line']]);
                $this->__reset();
                return false;
            }
        }
        $this->__reset();
        return false;
    }

    protected function __execute()
    {
        if (!\is_null($this->requete)) {
            try {
                $resultat = $this->connexion->prepare($this->requete);
                $rst = $resultat->execute($this->value);

                if(Utils::startsWith(strtolower($this->requete), "select"))
                    $rst = $resultat->fetchAll(\PDO::FETCH_OBJ);
                elseif (Utils::startsWith(strtolower($this->requete), "insert"))
                    $rst = ($rst == true) ? $this->connexion->lastInsertId() : $rst;

                $this->__reset();
                return $rst;
            } catch (\PDOException $ex) {
                Utils::setMessageError(['sql',$this->requete." ** ".implode("; ",$this->value)." ** ".$ex->getMessage()."<br/>".$ex->getTrace()[2]['file']." - ".$ex->getTrace()[2]['line']."<br/>".$ex->getTrace()[1]['file']." - ".$ex->getTrace()[1]['line']]);
                $this->__reset();
                return false;
            }
        }
        $this->__reset();
        return false;
    }

    /**
     * @param string $return
     * @return bool|mixed
     */
    protected function __detail($return = 'object')
    {
        $result = $this->__select($return);
        return (count($result) == 1) ? $result[0] : false;
    }

    /**
     * @return bool|mixed
     */
    protected function __insert()
    {
        if (!\is_null($this->table) && \count($this->champs) > 0) {

            $this->setPrefix("insert");

            if($this->table !== "logs") {
                //var_dump(array_keys($this->champs));
                //var_dump($this->champs);
                $description = "champ : [ ".implode(" ** ",array_keys($this->champs))." ] valeur : [ ";
                $description .= implode(" ** ",$this->champs)." ]";

            }

            $this->value = array_values($this->champs);
            $this->champs = array_keys($this->champs);
            $this->requete = "INSERT INTO " . $this->table . " (" . implode(',', $this->champs) . ") VALUES (";
            $temp = []; foreach($this->value as $item) array_push($temp, "?");
            $this->requete .= implode(',', $temp) . ")";

            try {

                $resultat = $this->connexion->prepare($this->requete);
                $resultat = $resultat->execute($this->value);
                $lastInsertId  = $this->connexion->lastInsertId();
                if(isset($description) && $this->table !== "logs") $paramLogs = ["action"=>"insert","currenttable"=>$this->db_prefix . $this->table,"description"=>$description,"currentid"=>$lastInsertId, "result"=>"Reussie"];
                $this->__reset();
                if(isset($paramLogs) && $this->table !== "logs" && $this->appConfig->log == 1) $resultat = $this->__logs($paramLogs);
                return ($resultat !== 0) ? $lastInsertId : false;
            }catch (\PDOException $ex) {
                var_dump($this->requete." ** ".implode("; ",$this->value)." ** ".$ex->getMessage()."<br/>".$ex->getTrace()[2]['file']." - ".$ex->getTrace()[2]['line']."<br/>".$ex->getTrace()[1]['file']." - ".$ex->getTrace()[1]['line']);
                Utils::setMessageError(['sql',$this->requete." ** ".implode("; ",$this->value)." ** ".$ex->getMessage()."<br/>".$ex->getTrace()[2]['file']." - ".$ex->getTrace()[2]['line']."<br/>".$ex->getTrace()[1]['file']." - ".$ex->getTrace()[1]['line']]);
                if(isset($description) && $this->table !== "logs" && $this->appConfig->log == 1) {
                    $paramLogs = ["action"=>"insert","currenttable"=>$this->db_prefix . $this->table,"description"=>$description,"currentid"=>$this->connexion->lastInsertId(),"result"=>"Echouee"];
                    $this->__logs($paramLogs);
                }
                $this->__reset();
                return false;
            }
        }

        $this->__reset();

        return $this->requete;
    }

    /**
     * @return bool|mixed
     */
    protected function __update()
    {
        if (!\is_null($this->table) && \count($this->champs) > 0 && \count($this->condition) > 0) {

            $this->setPrefix("update");

            if($this->table !== "logs") {
                $description  = "champ : [ ".implode(" ** ",array_keys($this->champs))." ] valeur : [ ";
                $description .= implode(" ** ",$this->champs)." ]";
            }

            if(count($this->value) == 0) {
                $this->value = array_values($this->champs);
                $valueCond = array_values($this->condition);
                $this->condition = array_map(function($one){return $one = $one. '?';},array_keys($this->condition));
            }else $this->value = array_merge(array_values($this->champs), $this->value);

            $this->requete = "UPDATE " . $this->table . " SET ";
            $this->champs = array_map(function($one){return $one = (count(explode('=',$one)) > 1) ? $one. ' ?' : $one. ' = ?';},array_keys($this->champs));
            $this->requete .= implode(',', $this->champs)."  WHERE " .implode(" AND ", $this->condition);

            $this->value = (isset($valueCond)) ? array_merge($this->value, $valueCond) : $this->value;
           //echo"<pre>";var_dump($this->requete);
           //echo"<pre>";var_dump($this->value);
           //exit();
            try {

                $resultat = $this->connexion->prepare($this->requete);
                $resultat = $resultat->execute($this->value);
                if(isset($description) && $this->table !== "logs") $paramLogs = ["action"=>"update","currenttable"=>$this->db_prefix . $this->table,"description"=>$description,"currentid"=>$this->connexion->lastInsertId(),"result"=>"Reussie"];
                $this->__reset();
                if(isset($paramLogs) && $this->table !== "logs" && $this->appConfig->log == 1) $this->__logs($paramLogs);

                return $resultat;
            } catch (\PDOException $ex) {
                var_dump($this->requete." ** ".implode("; ",$this->value)." ** ".$ex->getMessage()."<br/>".$ex->getTrace()[2]['file']." - ".$ex->getTrace()[2]['line']."<br/>".$ex->getTrace()[1]['file']." - ".$ex->getTrace()[1]['line']);
                Utils::setMessageError(['sql',$this->requete." ** ".implode("; ",$this->value)." ** ".$ex->getMessage()."<br/>".$ex->getTrace()[2]['file']." - ".$ex->getTrace()[2]['line']."<br/>".$ex->getTrace()[1]['file']." - ".$ex->getTrace()[1]['line']]);
                if(isset($description) && $this->table !== "logs" && $this->appConfig->log == 1) {
                    $paramLogs = ["action"=>"update","currenttable"=>$this->db_prefix . $this->table,"description"=>$description,"currentid"=>$this->connexion->lastInsertId(),"result"=>"Echouee"];
                    $this->__logs($paramLogs);
                }
                $this->__reset();
                return false;
            }
        }
        $this->__reset();
        return $this->requete;
    }

    /**
     * @return null|string
     */
    protected function __delete()
    {
        if (!\is_null($this->table) && \count($this->condition) > 0 ) {

            $this->setPrefix("delete");

            if($this->table !== "logs") {
                $description  = "champ : [ ".implode(" ** ",array_keys($this->condition))." ] valeur : [ ";
                $description .= implode(" ** ",$this->condition)." ]";
            }
            $this->requete = "DELETE FROM " . $this->table;

            if(count($this->value) == 0){
                $this->value = array_values($this->condition);
                $this->condition = array_map(function($one){return $one = $one. ' ?';},array_keys($this->condition));
            }
            $this->requete .= " WHERE " .implode(" AND ", $this->condition);

            try {
                $resultat = $this->connexion->prepare($this->requete);
                $resultat = $resultat->execute($this->value);
                if(isset($description) && $this->table !== "logs") $paramLogs = ["action"=>"delete","currenttable"=>$this->db_prefix . $this->table,"description"=>$description,"currentid"=>$this->connexion->lastInsertId(),"result"=>"Reussie"];
                $this->__reset();
                if(isset($paramLogs) && $this->table !== "logs" && $this->appConfig->log == 1) $resultat = $this->__logs($paramLogs);

                return $resultat;
            } catch (\PDOException $ex) {
                Utils::setMessageError(['sql',$this->requete." ** ".implode("; ",$this->value)." ** ".$ex->getMessage()."<br/>".$ex->getTrace()[2]['file']." - ".$ex->getTrace()[2]['line']."<br/>".$ex->getTrace()[1]['file']." - ".$ex->getTrace()[1]['line']]);
                if(isset($description) && $this->table !== "logs" && $this->appConfig->log == 1) {
                    $paramLogs = ["action"=>"delete","currenttable"=>$this->db_prefix . $this->table,"description"=>$description,"currentid"=>$this->connexion->lastInsertId(),"result"=>"Echouee"];
                    $this->__logs($paramLogs);
                }
                $this->__reset();
                return false;
            }
        }
        $this->__reset();
        return $this->requete;
    }

    /**
     * @return bool|mixed
     */
    protected function __processing()
    {
        $requeteCount = null;
        if (!\is_null($this->table)) {

            $this->setPrefix("select");

            $this->requete = "SELECT * ";

            if (count($this->champs) > 0){
                $this->requete = "SELECT " . implode(",", $this->champs);
                $requeteCount = "SELECT ".explode(' AS ',str_replace(' as ',' AS ', $this->champs[0]))[0]." AS total";
                //$requeteCount = "SELECT COUNT(".explode(' AS ',str_replace(' as ',' AS ', $this->champs[0]))[0].") AS total";

            }
            $this->requete .= " FROM " . $this->table." ";
            $requeteCount .= " FROM " . $this->table." ";

            if (count($this->jointure) > 0){
                $this->requete .= implode(" ", $this->jointure)." ";
                $requeteCount .= implode(" ", $this->jointure)." ";
            }

            unset($this->champs[0]);

            if(Session::existeAttribut("default_sort")) {
                $this->sort = Session::getAttributArray("default_sort");
                Utils::unsetDefaultSort();
            };

            $this->champs = array_map(function($one){return $one = explode(" AS ",str_replace(' as ',' AS ', $one))[0];},array_values($this->champs));

            if (count($this->condition) > 0){
                if(count($this->value) == 0){
                    $this->value = array_values($this->condition);
                    $this->condition = array_map(function($one){return $one = $one. ' ?';},array_keys($this->condition));
                }
                $this->requete .= "  WHERE " .implode(" AND ", $this->condition);
                $requeteCount .= "  WHERE " .implode(" AND ", $this->condition);
                if ($_REQUEST['search']['value'] != ""){
                    $this->requete .= " AND (" .implode(" LIKE ? OR ", $this->champs) ." LIKE ? )" ;
                    $requeteCount .= " AND (" .implode(" LIKE ? OR ", $this->champs) ." LIKE ? )" ;
                    foreach ($this->champs as $item) array_push($this->value,"%".$_REQUEST['search']['value']."%");
                }
            }elseif ($_REQUEST['search']['value'] != ""){
                $this->requete .= " WHERE (" .implode(" LIKE ? OR ", $this->champs) ." LIKE ? )" ;
                $requeteCount .= " WHERE (" .implode(" LIKE ? OR ", $this->champs) ." LIKE ? )" ;
                foreach ($this->champs as $item) array_push($this->value,"%".$_REQUEST['search']['value']."%");
            }
        }
//echo $this->requete;
        if (count($this->group) > 0){
            $this->requete .= " GROUP BY ".implode(", ", $this->group);
            $requeteCount .= " GROUP BY ".implode(", ", $this->group);
        }

        if(count($this->sort) > 0) {
            $_REQUEST['order'][0]['column'] = intval($this->sort[0]) - 1;
            $_REQUEST['order'][0]['dir'] = $this->sort[1];
        }

        $this->requete.= (intval($_REQUEST['order'][0]['column']) < count($this->champs)) ?
            " ORDER BY ".$this->champs[$_REQUEST['order'][0]['column']]." ".strtoupper($_REQUEST['order'][0]['dir']):
            " ORDER BY ".$this->champs[0]." ".strtoupper($_REQUEST['order'][0]['dir']);

        $this->requete .= " LIMIT ".$_REQUEST['start']." ,".$_REQUEST['length'];
        //echo $this->requete ;

        if (!\is_null($this->requete)) {
            try {

                $resultat = $this->connexion->prepare($this->requete);
                (count($this->value) > 0) ? $resultat->execute($this->value) : $resultat->execute();

                $total = $this->connexion->prepare($requeteCount);
                (count($this->value) > 0) ? $total->execute($this->value) : $total->execute();

                $this->__reset();

                //return [$resultat->fetchAll(\PDO::FETCH_ASSOC), $total->fetchAll(\PDO::FETCH_OBJ)[0]->total];
                return [$resultat->fetchAll(\PDO::FETCH_ASSOC), count($total->fetchAll(\PDO::FETCH_OBJ))];
            } catch (\PDOException $ex) {
                $this->__reset();
                Utils::setMessageError(['sql',$this->requete." ** ".implode("; ",$this->value)." ** ".$ex->getMessage()."<br/>".$ex->getTrace()[2]['file']." - ".$ex->getTrace()[2]['line']."<br/>".$ex->getTrace()[1]['file']." - ".$ex->getTrace()[1]['line']]);
                return $this->requete." ** ".implode("; ",$this->value)." ** ".$ex->getMessage()." - ".$ex->getTrace()[2]['file']." - ".$ex->getTrace()[2]['line']." - ".$ex->getTrace()[1]['file']." - ".$ex->getTrace()[1]['line'];
            }
        }
        $this->__reset();
        return false;
    }


    protected function __processing1()
    {
        $requeteCount = null;
        if (!\is_null($this->table)) {

            $this->setPrefix("select");

            $this->requete = "SELECT * ";

            if (count($this->champs) > 0){
                $this->requete = "SELECT " . implode(",", $this->champs);
                $requeteCount = "SELECT COUNT(".explode(' AS ',str_replace(' as ',' AS ', $this->champs[0]))[0].") AS total";
            }
            $this->requete .= " FROM " . $this->table." ";
            $requeteCount .= " FROM " . $this->table." ";

            if (count($this->jointure) > 0){
                $this->requete .= implode(" ", $this->jointure)." ";
                $requeteCount .= implode(" ", $this->jointure)." ";
            }

            unset($this->champs[0]);

            if(Session::existeAttribut("default_sort")) {
                $this->sort = Session::getAttributArray("default_sort");
                Utils::unsetDefaultSort();
            };

            $this->champs = array_map(function($one){return $one = explode(" AS ",str_replace(' as ',' AS ', $one))[0];},array_values($this->champs));

            if (count($this->condition) > 0){
                if(count($this->value) == 0){
                    $this->value = array_values($this->condition);
                    $this->condition = array_map(function($one){return $one = $one. ' ?';},array_keys($this->condition));
                }
                $this->requete .= "  WHERE " .implode(" AND ", $this->condition);
                $requeteCount .= "  WHERE " .implode(" AND ", $this->condition);
                if ($_REQUEST['search']['value'] != ""){
                    $this->requete .= " AND (" .implode(" LIKE ? OR ", $this->champs) ." LIKE ? )" ;
                    $requeteCount .= " AND (" .implode(" LIKE ? OR ", $this->champs) ." LIKE ? )" ;
                    foreach ($this->champs as $item) array_push($this->value,"%".$_REQUEST['search']['value']."%");
                }
            }elseif ($_REQUEST['search']['value'] != ""){
                $this->requete .= " WHERE (" .implode(" LIKE ? OR ", $this->champs) ." LIKE ? )" ;
                $requeteCount .= " WHERE (" .implode(" LIKE ? OR ", $this->champs) ." LIKE ? )" ;
                foreach ($this->champs as $item) array_push($this->value,"%".$_REQUEST['search']['value']."%");
            }
        }

        if (count($this->group) > 0){
            $this->requete .= " GROUP BY ".implode(", ", $this->group);
            $requeteCount .= " GROUP BY ".implode(", ", $this->group);
        }

        if(count($this->sort) > 0) {
            $_REQUEST['order'][0]['column'] = intval($this->sort[0]) - 1;
            $_REQUEST['order'][0]['dir'] = $this->sort[1];
        }

        $this->requete.= (intval($_REQUEST['order'][0]['column']) < count($this->champs)) ?
            " ORDER BY ".$this->champs[$_REQUEST['order'][0]['column']]." ".strtoupper($_REQUEST['order'][0]['dir']):
            " ORDER BY ".$this->champs[0]." ".strtoupper($_REQUEST['order'][0]['dir']);

        $this->requete .= " LIMIT ".$_REQUEST['start']." ,".$_REQUEST['length'];

        if (!\is_null($this->requete)) {
            try {
                $resultat = $this->connexion->prepare($this->requete);
                (count($this->value) > 0) ? $resultat->execute($this->value) : $resultat->execute();

                $total = $this->connexion->prepare($requeteCount);
                (count($this->value) > 0) ? $total->execute($this->value) : $total->execute();

                $this->__reset();

                return [$resultat->fetchAll(\PDO::FETCH_ASSOC), $total->fetchAll(\PDO::FETCH_OBJ)[0]->total];
            } catch (\PDOException $ex) {
                $this->__reset();
                Utils::setMessageError(['sql',$this->requete." ** ".implode("; ",$this->value)." ** ".$ex->getMessage()."<br/>".$ex->getTrace()[2]['file']." - ".$ex->getTrace()[2]['line']."<br/>".$ex->getTrace()[1]['file']." - ".$ex->getTrace()[1]['line']]);
                return $this->requete." ** ".implode("; ",$this->value)." ** ".$ex->getMessage()." - ".$ex->getTrace()[2]['file']." - ".$ex->getTrace()[2]['line']." - ".$ex->getTrace()[1]['file']." - ".$ex->getTrace()[1]['line'];
            }
        }
        $this->__reset();
        return false;
    }


    public function beginTransaction()
    {
        $this->connexion->beginTransaction();
    }

    public function commit()
    {
        $this->connexion->commit();
    }

    public function rollBack()
    {
        $this->connexion->rollBack();
    }

    private function __reset()
    {
        $this->table     = null;
        $this->requete   = null;
        $this->jointure  = [];
        $this->champs    = [];
        $this->value     = [];
        $this->condition = [];
        $this->sort      = [];
        $this->limit     = [];
        $this->group     = [];
    }

    /**
     * @param $param
     * @return mixed
     */
    private function __logs($param)
    {
        $param['fk_user'] = $this->_USER->id;
        $this->table = "logs";
        $this->champs = $param;
        $this->__insert();
        Utils::writeFileLogs(implode(" ** ",$param));
        return $param['currentid'];
    }

    /**
     * @param $param
     */
    protected function __addParam($param)
    {
        if(isset($param['requete'])) $this->requete = $param['requete'];
        if(isset($param['table'])) $this->table = $param['table'];
        if(isset($param['jointure']) && count($param['jointure']) > 0) $this->jointure = $param['jointure'];
        if(isset($param['champs']) && count($param['champs']) > 0) $this->champs = $param['champs'];
        if(isset($param['condition']) && count($param['condition']) > 0) $this->condition = $param['condition'];
        if(isset($param['value']) && count($param['value']) > 0) $this->value = $param['value'];
        if(isset($param['sort']) && count($param['sort']) > 0) $this->sort = $param['sort'];
        if(isset($param['limit']) && count($param['limit']) > 0) $this->limit = $param['limit'];
        if(isset($param['group']) && count($param['group']) > 0) $this->group = $param['group'];
    }

    /**
     * @param $profil
     * @param $controller
     * @param $action
     * @param null $module
     * @param null $sousModule
     * @return bool
     */
    public function __authorized($profil, $controller, $action, $module = null, $sousModule = null)
    {
        $this->table = "affectation_droit ad";
        $this->champs =['d.id'];
        $this->jointure = ($this->appConfig->profile_level == 1) ? [
            "INNER JOIN profil p ON ad.fk_profil = p.id",
            "INNER JOIN droit d ON ad.fk_droit = d.id",
            "INNER JOIN sous_module sm ON d.fk_sous_module = sm.id",
            "INNER JOIN module m ON sm.fk_module = m.id"
        ]:[
            "INNER JOIN profil p ON ad.fk_profil = p.id",
            "INNER JOIN droit d ON ad.fk_droit = d.id",
            "INNER JOIN sous_module sm ON ad.fk_sous_module = sm.id",
            "INNER JOIN module m ON sm.fk_module = m.id",
            "INNER JOIN affectation_droit_user adu ON ad.id = adu.fk_affectation_droit",
            "INNER JOIN user u ON adu.fk_user = u.id"
        ];

        if(!is_null($module)){
            $this->condition = ($this->appConfig->profile_level == 1) ?
                ["p.id ="=>$profil,"m.module ="=>$module,"p.etat ="=>"Activer","d.etat ="=>1,"ad.etat ="=>1]:
                ["p.id ="=>$profil,"m.module ="=>$module,"p.etat ="=>"Activer","d.etat ="=>1,"ad.etat ="=>1,"adu.etat ="=>1];
        }elseif(!is_null($sousModule)){
            $this->condition = ($this->appConfig->profile_level == 1) ?
                ["p.id ="=>$profil,"sm.sous_module ="=>$sousModule,"p.etat ="=>"Activer","d.etat ="=>1,"ad.etat ="=>1]:
                ["p.id ="=>$profil,"sm.sous_module ="=>$sousModule,"p.etat ="=>"Activer","d.etat ="=>1,"ad.etat ="=>1,"adu.etat ="=>1];
        }else{
            $this->condition = ($this->appConfig->profile_level == 1) ?
                ["p.id ="=>$profil,"d.controller ="=>$controller,"d.action ="=>$action,"p.etat ="=>"Activer","d.etat ="=>1,"ad.etat ="=>1]:
                ["p.id ="=>$profil,"d.controller ="=>$controller,"d.action ="=>$action,"p.etat ="=>"Activer","d.etat ="=>1,"ad.etat ="=>1,"adu.etat ="=>1];
        }

        return ($this->_USER->admin == 1) ? true : (count($this->__select()) > 0);
    }

    use CommonModel;
}