<?php
	// include
	include_once (dirname(__FILE__) . '/../librairies/dao/Connexion.class.php');
	include_once (dirname(__FILE__) . '/commun/LoginModele.class.php');
	include_once (dirname(__FILE__) . '/commun/CritereModele.class.php');
	include_once (dirname(__FILE__) . '/commun/RecetteModele.class.php');
	
	
	// connexion a la base de donnee
	$conn = new Connexion(SERVEUR, USER, PWD);
	ModeleBase::SetConnexion($conn);
	
	
	// donnees du modele
	// login
	$donneesModele['identification'] = LoginModele::IdentificationSession();
	$donneesModele['creation_compte'] = FALSE;
	if (!$donneesModele['identification']['identifie'])
	{
		// creer compte
		$donneesModele['creation_compte'] = $donneesControleur['compte']['creation_compte'];
		if ($donneesModele['creation_compte']) $donneesModele['identification']['utilisateur'] = LoginModele::CreerCompte($donneesControleur['compte']);
		else throw new CompteDonneeManquanteExcep(); 
	}
	// categorie
	$donneesModele['categories'] = CritereModele::Categories();
	$donneesModele['categories_difficulte'] = CritereModele::CategoriesDif();
	$donneesModele['categories_prix'] = CritereModele::CategoriesPrix();
	// recette
	$donneesModele['recette_en_creation'] = RecetteModele::SessionRecetteCreation();
