<?php
	// includes
	include_once (dirname(__FILE__) . '/commun/LoginControleur.class.php');
	
	
	// donnees du controleur
	// login
	$donneesControleur['compte'] = LoginControleur::DonneesCompte(FALSE);


	// modele
	include_once (dirname(__FILE__) . '/../modeles/Creer_recette.inc.php');
	
	// vue
	include_once (dirname(__FILE__) . '/../vues/Creer_recette.inc.php');
