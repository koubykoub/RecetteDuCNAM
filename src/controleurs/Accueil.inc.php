<?php
	// includes
	include_once (dirname(__FILE__) . '/commun/LoginControleur.class.php');
	
	
	// donnees du controleur
	// login
	$donneesControleur['identification'] = LoginControleur::Identification();
	$donneesControleur['deconnexion'] = LoginControleur::Deconnexion();
	
	
	// modele
	include_once (dirname(__FILE__) . '/../modeles/Accueil.inc.php');
	
	// vue
	include_once (dirname(__FILE__) . '/../vues/Accueil.inc.php');
