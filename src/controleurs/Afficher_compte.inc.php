<?php
	// includes
	include_once (dirname(__FILE__) . '/commun/LoginControleur.class.php');
	
	
	// donnees du controleur
	// lister utilisateur
	$donneesControleur['lister_utilisateur'] = LoginControleur::ListerUtilisateur();
	// login
	$donneesControleur['compte'] = LoginControleur::DonneesCompte(TRUE);


	// modele
	include_once (dirname(__FILE__) . '/../modeles/Afficher_compte.inc.php');
	
	// vue
	include_once (dirname(__FILE__) . '/../vues/Afficher_compte.inc.php');
