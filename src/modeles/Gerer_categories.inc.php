<?php
	// include
	include_once (dirname(__FILE__) . '/commun/CritereModele.class.php');
	
	
	// connexion a la base de donnee
	$conn = new Connexion(SERVEUR, USER, PWD);
	ModeleBase::SetConnexion($conn);
	
	
	// donnees du modele
	// categories
	$donneesModele['categories'] = CritereModele::Categories();
	$donneesModele['categories_prix'] = CritereModele::CategoriesPrix();
	$donneesModele['categories_difficulte'] = CritereModele::CategoriesDif();
	