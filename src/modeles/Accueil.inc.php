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
	// destruction compte
	$donneesModele['detruire_compte'] = FALSE;
	if ($donneesControleur['detruire_compte'])
	{
		$donneesModele['detruire_compte_succes'] = LoginModele::DestructionCompte();
		$donneesModele['detruire_compte'] = TRUE;
	}
	// login
	if ($donneesControleur['deconnexion']) $donneesModele['identification'] = LoginModele::Deconnexion();
	else $donneesModele['identification'] = LoginModele::Identification($donneesControleur['identification']);
	// categories / sous categories
	$donneesModele['categories'] = CritereModele::Categories();
	// destruction recette
	$donneesModele['detruire_recette'] = FALSE;
	if ($donneesControleur['detruire_recette'])
	{
		$donneesModele['detruire_recette_succes'] = RecetteModele::DestructionRecette();
		$donneesModele['detruire_recette'] = TRUE;
	}
	// random recette
	$donneesModele['critere'] = CritereModele::CritereRechercheToutes();
	$donneesModele['recette_random'] = RecetteModele::RandomRecette($donneesModele['critere']);
