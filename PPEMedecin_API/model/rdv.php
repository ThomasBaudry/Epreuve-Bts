<?php

class rdv {
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
		$sql = "SELECT * FROM rdv";
		
		$req = $this->pdo->prepare($sql);
		$req->execute();
		
		return $req->fetchAll(PDO::FETCH_ASSOC);
	}
	public function getRDV($id){
		$sql = "SELECT * FROM rdv WHERE idPatient = :id";
		
		$req = $this->pdo->prepare($sql);
		$req->bindParam(':id', $id, PDO::PARAM_INT);
		$req->execute();
		
		return $req->fetchAll(PDO::FETCH_ASSOC);
	}
	public function getRDVsup($id){
		$sql = "SELECT * FROM rdv WHERE idRDV = :id";
		
		$req = $this->pdo->prepare($sql);
		$req->bindParam(':id', $id, PDO::PARAM_INT);
		$req->execute();
		
		return $req->fetchAll(PDO::FETCH_ASSOC);
	}
	public function ajouterRdv($dateHeure, $idMedecin, $idPatient){
		$sql = "INSERT INTO rdv (dateHeureRdv, idMedecin, idPatient) VALUES (:dateHeure, :idMedecin, :idPatient)";
		$req = $this->pdo->prepare($sql);
		$req->bindParam(':dateHeure', $dateHeure, PDO::PARAM_STR);
		$req->bindParam(':idMedecin', $idMedecin, PDO::PARAM_INT);
		$req->bindParam(':idPatient', $idPatient, PDO::PARAM_INT);
		return $req->execute();
	}
	public function modifierRdv($id, $dateHeure = null, $idMedecin = null, $idPatient = null){
		$sql = "UPDATE rdv SET idRdv = :id";
		
		if($dateHeure != null) {
			$sql .= ", dateHeureRdv = :dateHeure";
		}
		if($idMedecin != null){
			$sql .= ", idMedecin = :idMedecin";
		}
		if($idPatient != null){
			$sql .= ", idPatient = :idPatient";
		}

		$sql .= " WHERE idRdv = :id ";
		$req = $this->pdo->prepare($sql);
		$req->bindParam(':id', $id, PDO::PARAM_STR);

		if($dateHeure != null) {
			$req->bindParam(':dateHeure', $dateHeure, PDO::PARAM_STR);
		}
		if($idMedecin != null) {
			$req->bindParam(':idMedecin', $idMedecin, PDO::PARAM_INT);
		}
		if($idPatient != null) {
			$req->bindParam(':idPatient', $idPatient, PDO::PARAM_INT);
		}

		return $req->execute();
	}
	public function supprimerRdv($id) {
		$sql = "DELETE FROM rdv WHERE idRdv = :id";
		
		$req = $this->pdo->prepare($sql);
		$req->bindParam(':id', $id, PDO::PARAM_INT);
		return $req->execute();
	}
}