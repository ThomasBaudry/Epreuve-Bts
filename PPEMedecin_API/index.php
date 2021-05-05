<?php
session_start();

// Test de connexion à la base
$config = parse_ini_file("config.ini");
try {
	$pdo = new \PDO("mysql:host=".$config["host"].";dbname=".$config["database"].";charset=utf8", $config["user"], $config["password"]);
} catch(Exception $e) {
	echo "<h1>Erreur de connexion à la base de données :</h1>";
	echo $e->getMessage();
	exit;
}

// Chargement des fichiers MVC
require("control/controleur.php");
require("view/vue.php");
require("model/patient.php");
require("model/rdv.php");
require("model/verif.php");

//Routes
if(isset($_GET["action"])) {
	switch($_GET["action"]) {
		case "rdv":
			switch($_SERVER["REQUEST_METHOD"]) {
				case "GET":
					(new controleur)->afficherRDV();
					break;
				case "POST":
					(new controleur)->ajouterRDV();
					break;
				case "PUT":
					(new controleur)->modifierRDV();
					break;
				case "DELETE":
					(new controleur)->supprimerRDV();
					break;

			}
			break;
		case "patient":
			switch($_SERVER["REQUEST_METHOD"]){
				case "POST":
					(new controleur)->inscriptionPatient();
					break;
				case "GET":
					(new controleur)->afficherPatient();
					break;
			}		
		break;

		case "connexion":
		switch($_SERVER["REQUEST_METHOD"]){
				case "POST":
					(new controleur)->connexion();
					break;
			}
			break;

		// Route par défaut : erreur 404
		default:
			(new controleur)->erreur404();
			break;
	}
}
else {
	// Pas d'action précisée = afficher l'accueil
	$json = '{ "code":200, "message": "TU AS MAL ECRIT L\'URL BANANE" }';
	(new vue)->afficherJSON($json);
}
?>