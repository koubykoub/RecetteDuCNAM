<?php
	// includes
	include_once (dirname(__FILE__) . '/commun/LoginControleur.class.php');
	include_once (dirname(__FILE__) . '/commun/RecetteControleur.class.php');
	
	
	// donnees du controleur
	// login
	$donneesControleur['identification'] = LoginControleur::Identification();
	$donneesControleur['deconnexion'] = LoginControleur::Deconnexion();
	// destruction recette
	$donneesControleur['detruire_recette'] = RecetteControleur::DestructionRecette();
	
	
	// modele
	include_once (dirname(__FILE__) . '/../modeles/Accueil.inc.php');
	
	// vue
	include_once (dirname(__FILE__) . '/../vues/Accueil.inc.php');
