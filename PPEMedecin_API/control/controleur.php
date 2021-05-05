<?php

class controleur {
    public function afficherRDV() {
		if(isset($_GET["id"])) {
			$lesRDV = (new rdv)->getRDV($_GET["id"]);
			if(count($lesRDV) > 0) {
				(new vue)->afficherObjetEnJSON($lesRDV);
			}
			else {
				(new vue)->erreur404();
			}
		}
		else {
			$lesRDV = (new rdv)->getAll();
			(new vue)->afficherObjetEnJSON($lesRDV);
		}
	}
	public function ajouterRDV(){
		$corpsRequete = file_get_contents('php://input');
		
		if($json = json_decode($corpsRequete, true)) {
			
			if(isset($json["dateHeureRdv"]) && isset($json["idMedecin"]) && isset($json["token"])) {
				$verif = (new verif)->verifToken($json["token"], $this->getIp());
				if($verif == true){
					$patient = (new patient)->getPatientWithToken($json["token"], $this->getIp());
					$ajout = (new rdv)->ajouterRDV($json["dateHeureRdv"], $json["idMedecin"], $patient[0]["idPatient"]);
					
					if($ajout === true) {
						http_response_code(201);
						$json = '{ "code":201, "message": "Rendez-vous ajoutée ." }';
						(new vue)->afficherJSON($json);
					}
					else {
						http_response_code(500);
						
						$json = '{ "code":500, "message": "Erreur lors de l\'insertion." }';
						(new vue)->afficherJSON($json);
					}
				}
				else{
					http_response_code(400);
				
					$json = '{ "code":400, "message": "Le token est invalide." }';
					(new vue)->afficherJSON($json);
				}
			}
			else {
				http_response_code(400);
			
				$json = '{ "code":400, "message": "Données manquantes." }';
				(new vue)->afficherJSON($json);
			}
			
		}
		else {
			http_response_code(400);
			
			$json = '{ "code":400, "message": "Le corps de la requête est invalide." }';
			(new vue)->afficherJSON($json);
		}
	}
	public function modifierRDV() {
		$corpsRequete = file_get_contents('php://input');
		
		if($json = json_decode($corpsRequete, true)) {
			if(isset($json["idRdv"]) && count($json) >= 2 && isset($json["token"])) {
				$verif = (new verif)->verifToken($json["token"], $this->getIp());
				if($verif == true){

					$dateHeureRdv = null;
					$idMedecin = null;
					$idPatient = null;
					
					if(isset($json["dateHeureRdv"])) {
						$dateHeureRdv = $json["dateHeureRdv"];
					}
					if(isset($json["idMedecin"])) {
						$idMedecin = $json["idMedecin"];
					}
					if(isset($json["idPatient"])) {
						$idPatient = $json["idPatient"];
					}
					
					$modif = (new rdv)->modifierRDV($json["idRdv"], $dateHeureRdv, $idMedecin, $idPatient);
					
					if($modif === true) {
						http_response_code(200);
						$json = '{ "code":200, "message": "Rendez-vous a l\'id '.$json["idRdv"].' modifiée." }';
						(new vue)->afficherJSON($json);
					}
					else {
						http_response_code(500);
						
						$json = '{ "code":500, "message": "Erreur lors de la modification." }';
						(new vue)->afficherJSON($json);
					}
				}
				else{
					http_response_code(400);
				
					$json = '{ "code":400, "message": "Le token est invalide." }';
					(new vue)->afficherJSON($json);
				}
			}
			else {
				http_response_code(400);
			
				$json = '{ "code":400, "message": "Données manquantes." }';
				(new vue)->afficherJSON($json);
			}
		}
		else {
			http_response_code(400);
			
			$json = '{ "code":400, "message": "Le corps de la requête est invalide." }';
			(new vue)->afficherJSON($json);
		}
	}
	public function supprimerRDV() {
		
		if(isset($_GET["id"])){
			$leRDV = (new rdv)->getRDVsup($_GET["id"]);
			if(count($leRDV) > 0) {
				$supprimer = (new rdv)->supprimerRDV($_GET["id"]);
				
				if($supprimer === true) {
					http_response_code(200);
			
					$json = '{ "code":200, "message": "Le Rendez Vous a été suprimée à l\'id '.$_GET["id"].'." }';
					(new vue)->afficherJSON($json);
				}
				else {
					http_response_code(400);
			
					$json = '{ "code":400, "message": "Impossible de supprimer ce Rendez Vous." }';
					(new vue)->afficherJSON($json);
				}
			}
			else {
				(new vue)->erreur404();
			}
		}
		else {
			http_response_code(400);
			
			$json = '{ "code":400, "message": "Données manquantes." }';
			(new vue)->afficherJSON($json);
		}
	}


	public function inscriptionPatient()
	{
		$corpsRequete = file_get_contents('php://input');
		
		if($json = json_decode($corpsRequete, true)) {
			if(count($json) == 8) 
			{
				$inscription =(new patient)->inscription($json["nomPatient"],$json["prenomPatient"],$json["ruePatient"],$json["cpPatient"],$json["villePatient"],$json["telPatient"],$json["loginPatient"],$json["mdpPatient"]);
				if ($inscription)
				{
					http_response_code(201);
					$json = '{ "code":201, "message": "Patient inscrit" }';
					(new vue)->afficherJSON($json);
				}
				else {
					http_response_code(500);
					
					$json = '{ "code":500, "message": "Erreur lors de l\'insertion." }';
					(new vue)->afficherJSON($json);
				}
			}
			else {
				http_response_code(400);
			
				$json = '{ "code":400, "message": "Données manquantes." }';
				(new vue)->afficherJSON($json);
			}
		}
		else {
			http_response_code(400);
			
			$json = '{ "code":400, "message": "Le corps de la requête est invalide." }';
			(new vue)->afficherJSON($json);
		}
			
	}

	public function connexion()
	{
		$corpsRequete = file_get_contents('php://input');

		if($json = json_decode($corpsRequete, true))
		{
			if(isset($json["loginPatient"]) && isset($json["mdpPatient"]) && isset($json["token"]))
			{
				$connexion = (new patient)->connexion($json["loginPatient"], $json["mdpPatient"], $json["token"], $this->getIp());

				if($connexion === true)
				{
					http_response_code(201);
					$json = '{ "code":201, "message": "Connexion réussi." }';
					(new vue)->afficherJSON($json);
				}
				else
				{
					http_response_code(500);
					$json = '{ "code":500, "message": "Connexion incorrect." }';
					(new vue)->afficherJSON($json);
				}
			}
			else
			{
				http_response_code(400);
			
				$json = '{ "code":400, "message": "Données manquantes." }';
				(new vue)->afficherJSON($json);
			}
		}
		else
		{
			http_response_code(400);
			
			$json = '{ "code":400, "message": "Le corps de la requête est invalide." }';
			(new vue)->afficherJSON($json);
		}
	}

	public function afficherPatient(){
		if(isset($_GET["token"])){
			$lepatient = (new patient)->getPatientWithToken($_GET["token"], $this->getIp());
			if(count($lepatient) > 0) {
				(new vue)->afficherObjetEnJSON($lepatient);
			}
			else {
				(new vue)->erreur404();
			}
		}
	}

	public function getIp(){
		if(!empty($_SERVER['HTTP_CLIENT_IP'])){
			$ip= $_SERVER['HTTP_CLIENT_IP'];
		}
		elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$ip= $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else{
			$ip= $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
	
} 
?>