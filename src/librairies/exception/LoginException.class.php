<?php
	// include
	include_once (dirname(__FILE__) . '/AppException.class.php');

	// exceptions d'identification
	class LoginIncorrectExcep extends AppException
	{
		// constructeur
		public function __construct()
		{
			$message = parent::CreateMessage('accueil', 'retour_accueil', "L'identifiant ou le mot de passe est incorrect.", "Retour à l'accueil");
			parent::__construct($message);
		}
	}
	
	class LoginIdentificationExcep extends AppException
	{
		// constructeur
		public function __construct()
		{
			$message = parent::CreateMessage('accueil', 'retour_accueil', "Vous n'êtes pas identifié.", "Retour à l'accueil");
			parent::__construct($message);
		}
	}
