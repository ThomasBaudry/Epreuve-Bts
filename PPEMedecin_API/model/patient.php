<?php

class patient {
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
    public function getAll() {
        $sql = "SELECT * FROM patient";
        
        $req = $this->pdo->prepare($sql);
        $req->execute();
        
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getId($login){
        $sql = "SELECT idPatient FROM patient WHERE loginPatient = :login";
        
        $req = $this->pdo->prepare($sql);
        $req->bindParam(':login',$login,PDO::PARAM_STR);
        $req->execute();
        
        return $req->fetch(PDO::FETCH_BOTH);
    }
    
    public function  inscription($nom , $prenom , $rue , $cp , $ville , $tel, $login , $mdp)
    {
        $sql="INSERT INTO patient VALUES (null, :nomPrep , :prenomPrep , :ruePrep, :cpPrep , :villePrep , :telPrep, :loginPrep , :mdpPrep )";
        $req = $this->pdo->prepare($sql);
        $req->bindParam(':nomPrep',$nom,PDO::PARAM_STR);
        $req->bindParam(':prenomPrep',$prenom,PDO::PARAM_STR);
        $req->bindParam(':ruePrep',$rue,PDO::PARAM_STR);
        $req->bindParam(':cpPrep',$cp,PDO::PARAM_STR);
        $req->bindParam(':villePrep',$ville,PDO::PARAM_STR);
        $req->bindParam(':telPrep',$tel,PDO::PARAM_STR);
        $req->bindParam(':loginPrep',$login , PDO::PARAM_STR);
        $mdp = password_hash($mdp, PASSWORD_DEFAULT);
        $req->bindParam(':mdpPrep',$mdp,PDO::PARAM_STR);
        return $req->execute();


    }

    public function authentification($token ,$idPat, $ipAp)
    {
        $sql='INSERT INTO authentification VALUES (:token , :id , :ip)';
        $req = $this->pdo->prepare($sql);
        $req->bindParam(':token',$token,PDO::PARAM_STR);
        $req->bindParam(':id',$idPat,PDO::PARAM_STR);
        $req->bindParam(':ip',$ipAp,PDO::PARAM_STR);
        $req->execute();

    }

    public function connexion($login, $mdp, $token, $ipAp )
    {
        $sql = 'SELECT mdpPatient FROM patient WHERE loginPatient = :login';
        $req = $this->pdo->prepare($sql);
        $req->bindParam(':login',$login,PDO::PARAM_STR);
        $req->execute();
        $res = $req->fetch(PDO::FETCH_BOTH);

        if(password_verify($mdp, $res[0]))
        {
            $this->authentification($token,$this->getId($login)[0],$ipAp);
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getPatientWithToken($token, $ip){
        $sql = 'SELECT * FROM patient WHERE idPatient = (SELECT getIdWithToken(:token, :ip))';
        $req = $this->pdo->prepare($sql);
        $req->bindParam(':token',$token,PDO::PARAM_STR);
        $req->bindParam(':ip',$ip,PDO::PARAM_STR);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }
}
