<?php
	// include
	include_once (dirname(__FILE__) . '/commun/CritereModele.class.php');
	
	
	// connexion a la base de donnee
	$conn = new Connexion(SERVEUR, USER, PWD);
	ModeleBase::SetConnexion($conn);
	
	
	// donnees du modele
	// gestion categories
	CritereModele::GestionCategorie($donneesControleur['gestion_categorie']);
	// categories
	$donneesModele['categories'] = CritereModele::Categories(FALSE);
	$donneesModele['categories_prix'] = CritereModele::CategoriesPrix();
	$donneesModele['categories_difficulte'] = CritereModele::CategoriesDif();
	