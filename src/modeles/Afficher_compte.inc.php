<?php
	// include
	include_once (dirname(__FILE__) . '/../librairies/dao/Connexion.class.php');
	include_once (dirname(__FILE__) . '/commun/LoginModele.class.php');
	include_once (dirname(__FILE__) . '/commun/CritereModele.class.php');
	include_once (dirname(__FILE__) . '/../librairies/exception/SessionException.class.php');
	
	
	// connexion a la base de donnee
	$conn = new Connexion(SERVEUR, USER, PWD);
	ModeleBase::SetConnexion($conn);
	
	
	// donnees du modele
	// lister utilisateur
	LoginModele::ListerUtilisateur($donneesControleur['lister_utilisateur']);
	// login
	$donneesModele['identification'] = LoginModele::IdentificationSession();
	if (!$donneesModele['identification']['identifie']) throw new SessionExpireeExcep();
	// categories / sous categories
	$donneesModele['categories'] = CritereModele::Categories();
	// modifier compte
	$donneesModele['creation_compte'] = $donneesControleur['compte']['creation_compte'];
	if ($donneesModele['creation_compte']) $donneesModele['identification']['utilisateur'] = LoginModele::MofifierCompte($donneesControleur['compte'], $donneesModele['identification']['utilisateur']);
