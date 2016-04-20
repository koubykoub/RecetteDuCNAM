<?php
	// include
	include_once (dirname(__FILE__) . '/commun/LoginModele.class.php');
	
	
	// donnees du modele
	// login
	$donneesModele['identification'] = LoginModele::SessionCompteCreation();
	