<?php
	// include
	include_once (dirname(__FILE__) . '/../librairies/dao/Connexion.class.php');
	include_once (dirname(__FILE__) . '/commun/LoginModele.class.php');
	include_once (dirname(__FILE__) . '/commun/CritereModele.class.php');
	include_once (dirname(__FILE__) . '/commun/RecetteModele.class.php');
	include_once (dirname(__FILE__) . '/../librairies/exception/SessionException.class.php');
	
	
	// connexion a la base de donnee
	$conn = new Connexion(SERVEUR, USER, PWD);
	ModeleBase::SetConnexion($conn);
	
	
	// donnees du modele
	// login
	$donneesModele['identification'] = LoginModele::IdentificationSession();
	if (!$donneesModele['identification']['identifie']) throw new SessionExpireeExcep();
	// categorie
	$donneesModele['categories'] = CritereModele::Categories();
	$donneesModele['categories_difficulte'] = CritereModele::CategoriesDif();
	$donneesModele['categories_prix'] = CritereModele::CategoriesPrix();
	// recette
	$donneesModele['recette'] = RecetteModele::RecetteSession();
	$donneesModele['recette_en_creation'] = RecetteModele::SessionRecetteCreation();
	if ($donneesModele['recette_en_creation']['existe'])
	{
		if (isset($donneesModele['recette']['photo']))
			$donneesModele['recette_en_creation']['recette']['photo'] = $donneesModele['recette']['photo'];
		$donneesModele['recette'] = $donneesModele['recette_en_creation']['recette'];
	}
	RecetteModele::PrevModifierRecette();
