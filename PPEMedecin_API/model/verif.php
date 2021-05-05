<?php

class verif {
    // Objet PDO servant à la connexion à la base
	private $pdo;

	// Connexion à la base de données
	public function __construct() {
		$config = parse_ini_file("config.ini");
		
		try {
			$this->pdo = new \PDO("mysql:host=".$config["host"].";dbname=".$config["database"].";charset=utf8", $config["user"], $config["password"]);
		} catch(Exception $e) {
			echo $e->getMessage();
		}
    }
    public function verifToken($token, $ipAp){
    	$sql = 'SELECT COUNT(*) FROM authentification WHERE token = :token AND ipAppareil = :ipAp';
        $req = $this->pdo->prepare($sql);
        $req->bindParam(':token',$token,PDO::PARAM_STR);
        $req->bindParam(':ipAp',$ipAp,PDO::PARAM_STR);
        $req->execute();
        $res = $req->fetch(PDO::FETCH_BOTH);
        if($res[0] > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
?>