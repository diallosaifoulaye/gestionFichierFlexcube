<?php
/*
*author: Ibn Al Macktoum
*Date derniere modification : 25-11-2015
*/
date_default_timezone_set('Africa/Dakar');

class Connection
{
    protected $db;
    /*public function Connection1()
    {
        $conn = NULL;
        try {
            $conn = new PDO("mysql:dbname=fhbs_numheritlabscom93;host=fhbs.myd.sharedbox.com", "fhbs_sablux", "KQG9kdfHSZGf");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->exec('SET NAMES utf8');

        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
        $this->db = $conn;
    }*/
    public function Connection()
	  {
        $conn = NULL;
		
		try  
		{  
			$conn = new PDO( "sqlsrv:Server=WIN-UUQDD9VQKCN ; Database=meczy", "sa", "Passer123");  
			$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );  
		}  
		catch(Exception $e)  
		{   
			die( print_r( $e->getMessage() ) );   
		}
		$this->db = $conn;
	   }
// fhbs.myd.sharedbox.com  fhbs_numheritlabscom126
    public function getConnection()
    {
        return $this->db;
    }



}


?>
