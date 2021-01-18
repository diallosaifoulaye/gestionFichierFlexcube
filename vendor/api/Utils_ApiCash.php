<?php
require_once('config/connexion.php');


class Utils_ApiCash
{
    // identifiant de connexion
    private $pdo;
    private $date;
	private $connexion_bdd;


    // Constructeur de la classe Model
    public function __construct()
    {
        $con = new Connection();
        $this->pdo = $con->getConnection();
        $this->date = date('Y-m-d H:i:s');
    }

	/*------------------------- Authentification partenaire ------------------------------*/
    public function authentification($username,$password)
    {
        $resultat = array();
        try{
            //$password = bin2hex($password);
			$sql = "SELECT * FROM SG.SG_USUARIOS WHERE COD_USUARIO='".$username."' AND PALABRA_PASO='".$password."'";
            $req = $this->pdo->prepare($sql);
            $res = $req->execute();
			$result = $req->fetchAll(PDO::FETCH_OBJ);
            $rows = $req->rowCount();
            if($rows==1){
				$comment = "connexion réussie code 200";
                $resultat = array("statusMessage"=>$result,"statusCode"=>"200");
            }
            else{
                $resultat = array("statusMessage"=>"Username ou mot de passe incorrecte","statusCode"=>"106");
            }
        }
        catch(Exception $e){
            $resultat = array("statusMessage"=>"Erreur!","statusCode"=>"101");
        }
        return json_encode($resultat);
    }

	/*------------------------- Solde collecteur ------------------------------*/
    public function soldeCollecteur($code)
    {
        $resultat = array();
        try{
            $sql = "SELECT SAL_ACT_EFECTIVO FROM CJ.CJ_SALDOS_DIARIOS WHERE COD_CAJERO='".$code."' AND IND_ESTADO='A'";
            $req = $this->pdo->prepare($sql);
            $res = $req->execute();
			      $result = $req->fetchAll(PDO::FETCH_OBJ);
            $rows = $req->rowCount();
            if($rows==1){
				        $comment = "solde disponible code 200";
                $resultat = array("statusMessage"=>$result,"statusCode"=>"200");
            }
            else{
                $comment = "Solde indisponible code 107";
                $resultat = array("statusMessage"=>"Solde indisponible","statusCode"=>"107");
            }
        }
        catch(Exception $e){
            $comment = "Consultation solde error code: ".$e;
            $resultat = array("statusMessage"=>"Erreur!","statusCode"=>"101");
        }
        return json_encode($resultat);
    }
	
	
	

	/*------------------------- Les  types de pieces ------------------------------*/
    public function getPieces()
    {
        $resultat = array();
        try{
            $sql = "SELECT COD_TIPO_ID, DES_TIPO_ID FROM CL.CL_TIPOS_ID";
            $req = $this->pdo->prepare($sql);
            $res = $req->execute();
			$result = $req->fetchAll(PDO::FETCH_OBJ);
			$rows = $req->rowCount();
            if($rows>0){
				$comment = "type de pièces code 200";
                $resultat = array("statusMessage"=>$result,"statusCode"=>"200");
            }
            else{
                $comment = "type de pièces indisponibles code 101";
                $resultat = array("statusMessage"=>"Type de pièces indisponibles","statusCode"=>"101");
            }
        }
        catch(Exception $e){
            $comment = "type de pièces error code: ".$e;
            $resultat = array("statusMessage"=>"Erreur!","statusCode"=>"101");
        }
        return json_encode($resultat);
    }

	/*---------------------------------- MAX NUM_MOVIMIENTO --------------------------------*/
	public function MAX_NUM_MOVIMIENTO()
	{
		try{
			$sql = "SELECT MAX(NUM_MOVIMIENTO) AS lastID FROM CC.CC_MOVIMTO_DIARIO";
            $req = $this->pdo->prepare($sql);
            $res = $req->execute();
			$result = $req->fetch(PDO::FETCH_OBJ);
			$rows = $req->rowCount();
			$id = $result->lastID+1;

		}catch(Exception $e)
        {
            $id = -1;
        }
		return $id;
	}

	/*---------------------------------- MAX NUM_SECUENCIA_DOC --------------------------------*/
	public function MAX_NUM_SECUENCIA_DOC()
	{
		try{
			$sql = "SELECT MAX(NUM_SECUENCIA_DOC) AS lastID FROM CJ.CJ_TRAN_DIARIO_DETA";
            $req = $this->pdo->prepare($sql);
            $res = $req->execute();
			$result = $req->fetch(PDO::FETCH_OBJ);
			$rows = $req->rowCount();
			$id = $result->lastID+1;

		}catch(Exception $e)
        {
            $id = -1;
        }
		return $id;
	}

	/*---------------------------------- MAX NUM_SECUENCIA_DET --------------------------------*/
	public function MAX_NUM_SECUENCIA_DET()
	{
		try{
			$sql = "SELECT MAX(NUM_SECUENCIA_DET) AS lastID FROM CJ.CJ_TRAN_DIARIO_DETA";
            $req = $this->pdo->prepare($sql);
            $res = $req->execute();
			$result = $req->fetch(PDO::FETCH_OBJ);
			$rows = $req->rowCount();
			$id = $result->lastID+1;

		}catch(Exception $e)
        {
            $id = -1;
        }
		return $id;
	}

	/*---------------------------------- MAX NUM_SECUENCIA_DOC_ENCA --------------------------------*/
	public function MAX_NUM_SECUENCIA_DOC_ENCA()
	{
		try{
			$sql = "SELECT MAX(NUM_SECUENCIA_DOC) AS lastID FROM CJ.CJ_TRAN_DIARIO_ENCA";
            $req = $this->pdo->prepare($sql);
            $res = $req->execute();
			$result = $req->fetch(PDO::FETCH_OBJ);
			$rows = $req->rowCount();
			$id = $result->lastID+1;

		}catch(Exception $e)
        {
            $id = -1;
        }
		return $id;
	}

	/*---------------------------------- MAX ASIENTO_CONTABLE --------------------------------*/
	public function MAX_ASIENTO_CONTABLE()
	{
		try{
			$sql = "SELECT MAX(ASIENTO_CONTABLE) AS lastID FROM CJ.CJ_TRAN_DIARIO_ENCA";
            $req = $this->pdo->prepare($sql);
            $res = $req->execute();
			$result = $req->fetch(PDO::FETCH_OBJ);
			$rows = $req->rowCount();
			$id = $result->lastID+1;

		}catch(Exception $e)
        {
            $id = -1;
        }
		return $id;
	}

	/*---------------------------------- MAX COD_ENTE --------------------------------*/
	public function MAX_COD_ENTE()
	{
		try{
			$sql = "SELECT MAX(COD_ENTE) AS lastID FROM CJ.CJ_TRAN_DIARIO_ENCA";
            $req = $this->pdo->prepare($sql);
            $res = $req->execute();
			$result = $req->fetch(PDO::FETCH_OBJ);
			$rows = $req->rowCount();
			$id = $result->lastID+1;

		}catch(Exception $e)
        {
            $id = -1;
        }
		return $id;
	}

	/*---------------------------------- MAX NUM_SEC_DEP_CC --------------------------------*/
	public function MAX_NUM_SEC_DEP_CC()
	{
		try{
			$sql = "SELECT MAX(NUM_SEC_DEP_CC) AS lastID FROM CJ.CJ_TRAN_DIARIO_ENCA";
            $req = $this->pdo->prepare($sql);
            $res = $req->execute();
			$result = $req->fetch(PDO::FETCH_OBJ);
			$rows = $req->rowCount();
			$id = $result->lastID+1;

		}catch(Exception $e)
        {
            $id = -1;
        }
		return $id;
	}

	/*---------------------------------- MAX NUM_ASIENTO --------------------------------*/
	public function MAX_NUM_ASIENTO()
	{
		try{
			$sql = "SELECT MAX(NUM_ASIENTO) AS lastID FROM CG.CG_ASTO_RESUMEN";
            $req = $this->pdo->prepare($sql);
            $res = $req->execute();
			$result = $req->fetch(PDO::FETCH_OBJ);
			$rows = $req->rowCount();
			$id = $result->lastID+1;

		}catch(Exception $e)
        {
            $id = -1;
        }
		return $id;
	}

	/*-------------------------------Save MOVIMTO_DIARIO-------------------------------------*/
	public function MOVIMTO_DIARIO($NUM_CUENTA, $COD_PRODUCTO, $MON_MOVIMIENTO, $COD_AGENCIA, $COD_USUARIO)
    {
		try
		{
			$NUM_MOVIMIENTO = $this->MAX_NUM_MOVIMIENTO();
			$FEC_MOVIMIENTO=date("Y-m-d H:i:s");
			$COD_EMPRESA='04000';
			$TIP_TRANSACCION='16';
			$SUBTIP_TRANSAC='1';
			$COD_SISTEMA='CC';
			$NUM_DOCUMENTO='0';
			$EST_MOVIMIENTO='C';
			$IND_APL_CARGO='N';
			$DES_MOVIMIENTO='DÉPÔT EN COMPTES';
			$SISTEMA_FUENTE='CJ';
			$NUM_MOV_FUENTE='0';
			$sql = "INSERT INTO CC.CC_MOVIMTO_DIARIO (COD_EMPRESA, NUM_MOVIMIENTO, NUM_CUENTA, COD_PRODUCTO,TIP_TRANSACCION, SUBTIP_TRANSAC, COD_SISTEMA, FEC_MOVIMIENTO, NUM_DOCUMENTO, EST_MOVIMIENTO, IND_APL_CARGO, MON_MOVIMIENTO, DES_MOVIMIENTO, SISTEMA_FUENTE, NUM_MOV_FUENTE, COD_AGENCIA, COD_USUARIO)
				VALUES (:COD_EMPRESA, :NUM_MOVIMIENTO, :NUM_CUENTA, :COD_PRODUCTO, :TIP_TRANSACCION, :SUBTIP_TRANSAC, :COD_SISTEMA, :FEC_MOVIMIENTO, :NUM_DOCUMENTO, :EST_MOVIMIENTO, :IND_APL_CARGO, :MON_MOVIMIENTO, :DES_MOVIMIENTO, :SISTEMA_FUENTE, :NUM_MOV_FUENTE, :COD_AGENCIA, :COD_USUARIO)";
			$user = $this->pdo->prepare($sql);
			$res = $user->execute(array(
				"COD_EMPRESA" => $COD_EMPRESA,
				"NUM_MOVIMIENTO" => $NUM_MOVIMIENTO,
				"NUM_CUENTA" => $NUM_CUENTA,
				"COD_PRODUCTO" => $COD_PRODUCTO,
				"TIP_TRANSACCION" => $TIP_TRANSACCION,
				"SUBTIP_TRANSAC" => $SUBTIP_TRANSAC,
				"COD_SISTEMA" => $COD_SISTEMA,
				"FEC_MOVIMIENTO" => $FEC_MOVIMIENTO,
				"NUM_DOCUMENTO" => $NUM_DOCUMENTO,
				"EST_MOVIMIENTO" => $EST_MOVIMIENTO,
				"IND_APL_CARGO" => $IND_APL_CARGO,
				"MON_MOVIMIENTO" => $MON_MOVIMIENTO,
				"DES_MOVIMIENTO" => $DES_MOVIMIENTO,
				"SISTEMA_FUENTE" => $SISTEMA_FUENTE,
				"NUM_MOV_FUENTE" => $NUM_MOV_FUENTE,
				"COD_AGENCIA" => $COD_AGENCIA,
				"COD_USUARIO" => $COD_USUARIO,
			));
			if($res==1) return $NUM_MOVIMIENTO;
			else return -1;
		}
		catch(PDOException $Exception )
		{
			return -2;
		}
	}

	public function MOVIMTO_DIARIO1($NUM_CUENTA, $COD_PRODUCTO, $MON_MOVIMIENTO, $COD_AGENCIA, $COD_USUARIO)
    {
		try
		{
			$NUM_MOVIMIENTO = $this->MAX_NUM_MOVIMIENTO();
			$FEC_MOVIMIENTO=date("Y-m-d H:i:s");
			$COD_EMPRESA='04000';
			$TIP_TRANSACCION='44';
			$SUBTIP_TRANSAC='1';
			$COD_SISTEMA='CC';
			$NUM_DOCUMENTO='0';
			$EST_MOVIMIENTO='C';
			$IND_APL_CARGO='N';
			$DES_MOVIMIENTO='RETRAIT AU COMPTE';
			$SISTEMA_FUENTE='CC';
			$NUM_MOV_FUENTE='0';
			$sql = "INSERT INTO CC.CC_MOVIMTO_DIARIO (COD_EMPRESA, NUM_MOVIMIENTO, NUM_CUENTA, COD_PRODUCTO,TIP_TRANSACCION, SUBTIP_TRANSAC, COD_SISTEMA, FEC_MOVIMIENTO, NUM_DOCUMENTO, EST_MOVIMIENTO, IND_APL_CARGO, MON_MOVIMIENTO, DES_MOVIMIENTO, SISTEMA_FUENTE, NUM_MOV_FUENTE, COD_AGENCIA, COD_USUARIO)
				VALUES (:COD_EMPRESA, :NUM_MOVIMIENTO, :NUM_CUENTA, :COD_PRODUCTO, :TIP_TRANSACCION, :SUBTIP_TRANSAC, :COD_SISTEMA, :FEC_MOVIMIENTO, :NUM_DOCUMENTO, :EST_MOVIMIENTO, :IND_APL_CARGO, :MON_MOVIMIENTO, :DES_MOVIMIENTO, :SISTEMA_FUENTE, :NUM_MOV_FUENTE, :COD_AGENCIA, :COD_USUARIO)";
			$user = $this->pdo->prepare($sql);
			$res = $user->execute(array(
				"COD_EMPRESA" => $COD_EMPRESA,
				"NUM_MOVIMIENTO" => $NUM_MOVIMIENTO,
				"NUM_CUENTA" => $NUM_CUENTA,
				"COD_PRODUCTO" => $COD_PRODUCTO,
				"TIP_TRANSACCION" => $TIP_TRANSACCION,
				"SUBTIP_TRANSAC" => $SUBTIP_TRANSAC,
				"COD_SISTEMA" => $COD_SISTEMA,
				"FEC_MOVIMIENTO" => $FEC_MOVIMIENTO,
				"NUM_DOCUMENTO" => $NUM_DOCUMENTO,
				"EST_MOVIMIENTO" => $EST_MOVIMIENTO,
				"IND_APL_CARGO" => $IND_APL_CARGO,
				"MON_MOVIMIENTO" => $MON_MOVIMIENTO,
				"DES_MOVIMIENTO" => $DES_MOVIMIENTO,
				"SISTEMA_FUENTE" => $SISTEMA_FUENTE,
				"NUM_MOV_FUENTE" => $NUM_MOV_FUENTE,
				"COD_AGENCIA" => $COD_AGENCIA,
				"COD_USUARIO" => $COD_USUARIO,
			));
			if($res==1) return $NUM_MOVIMIENTO;
			else return -1;
		}
		catch(PDOException $Exception )
		{
			return -2;
		}
	}

	/*-------------------------------Save TRAN_DIARIO_DETA-------------------------------------*/
	public function TRAN_DIARIO_DETA($COD_AGENCIA, $MTO_DOCUMENTO)
    {
		try
		{
			$NUM_SECUENCIA_DOC = $this->MAX_NUM_SECUENCIA_DOC();
			$NUM_SECUENCIA_DET = $this->MAX_NUM_SECUENCIA_DET();
			$COD_EMPRESA='04000';
			$COD_MONEDA='4';
			$COD_FORMA_PAGO='1';
			$TIP_DOCUMENTO='5';
			$sql = "INSERT INTO CJ.CJ_TRAN_DIARIO_DETA (COD_EMPRESA, COD_AGENCIA, NUM_SECUENCIA_DOC, NUM_SECUENCIA_DET, COD_MONEDA, COD_FORMA_PAGO, TIP_DOCUMENTO, MTO_DOCUMENTO)
				VALUES (:COD_EMPRESA, :COD_AGENCIA, :NUM_SECUENCIA_DOC, :NUM_SECUENCIA_DET, :COD_MONEDA, :COD_FORMA_PAGO, :TIP_DOCUMENTO, :MTO_DOCUMENTO)";
			$user = $this->pdo->prepare($sql);
			$res = $user->execute(array(
				"COD_EMPRESA" => $COD_EMPRESA,
				"COD_AGENCIA" => $COD_AGENCIA,
				"NUM_SECUENCIA_DOC" => $NUM_SECUENCIA_DOC,
				"NUM_SECUENCIA_DET" => $NUM_SECUENCIA_DET,
				"COD_MONEDA" => $COD_MONEDA,
				"COD_FORMA_PAGO" => $COD_FORMA_PAGO,
				"TIP_DOCUMENTO" => $TIP_DOCUMENTO,
				"MTO_DOCUMENTO" => $MTO_DOCUMENTO,
			));
			if($res==1) return 1;
			else return -1;
		}
		catch(PDOException $Exception )
		{
			return $Exception;
		}
	}

	/*-------------------------------Save TRAN_DIARIO_ENCA-------------------------------------*/
	public function TRAN_DIARIO_ENCA($COD_AGENCIA, $COD_CAJERO, $COD_CLIENTE, $MTO_MOVIMIENTO, $MTO_EFECTIVO, $NUM_MOV_ENTE, $MON_SALDO_ANTERIOR, $MON_SALDO_DISPONIBLE)
    {
		try
		{
			$NUM_SECUENCIA_DOC = $this->MAX_NUM_SECUENCIA_DOC_ENCA();
			$ASIENTO_CONTABLE = $this->MAX_ASIENTO_CONTABLE();
			$COD_ENTE = $this->MAX_COD_ENTE();
			$NUM_SEC_DEP_CC = $this->MAX_NUM_SEC_DEP_CC();
			$COD_EMPRESA='04000';
			$COD_MONEDA_ORIGEN='4';
			$COD_SISTEMA='CJ';
			$TIP_TRANSACCION='5';
			$SUB_TIP_TRANSAC='1';
			$FEC_TRANSACCION=date("Y-m-d H:i:s");
			$IND_ESTADO='A';
			$MTO_VUELTO='0';
			$IND_DESGLOSE='S';
			$OBSERVACIONES='EPARGNE PREVOYANCE';
			$sql = "INSERT INTO CJ.CJ_TRAN_DIARIO_ENCA (COD_EMPRESA, COD_AGENCIA, NUM_SECUENCIA_DOC, COD_CAJERO,COD_MONEDA_ORIGEN, COD_CLIENTE, COD_SISTEMA, TIP_TRANSACCION, SUB_TIP_TRANSAC, FEC_TRANSACCION, IND_ESTADO, MTO_MOVIMIENTO, MTO_EFECTIVO, MTO_VUELTO, ASIENTO_CONTABLE, COD_ENTE, NUM_MOV_ENTE, IND_DESGLOSE, OBSERVACIONES, NUM_SEC_DEP_CC, MON_SALDO_ANTERIOR, MON_SALDO_DISPONIBLE)
				VALUES (:COD_EMPRESA, :COD_AGENCIA, :NUM_SECUENCIA_DOC, :COD_CAJERO, :COD_MONEDA_ORIGEN, :COD_CLIENTE, :COD_SISTEMA, :TIP_TRANSACCION, :SUB_TIP_TRANSAC, :FEC_TRANSACCION, :IND_ESTADO, :MTO_MOVIMIENTO, :MTO_EFECTIVO, :MTO_VUELTO, :ASIENTO_CONTABLE, :COD_ENTE, :NUM_MOV_ENTE, :IND_DESGLOSE, :OBSERVACIONES, :NUM_SEC_DEP_CC, :MON_SALDO_ANTERIOR, :MON_SALDO_DISPONIBLE)";
			$user = $this->pdo->prepare($sql);
			$res = $user->execute(array(
				"COD_EMPRESA" => $COD_EMPRESA,
				"COD_AGENCIA" => $COD_AGENCIA,
				"NUM_SECUENCIA_DOC" => $NUM_SECUENCIA_DOC,
				"COD_CAJERO" => $COD_CAJERO,
				"COD_MONEDA_ORIGEN" => $COD_MONEDA_ORIGEN,
				"COD_CLIENTE" => $COD_CLIENTE,
				"COD_SISTEMA" => $COD_SISTEMA,
				"TIP_TRANSACCION" => $TIP_TRANSACCION,
				"SUB_TIP_TRANSAC" => $SUB_TIP_TRANSAC,
				"FEC_TRANSACCION" => $FEC_TRANSACCION,
				"IND_ESTADO" => $IND_ESTADO,
				"MTO_MOVIMIENTO" => $MTO_MOVIMIENTO,
				"MTO_EFECTIVO" => $MTO_EFECTIVO,
				"MTO_VUELTO" => $MTO_VUELTO,
				"ASIENTO_CONTABLE" => $ASIENTO_CONTABLE,
				"COD_ENTE" => $COD_ENTE,
				"NUM_MOV_ENTE" => $NUM_MOV_ENTE,
				"IND_DESGLOSE" => $IND_DESGLOSE,
				"OBSERVACIONES" => $OBSERVACIONES,
				"NUM_SEC_DEP_CC" => $NUM_SEC_DEP_CC,
				"MON_SALDO_ANTERIOR" => $MON_SALDO_ANTERIOR,
				"MON_SALDO_DISPONIBLE" => $MON_SALDO_DISPONIBLE,
			));
			if($res==1) return 1;
			else return -1;
		}
		catch(PDOException $Exception )
		{
			return -2;
		}
	}

    /*-------------------------------Save ASTO_RESUMEN-------------------------------------*/
	public function ASTO_RESUMEN($COD_AGENCIA,$COD_USUARIO)
    {
		try
		{
			$NUM_ASIENTO = $this->MAX_NUM_ASIENTO();
			$COD_EMPRESA='04000';
			$TIP_TRANSACCION='5';
			$SUBTIP_TRANSAC='1';
			$COD_SISTEMA='CJ';
			$FEC_MOVIMIENTO=date("Y-m-d H:i:s");
			$FEC_ASIENTO=date("Y-m-d H:i:s");
			$FEC_REGISTRO=date("Y-m-d H:i:s");
			$DES_ASIENTO='DEPÔT DE COMPTE EN ESPECES';
			$EST_ASIENTO='P';
			$IND_LIQUIDACION='N';
			$IND_POST_CIERRE='N';
			$sql = "INSERT INTO CG.CG_ASTO_RESUMEN (COD_EMPRESA, COD_AGENCIA, NUM_ASIENTO, TIP_TRANSACCION,SUBTIP_TRANSAC, COD_SISTEMA, FEC_MOVIMIENTO, DES_ASIENTO, EST_ASIENTO, FEC_ASIENTO, FEC_REGISTRO, COD_USUARIO, IND_LIQUIDACION, IND_POST_CIERRE)
				VALUES (:COD_EMPRESA, :COD_AGENCIA, :NUM_ASIENTO, :TIP_TRANSACCION, :SUBTIP_TRANSAC, :COD_SISTEMA, :FEC_MOVIMIENTO, :DES_ASIENTO, :EST_ASIENTO, :FEC_ASIENTO, :FEC_REGISTRO, :COD_USUARIO, :IND_LIQUIDACION, :IND_POST_CIERRE)";
			$user = $this->pdo->prepare($sql);
			$res = $user->execute(array(
				"COD_EMPRESA" => $COD_EMPRESA,
				"COD_AGENCIA" => $COD_AGENCIA,
				"NUM_ASIENTO" => $NUM_ASIENTO,
				"TIP_TRANSACCION" => $TIP_TRANSACCION,
				"SUBTIP_TRANSAC" => $SUBTIP_TRANSAC,
				"COD_SISTEMA" => $COD_SISTEMA,
				"FEC_MOVIMIENTO" => $FEC_MOVIMIENTO,
				"DES_ASIENTO" => $DES_ASIENTO,
				"EST_ASIENTO" => $EST_ASIENTO,
				"FEC_ASIENTO" => $FEC_ASIENTO,
				"FEC_REGISTRO" => $FEC_REGISTRO,
				"COD_USUARIO" => $COD_USUARIO,
				"IND_LIQUIDACION" => $IND_LIQUIDACION,
				"IND_POST_CIERRE" => $IND_POST_CIERRE,
			));
			if($res==1) return 1;
			else return -1;
		}
		catch(PDOException $Exception )
		{
			return -2;
		}
	}

	/*-------------------------------Save ASTO_DETALLE-------------------------------------*/
	public function ASTO_DETALLE($COD_AGENCIA,$NUM_ASIENTO,$COD_USUARIO)
    {
		try
		{
			$COD_EMPRESA='04000';
			$TIP_TRANSACCION='5';
			$SUBTIP_TRANSAC='1';
			$COD_SISTEMA='CJ';
			$FEC_MOVIMIENTO=date("Y-m-d H:i:s");
			$FEC_ASIENTO=date("Y-m-d H:i:s");
			$FEC_REGISTRO=date("Y-m-d H:i:s");
			$DES_ASIENTO='DEPÔT DE COMPTE EN ESPECES';
			$EST_ASIENTO='P';
			$IND_LIQUIDACION='N';
			$IND_POST_CIERRE='N';
			$sql = "INSERT INTO CG.CG_ASTO_DETALLE (COD_EMPRESA, COD_AGENCIA, NUM_ASIENTO, TIP_TRANSACCION,SUBTIP_TRANSAC, COD_SISTEMA, FEC_MOVIMIENTO, DES_ASIENTO, EST_ASIENTO, FEC_ASIENTO, FEC_REGISTRO, COD_USUARIO, IND_LIQUIDACION, IND_POST_CIERRE)
				VALUES (:COD_EMPRESA, :COD_AGENCIA, :NUM_ASIENTO, :TIP_TRANSACCION, :SUBTIP_TRANSAC, :COD_SISTEMA, :FEC_MOVIMIENTO, :DES_ASIENTO, :EST_ASIENTO, :FEC_ASIENTO, :FEC_REGISTRO, :COD_USUARIO, :IND_LIQUIDACION, :IND_POST_CIERRE)";
			$user = $this->pdo->prepare($sql);
			$res = $user->execute(array(
				"COD_EMPRESA" => $COD_EMPRESA,
				"COD_AGENCIA" => $COD_AGENCIA,
				"NUM_ASIENTO" => $NUM_ASIENTO,
				"TIP_TRANSACCION" => $TIP_TRANSACCION,
				"SUBTIP_TRANSAC" => $SUBTIP_TRANSAC,
				"COD_SISTEMA" => $COD_SISTEMA,
				"FEC_MOVIMIENTO" => $FEC_MOVIMIENTO,
				"DES_ASIENTO" => $DES_ASIENTO,
				"EST_ASIENTO" => $EST_ASIENTO,
				"FEC_ASIENTO" => $FEC_ASIENTO,
				"FEC_REGISTRO" => $FEC_REGISTRO,
				"COD_USUARIO" => $COD_USUARIO,
				"IND_LIQUIDACION" => $IND_LIQUIDACION,
				"IND_POST_CIERRE" => $IND_POST_CIERRE,
			));
			if($res==1) return 1;
			else return -1;
		}
		catch(PDOException $Exception )
		{
			return -2;
		}
	}

	/*------------------------- update solde client ------------------------------*/
    public function updateSolde($code,$numcompte,$montant)
    {
        try{
           $sql = "SELECT co.SAL_DISPONIBLE, co.MON_SOB_NO_AUT
					FROM CC.CC_CUENTA_EFECTIVO co
					WHERE co.COD_CLIENTE='".$code."' AND co.NUM_CUENTA='".$numcompte."'";
            $req = $this->pdo->prepare($sql);
            $res = $req->execute();
			$result = $req->fetchObject();
			$solde = $result->SAL_DISPONIBLE;
			$solde_decouvert = $result->MON_SOB_NO_AUT;
			
			$mtt = $solde+$montant;
			
			if($solde_decouvert > $montant)
			{
				$restedecouvert = $solde_decouvert - $montant; 
			}
			else
			{
				$restedecouvert = 0;
			}
			$mtt2 = $montant - $solde_decouvert;
            if($solde >= 0){
				
                $sql2 = "UPDATE CC.CC_CUENTA_EFECTIVO  SET SAL_DISPONIBLE='".$mtt."' WHERE COD_CLIENTE='".$code."' AND NUM_CUENTA='".$numcompte."'";
            }
            else{
                $sql2 = "UPDATE CC.CC_CUENTA_EFECTIVO SET SAL_DISPONIBLE='".$mtt2."',MON_SOB_NO_AUT = '".$restedecouvert."' WHERE COD_CLIENTE='".$code."' AND NUM_CUENTA='".$numcompte."'";
            }
			$req2 = $this->pdo->prepare($sql2);
			$res2 = $req2->execute();
        }
        catch(Exception $e){
            $res2 = 0;
        }
        return $res2;
    }

	/*------------------------- update solde agent ------------------------------*/
    public function updateSoldeAgent($code,$montant)
    {
        try{
           $sql = "SELECT SAL_ACT_EFECTIVO
					FROM CJ.CJ_SALDOS_DIARIOS
					WHERE COD_CAJERO='".$code."' AND IND_ESTADO='A'";
            $req = $this->pdo->prepare($sql);
            $res = $req->execute();
			$result = $req->fetch(PDO::FETCH_OBJ);
            $rows = $req->rowCount();
			$solde = $result->SAL_ACT_EFECTIVO;
			$mtt = $solde+$montant;
			$sql2 = "UPDATE CJ.CJ_SALDOS_DIARIOS SET SAL_ACT_EFECTIVO='".$mtt."' WHERE COD_CAJERO='".$code."' AND IND_ESTADO='A'";
            $req2 = $this->pdo->prepare($sql2);
			$res2 = $req2->execute();
        }
        catch(Exception $e){
            $res2 = 0;
        }
        return $res2;
    }

	/*------------------------- update solde client ------------------------------*/
    public function updateSolde1($code,$numcompte,$montant)
    {
        try{
           $sql = "SELECT co.SAL_DISPONIBLE, co.MON_SOB_NO_AUT
					FROM CC.CC_CUENTA_EFECTIVO co
					WHERE co.COD_CLIENTE='".$code."' AND co.NUM_CUENTA='".$numcompte."'";
            $req = $this->pdo->prepare($sql);
            $res = $req->execute();
			$result = $req->fetch(PDO::FETCH_OBJ);
            $rows = $req->rowCount();
			$solde = $result->SAL_DISPONIBLE;
			$solde_decouvert = $result->MON_SOB_NO_AUT;
			$mtt = $solde-$montant;
			$sql2 = "UPDATE CC.CC_CUENTA_EFECTIVO SET SAL_DISPONIBLE='".$mtt."' WHERE COD_CLIENTE='".$code."' AND NUM_CUENTA='".$numcompte."'";
            $req2 = $this->pdo->prepare($sql2);
			$res2 = $req2->execute();
        }
        catch(Exception $e){
            $res2 = 0;
        }
        return $res2;
    }

	/*------------------------- update solde agent ------------------------------*/
    public function updateSoldeAgent1($code,$montant)
    {
        try{
           $sql = "SELECT SAL_ACT_EFECTIVO
					FROM CJ.CJ_SALDOS_DIARIOS
					WHERE COD_CAJERO='".$code."' AND IND_ESTADO='A'";
            $req = $this->pdo->prepare($sql);
            $res = $req->execute();
			$result = $req->fetchObject();
            $rows = $req->rowCount();
			$solde = $result->SAL_ACT_EFECTIVO;
			$mtt = $solde-$montant;
			$sql2 = "UPDATE CJ.CJ_SALDOS_DIARIOS SET SAL_ACT_EFECTIVO='".$mtt."' WHERE COD_CAJERO='".$code."' AND IND_ESTADO='A'";
            $req2 = $this->pdo->prepare($sql2);
			$res2 = $req2->execute();
        }
        catch(Exception $e){
            $res2 = 0;
        }
        return $res2;
    }

	/*---------------------------------- Solde Client --------------------------------*/
	public function SoldeClient($code,$numcompte)
	{
		try{
			$sql = "SELECT co.SAL_DISPONIBLE
			FROM CC.CC_CUENTA_EFECTIVO co
			WHERE co.COD_CLIENTE='".$code."' AND co.NUM_CUENTA='".$numcompte."'";
            $req = $this->pdo->prepare($sql);
            $res = $req->execute();
			$result = $req->fetch(PDO::FETCH_OBJ);
			$rows = $req->rowCount();
			$solde = $result->SAL_DISPONIBLE;

		}catch(Exception $e)
        {
            $solde = 0;
        }
		return $solde;
	}

	/*---------------------------------- Solde Client --------------------------------*/
	public function SoldeAgent($code)
	{
		try{
			$sql = "SELECT SAL_ACT_EFECTIVO FROM CJ.CJ_SALDOS_DIARIOS WHERE COD_CAJERO='".$code."' AND IND_ESTADO='A'";
            $req = $this->pdo->prepare($sql);
            $res = $req->execute();
			$result = $req->fetch(PDO::FETCH_OBJ);
			$rows = $req->rowCount();
			$solde = $result->SAL_ACT_EFECTIVO;

		}catch(Exception $e)
        {
            $solde = 0;
        }
		return $solde;
	}


	/*------------------------- Fonction depot ------------------------------*/
    public function depot($montant,$code_agence,$code_user,$code_client,$num_compte_client,$codeproduit)
    {
       $resultat = array();
	   if($montant=='' || $code_agence=='' || $code_user=='' || $code_client=='' || $num_compte_client=='' || $codeproduit=='')
        {
            if($montant==''){
                $resultat = array("statusMessage"=>"montant vide","statusCode"=>"109");
            }
            elseif ($code_agence==''){
                $resultat = array("statusMessage"=>"code agence vide","statusCode"=>"110");
            }
            elseif ($code_user==''){
                $resultat = array("statusMessage"=>"code utilisateur vide","statusCode"=>"111");
            }
            elseif ($code_client==''){
                $resultat = array("statusMessage"=>"code client vide","statusCode"=>"112");
            }
            elseif ($num_compte_client==''){
                $resultat = array("statusMessage"=>"numero compte client vide","statusCode"=>"113");
            }
            elseif ($codeproduit==''){
                $resultat = array("statusMessage"=>"code produit vide","statusCode"=>"114");
            }
        }
        elseif(is_numeric($montant)==false)
        {
            $resultat = array("statusMessage"=>"Montant invalide","statusCode"=>"115");
        }
        else
        {
            $soldeAvant = $this->SoldeClient($code_client,$num_compte_client);
			$res=$this->updateSolde($code_client,$num_compte_client,$montant);
			$this->updateSoldeAgent($code_user,$montant);
			$soldeApres = $this->SoldeClient($code_client,$num_compte_client);
		 $transac =	$this->MOVIMTO_DIARIO($num_compte_client, $codeproduit, $montant, $code_agence, $code_user);
			//$this->TRAN_DIARIO_DETA($code_agence, $montant);
			$this->TRAN_DIARIO_ENCA($code_agence, $code_user, $code_client, $montant, $montant, $num_compte_client, $soldeAvant, $soldeApres);
            $this->ASTO_RESUMEN($code_agence,$code_user);
			$resultat = array("statusMessage"=>"Depot reussi avec succes","statusCode"=>"200","transactionID"=>$transac);
        }
        return json_encode($resultat);
    }

	/*------------------------- Fonction retrait ------------------------------*/
    public function retrait($montant,$code_agence,$code_user,$code_client,$num_compte_client,$codeproduit)
    {
       $resultat = array();
	   if($montant=='' || $code_agence=='' || $code_user=='' || $code_client=='' || $num_compte_client=='' || $codeproduit=='')
        {
            if($montant==''){
                $resultat = array("statusMessage"=>"montant vide","statusCode"=>"109");
            }
            elseif ($code_agence==''){
                $resultat = array("statusMessage"=>"code agence vide","statusCode"=>"110");
            }
            elseif ($code_user==''){
                $resultat = array("statusMessage"=>"code utilisateur vide","statusCode"=>"111");
            }
            elseif ($code_client==''){
                $resultat = array("statusMessage"=>"code client vide","statusCode"=>"112");
            }
            elseif ($num_compte_client==''){
                $resultat = array("statusMessage"=>"numero compte client vide","statusCode"=>"113");
            }
            elseif ($codeproduit==''){
                $resultat = array("statusMessage"=>"code produit vide","statusCode"=>"114");
            }
        }
        elseif(is_numeric($montant)==false)
        {
            $resultat = array("statusMessage"=>"Montant invalide","statusCode"=>"115");
        }
        else
        {
            $soldeAvant = $this->SoldeClient($code_client,$num_compte_client);
			$soldeAgent = $this->SoldeAgent($code_user);
			if($soldeAvant < $montant){
				$resultat = array("statusMessage"=>"Solde client insuffisant","statusCode"=>"116");
			}
			else{
                if($soldeAgent < $montant){
                $resultat = array("statusMessage"=>"Solde Agent insuffisant","statusCode"=>"117");
				}
				else{
					$this->updateSolde1($code_client,$num_compte_client,$montant);
					$this->updateSoldeAgent1($code_user,$montant);
					$soldeApres = $this->SoldeClient($code_client,$num_compte_client);
					$this->MOVIMTO_DIARIO1($num_compte_client, $codeproduit, $montant, $code_agence, $code_user);
					//$this->TRAN_DIARIO_DETA($code_agence, $montant);
					$this->TRAN_DIARIO_ENCA($code_agence, $code_user, $code_client, $montant, $montant, $num_compte_client, $soldeAvant, $soldeApres);
					$this->ASTO_RESUMEN($code_agence,$code_user);
					$resultat = array("statusMessage"=>"Retrait reussi avec succes","statusCode"=>"200");
				}
            }


        }
        return json_encode($resultat);
    }

	/*------------------------- Liste compte client ------------------------------*/
    public function ListeCompteClient($code)
    {
      
        
        try{
           $sql = "SELECT compte.NUM_CUENTA,compte.SAL_DISPONIBLE,produit.NOM_PRODUCTO,produit.COD_PRODUCTO,compte.IND_ESTADO
					FROM CC.CC_CUENTA_EFECTIVO compte
					INNER JOIN CL.CL_CLIENTES client ON compte.COD_CLIENTE=client.COD_CLIENTE
					INNER JOIN CF.CF_PRODUCTOS produit ON compte.COD_PRODUCTO=produit.COD_PRODUCTO
					WHERE compte.COD_CLIENTE='".$code."' AND compte.IND_ESTADO='A'";
            $req = $this->pdo->prepare($sql);
            $res = $req->execute();
			$result = $req->fetchAll();
            $rows = $req->rowCount();
			//return $rows;
            if($rows>0){
				$comment = "compte disponible code 200";
                $resultat = array("statusMessage"=>$result,"statusCode"=>"200");
            }
            else{
                $comment = "Compte indisponible code 107";
                $resultat = array("statusMessage"=>"Client indisponible","statusCode"=>"107");
            }
        }
        catch(Exception $e){
            $comment = "Rechercher compte error code: ".$e;
            $resultat = array("statusMessage"=>"Erreur!","statusCode"=>"101");
        }
        return json_encode($resultat);
    }

	/*------------------------- Rechercher client ------------------------------*/
    public function rechercherClient1($code)
    {
      
        $resultat = array();
        try{
           $sql = "SELECT DISTINCT(c.COD_CLIENTE),c.NOM_CLIENTE,c.TEL_PRINCIPAL,c.COD_AGENCIA,ci.NUM_ID,t.DES_TIPO_ID,a.ABR_AGENCIA,a.DES_AGENCIA
					FROM CL.CL_CLIENTES c
					INNER JOIN CL.CL_ID_CLIENTES ci ON c.COD_CLIENTE=ci.COD_CLIENTE
					INNER JOIN CL.CL_TIPOS_ID t ON ci.COD_TIPO_ID=t.COD_TIPO_ID
					INNER JOIN CF.CF_AGENCIAS a ON c.COD_AGENCIA=a.COD_AGENCIA
				
					WHERE c.COD_CLIENTE='".$code."'";
            $req = $this->pdo->prepare($sql);
            $res = $req->execute();
			$result = $req->fetchObject();
            $rows = $req->rowCount();
			//return $rows;
            if(is_object($result) ){
				$comment = "Client disponible code 200";
                $resultat = array("statusMessage"=>$result,"statusCode"=>"200");
            }
            else{
                $comment = "Client indisponible code 107";
                $resultat = array("statusMessage"=>"Client indisponible","statusCode"=>"107");
            }
        }
        catch(Exception $e){
            $comment = "Rechercher client error code: ".$e;
            $resultat = array("statusMessage"=>"Erreur!","statusCode"=>"101");
        }
        return json_encode($resultat);
    }
	
	
	/*------------------------- Rechercher client ------------------------------*/
    public function rechercherClient($code)
    {
        $resultat = array();
        try{
           $sql = "SELECT DISTINCT(c.COD_CLIENTE),c.NOM_CLIENTE,c.TEL_PRINCIPAL,c.COFD_AGENCIAD_AGENCIA,ci.NUM_ID,t.DES_TIPO_ID,co.SAL_DISPONIBLE,p.COD_PRODUCTO,p.DES_PRODUCTO,co.NUM_CUENTA
					FROM CL.CL_CLIENTES c
					INNER JOIN CL.CL_ID_CLIENTES ci ON c.COD_CLIENTE=ci.COD_CLIENTE
					INNER JOIN CL.CL_TIPOS_ID t ON ci.COD_TIPO_ID=t.COD_TIPO_ID
					INNER JOIN CC.CC_CUENTA_EFECTIVO co ON c.COD_CLIENTE=co.COD_CLIENTE
					INNER JOIN CF.CF_PRODUCTOS p ON co.COD_PRODUCTO=p.COD_PRODUCTO
					WHERE c.COD_CLIENTE='".$code."'";
            $req = $this->pdo->prepare($sql);
            $res = $req->execute();
			$result = $req->fetchAll(PDO::FETCH_OBJ);
            $rows = $req->rowCount();
			//return $rows;
            if($rows>0){
				$comment = "Client disponible code 200";
                $resultat = array("statusMessage"=>$result,"statusCode"=>"200");
            }
            else{
                $comment = "Client indisponible code 107";
                $resultat = array("statusMessage"=>"Client indisponible","statusCode"=>"107");
            }
        }
        catch(Exception $e){
            $comment = "Rechercher client error code: ".$e;
            $resultat = array("statusMessage"=>"Erreur!","statusCode"=>"101");
        }
        return json_encode($resultat);
    }

	/*------------------------- Historiques transactions ------------------------------*/
    public function HistoriqueTransactions($code)
    {
        $resultat = array();
        try{
            $sql = "SELECT * FROM CC.CC_MOVIMTO_DIARIO WHERE COD_USUARIO='".$code."'";
            $req = $this->pdo->prepare($sql);
            $res = $req->execute();
			$result = $req->fetchAll(PDO::FETCH_OBJ);
			$rows = $req->rowCount();
            if($rows>0){
                $resultat = array("statusMessage"=>$result,"statusCode"=>"200");
            }
            else{
                $resultat = array("statusMessage"=>"Transactions indisponibles","statusCode"=>"101");
            }
        }
        catch(Exception $e){
            $resultat = array("statusMessage"=>"Erreur!","statusCode"=>"101");
        }
        return json_encode($resultat);
    }

}
 // $con = new Utils_ApiCash();
//echo $con->authentification('PDIABEL','9');
 // echo $con->MOVIMTO_DIARIO('0100100000002', 'CC002', '1200', '01', 'PDIABEL');
//echo $con->TRAN_DIARIO_DETA('01', '2200');
//echo $con->TRAN_DIARIO_ENCA('01', 'PDIABEL', '0100000008', '2200', '2200', '0100100000008', '4500', '5500');
//echo $con->ASTO_RESUMEN('01','PDIABEL');
//echo $con->SoldeAgent('PDIABEL').'////';
// echo $con->updateSoldeAgent('PDIABEL','8000');
//echo $con->SoldeClient('0100000008','0100100000008');
 // echo $con->updateSolde('0100000002','0100100000002','3000');
//echo $con->SoldeClient('0100000008','0100100000008');
 // echo $con->rechercherClient1('0100000008');
//echo $con->ListeCompteClient('0100000008');
 // echo $con->HistoriqueTransactions('PDIABEL');
