<?php
	// includes
	include_once (dirname(__FILE__) . '/commun/CritereControleur.class.php');
	
	
	// donnees du controleur
	// gestion des categories
	$donneesControleur['gestion_categorie'] = CritereControleur::GestionCategorie();
	
	
	// modele
	include_once (dirname(__FILE__) . '/../modeles/Gerer_categories.inc.php');
	
	// vue
	include_once (dirname(__FILE__) . '/../vues/Gerer_categories.inc.php');
