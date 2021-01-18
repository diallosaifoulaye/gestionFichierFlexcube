<?php 

class ApiCash
{
    public function getTypePiece()
    {
        $ch = curl_init();
		$headers = array(
				//"Accept: application/json",
				"Content-Type: application/json"
			);
        curl_setopt($ch, CURLOPT_URL, "192.168.1.150/meczy/api/ges-api.php?action=getTypePiece");
        //curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		//echo curl_errno();
        $result = curl_exec($ch);
        return $result;
    }
	
	public function authentification($username,$password)
	{
		$ch = curl_init();
		$data = array(
				  'username' => $username,
				  'password' => $password,
				  );
		$request = json_encode($data);
		$headers = array(
				"Content-Type: application/json",
			); 
		//curl_setopt($ch, CURLOPT_URL, "https://numherit-labs.com/cashmanagement/api/cash_management/login");
		curl_setopt($ch, CURLOPT_URL, "192.168.1.150/meczy/api/ges-api.php?action=login");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		return $result;
	}

	public function consulterSolde($code)
	{
		$ch = curl_init();
		$data = array(
				  'code' => $code,
				  );
		$request = json_encode($data);
		$headers = array(
				"Content-Type: application/json",
			); 
		//curl_setopt($ch, CURLOPT_URL, "https://numherit-labs.com/cashmanagement/api/cash_management/login");
		curl_setopt($ch, CURLOPT_URL, "192.168.1.150/meczy/api/ges-api.php?action=consulterSolde");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		return $result;
	}
	
	public function rechercherClient($code)
	{
		$ch = curl_init();
		$data = array(
				  'code' => $code,
				  );
		$request = json_encode($data);
		$headers = array(
				"Content-Type: application/json",
			); 
		//curl_setopt($ch, CURLOPT_URL, "https://numherit-labs.com/cashmanagement/api/cash_management/login");
		curl_setopt($ch, CURLOPT_URL, "192.168.1.150/meczy/api/ges-api.php?action=rechercherClient");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		return $result;
	}
	public function listeCompteClient($code)
	{
		$ch = curl_init();
		$data = array(
				  'code' => $code,
				  );
		$request = json_encode($data);
		$headers = array(
				"Content-Type: application/json",
			); 
		//curl_setopt($ch, CURLOPT_URL, "https://numherit-labs.com/cashmanagement/api/cash_management/login");
		curl_setopt($ch, CURLOPT_URL, "192.168.1.150/meczy/api/ges-api.php?action=ListeCompteClient");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		return $result;
	}
	
	
	public function historiquetransaction($code)
	{
		$ch = curl_init();
		$data = array(
				  'code' => $code,
				  );
		$request = json_encode($data);
		$headers = array(
				"Content-Type: application/json",
			); 
		//curl_setopt($ch, CURLOPT_URL, "https://numherit-labs.com/cashmanagement/api/cash_management/login");
		curl_setopt($ch, CURLOPT_URL, "192.168.1.150/meczy/api/ges-api.php?action=HistoriqueTransaction");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		return $result;
	}
	
	public function depot($montant,$code_agence,$code_user,$code_client,$num_compte_client,$codeproduit)
	{
		$ch = curl_init();
		$data = array(
				  'montant' => $montant,
				  'code_agence' => $code_agence,
				  'code_user' => $code_user,
				  'code_client' => $code_client,
				  'num_compte_client' => $num_compte_client,
				  'codeproduit' => $codeproduit,
				  );
		$request = json_encode($data);
		$headers = array(
				"Content-Type: application/json",
			); 
		//curl_setopt($ch, CURLOPT_URL, "https://numherit-labs.com/cashmanagement/api/cash_management/login");
		curl_setopt($ch, CURLOPT_URL, "192.168.1.150/meczy/api/ges-api.php?action=depot");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		return $result;
	}
	
	public function retrait($montant,$code_agence,$code_user,$code_client,$num_compte_client,$codeproduit)
	{
		$ch = curl_init();
		$data = array(
				  'montant' => $montant,
				  'code_agence' => $code_agence,
				  'code_user' => $code_user,
				  'code_client' => $code_client,
				  'num_compte_client' => $num_compte_client,
				  'codeproduit' => $codeproduit,
				  );
		$request = json_encode($data);
		$headers = array(
				"Content-Type: application/json",
			); 
		//curl_setopt($ch, CURLOPT_URL, "https://numherit-labs.com/cashmanagement/api/cash_management/login");
		curl_setopt($ch, CURLOPT_URL, "192.168.1.150/meczy/api/ges-api.php?action=retrait");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		return $result;
	}
}


 // $api = new ApiCash();
//echo $api->register();rechercherClient

//$response = '{"statusMessage":"Success","statusCode":"000"}';
//echo time();
//echo $api->getTypePiece();
//echo $fichier = fopen('../.htaccess', 'a+');
//echo $api->authentification('PDIABEL','9');
//echo $api->historiquetransaction('PDIABEL');
//echo $api->retrait('14000','01','PDIABEL','0100000008','0100100000008','CC002');
//echo '<pre>';
 // echo $api->rechercherClient('0100000008');
//echo $api->ListeCompteClient('0100000008');
//$response = '{"statusMessage":"91f0f8ff8d04cc5c86c695df0e3b3883","statusCode":"000"}';

//echo $api->test_func();
//var_dump($_SERVER);echo'<br>';
//echo $json = $api->abonne($username, $token, $customerid,$user_boutique); echo'<br>';
//echo $json = $api->releve($username, $token, $customerid,$user_boutique);echo'<br>';
/*echo $json = $api->reimprimer($username, $token, $reference,$user_boutique);echo'<br>';*/
//echo $json = $api->reimprimerDernier($username, $token, $customerid,$user_boutique);echo'<br>';
//echo $json = $api->encaisser($username, $token, $customerid,$facture1,$montant,$user_boutique);


//echo time()+18000360;
?>