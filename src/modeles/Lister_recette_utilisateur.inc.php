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
	// categories / sous categories
	$donneesModele['categories'] = CritereModele::Categories();
	// page action
	if (!is_null($donneesControleur['lister_page_action'])) $donneesModele['recette_page'] = RecetteModele::PageAction($donneesControleur['lister_page_action']);
	elseif (!is_null($donneesControleur['critere'])) $donneesModele['recette_page'] = RecetteModele::PageReset();
	elseif (RecetteModele::IsPrevListerRecette())$donneesModele['recette_page'] = RecetteModele::PageReset();
	else $donneesModele['recette_page'] = RecetteModele::PageCourante();
	RecetteModele::PrevListerRecetteUtilisateur();
	// liste de recette
	$donneesModele['critere'] = CritereModele::CritereRecherche($donneesControleur['critere']);
	CritereModele::CritereRechercheDonnees($donneesModele['critere']);
	$donneesModele['liste_recettes'] = RecetteModele::ListeRecettes($donneesModele['critere'], $donneesModele['recette_page'], $donneesModele['identification']['utilisateur']['id']);
	// random recette
	$donneesModele['recette_random'] = RecetteModele::RandomRecette($donneesModele['critere'], $donneesModele['identification']['utilisateur']['id']);
