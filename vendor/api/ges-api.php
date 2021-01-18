<?php
error_reporting(0);
require('Rest.php');
require('Utils_ApiCash.php');
//$con = new Utils_ApiCash();
//echo $con->getPieces();die;

	class Rest_Api extends Rest_Rest 
	{
		public $data = "";
		public function __construct()
		{
			parent::__construct();
		}
		
		/**
		 * Public method for access api.
		 * This method dynmically call the method based on the query string
		 *
		 */
		public function processApi()
		{
			$func = strtolower(trim(str_replace("/","",$_REQUEST['action']))); 		
			if((int)method_exists($this,$func) > 0)
				$this->$func();
			else
				$this->response('',204); // If the method not exist with in this class, response would be "Page not found".
		}
		
		/**
		 *	Encode array into JSON
		*/
		private function json($data)
		{
			if(is_array($data)){
				return json_encode($data);
			}
		}

        /**
         *	verifie un JSON
         */
        private function isJson($string) {
            return ((is_string($string) &&
                (is_object(json_decode($string)) ||
                    is_array(json_decode($string))))) ? true : false;
        }

        /**
         *	Affiche Hello World
         */
        public function getTypePiece()
        {
			$utils = new Utils_ApiCash();
            if($this->get_request_method() != "GET"){ $this->response('',406); }
            $resultat = $utils->getPieces();
            $this->response($resultat, 200);
        }
		
	


        /**
		 * Fonction pour s'authentifier
		 * password : password
		 * login : login
		 */
		 private function login()
		{
			//echo $this->_request['username'];die;
			$utils = new Utils_ApiCash();
			if($this->get_request_method() != "POST"){ $this->response('',406); }
			$username = $this->_request['username'];
			$password = $this->_request['password'];
			////////
            if((!isset($this->_request['username'])) || (!isset($this->_request['password'])))
            {
                $this->response('', 400);
            }
            else
            {
                $resultat = @$utils->authentification($username,$password);
                if ($this->isJson($resultat))
                    $this->response($resultat, 200);
                else
                    $this->response('', 204);
            }///////
        }
		
		/**
		 * Fonction pour consulter le solde
		 * code : code
		 */
		 private function consulterSolde()
		{
			//echo $this->_request['username'];die;
			$utils = new Utils_ApiCash();
			if($this->get_request_method() != "POST"){ $this->response('',406); }
			$code = $this->_request['code'];
			////////
            if(!isset($this->_request['code']))
            {
                $this->response('', 400);
            }
            else
            {
                $resultat = @$utils->soldeCollecteur($code);
                if ($this->isJson($resultat))
                    $this->response($resultat, 200);
                else
                    $this->response('', 204);
            }///////
        }
		
		/**
		 *	Infos client
		*/
		 private function rechercherClient()
		{
			//echo $this->_request['code'];die;
			$utils = new Utils_ApiCash();
			if($this->get_request_method() != "POST"){ $this->response('',406); }
			$code = $this->_request['code'];
            if(!isset($this->_request['code']))
            {
                $this->response('', 400);
            }
            else
            {
                $resultat = @$utils->rechercherClient1($code);
                if ($this->isJson($resultat))
                    $this->response($resultat, 200);
                else
                    $this->response('', 204);
            }
        }
		
		 private function ListeCompteClient()
		{
			//echo $this->_request['code'];die;
			$utils = new Utils_ApiCash();
			if($this->get_request_method() != "POST"){ $this->response('',406); }
			$code = $this->_request['code'];
            if(!isset($this->_request['code']))
            {
                $this->response('', 400);
            }
            else
            {
                $resultat = @$utils->listeCompteClient($code);
                if ($this->isJson($resultat))
                    $this->response($resultat, 200);
                else
                    $this->response('', 204);
            }
        }
		
		
		/**
		 *	historique transaction client
		*/
		 private function HistoriqueTransaction()
		{
			//echo $this->_request['username'];die;
			$utils = new Utils_ApiCash();
			if($this->get_request_method() != "POST"){ $this->response('',406); }
			$code = $this->_request['code'];
            if(!isset($this->_request['code']))
            {
                $this->response('', 400);
            }
            else
            {
                $resultat = @$utils->HistoriqueTransactions($code);
                if ($this->isJson($resultat))
                    $this->response($resultat, 200);
                else
                    $this->response('', 204);
            }
        }
		
		/**
		 *	depot
		*/
		 private function depot()
		{
			//echo $this->_request['username'];die;
			$utils = new Utils_ApiCash();
			if($this->get_request_method() != "POST"){ $this->response('',406); }
			$montant = $this->_request['montant'];
			$code_agence = $this->_request['code_agence'];
			$code_user = $this->_request['code_user'];
			$code_client = $this->_request['code_client'];
			$num_compte_client = $this->_request['num_compte_client'];
			$codeproduit = $this->_request['codeproduit'];
			if((!isset($this->_request['montant'])) || (!isset($this->_request['code_agence'])) || (!isset($this->_request['code_user'])) || (!isset($this->_request['code_client'])) || (!isset($this->_request['num_compte_client'])) || (!isset($this->_request['codeproduit'])))
            {
                $this->response('', 400);
            }
            else
            {
                $resultat = @$utils->depot($montant,$code_agence,$code_user,$code_client,$num_compte_client,$codeproduit);
                if ($this->isJson($resultat))
                    $this->response($resultat, 200);
                else
                    $this->response('', 204);
            }
        }
		
		/**
		 *	depot
		*/
		 private function retrait()
		{
			$utils = new Utils_ApiCash();
			if($this->get_request_method() != "POST"){ $this->response('',406); }
			$montant = $this->_request['montant'];
			$code_agence = $this->_request['code_agence'];
			$code_user = $this->_request['code_user'];
			$code_client = $this->_request['code_client'];
			$num_compte_client = $this->_request['num_compte_client'];
			$codeproduit = $this->_request['codeproduit'];
			if((!isset($this->_request['montant'])) || (!isset($this->_request['code_agence'])) || (!isset($this->_request['code_user'])) || (!isset($this->_request['code_client'])) || (!isset($this->_request['num_compte_client'])) || (!isset($this->_request['codeproduit'])))
            {
                $this->response('', 400);
            }
            else
            {
                $resultat = @$utils->retrait($montant,$code_agence,$code_user,$code_client,$num_compte_client,$codeproduit);
                if ($this->isJson($resultat))
                    $this->response($resultat, 200);
                else
                    $this->response('', 204);
            }
        }
		


	}
	//echo 1111;
	// Initiiate Library
	$api = new Rest_Api;
	$api->processApi();

?>