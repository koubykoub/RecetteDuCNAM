<?php
	// includes
	include_once (dirname(__FILE__) . '/commun/LoginControleur.class.php');
	include_once (dirname(__FILE__) . '/commun/CritereControleur.class.php');
	
	
	// donnees du controleur
	// critere de recettes
	$donneesControleur['lister_page_action'] = CritereControleur::ListerPageAction();
	$donneesControleur['critere'] = CritereControleur::Criteres();


	// modele
	include_once (dirname(__FILE__) . '/../modeles/Lister_recette_utilisateur.inc.php');
	
	// vue
	include_once (dirname(__FILE__) . '/../vues/Lister_recette_utilisateur.inc.php');
