<?php
	// include
	include_once (dirname(__FILE__) . '/../librairies/dao/Connexion.class.php');
	include_once (dirname(__FILE__) . '/commun/LoginModele.class.php');
	include_once (dirname(__FILE__) . '/../librairies/exception/SessionException.class.php');
	
	
	// connexion a la base de donnee
	$conn = new Connexion(SERVEUR, USER, PWD);
	ModeleBase::SetConnexion($conn);
	
	
	// donnees du modele
	// login
	$donneesModele['identification'] = LoginModele::IdentificationSession();
	if (!$donneesModele['identification']['identifie']) throw new SessionExpireeExcep();
	$donneesModele['compte_session'] = LoginModele::SessionCompteCreation();
