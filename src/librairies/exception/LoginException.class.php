<?php
	// include
	include_once (dirname(__FILE__) . '/AppException.class.php');
	
	// exceptions de creation de compte
	class LoginExcepBase extends AppException
	{
		// constructeur
		public function __construct($message)
		{
			$mess = parent::CreateMessage('accueil', 'Identification', $message, "Retour à l'accueil");
			parent::__construct($mess);
		}
		
	}

	// exceptions d'identification
	class LoginIncorrectExcep extends LoginExcepBase
	{
		// constructeur
		public function __construct()
		{
			parent::__construct("L'identifiant ou le mot de passe est incorrect.");
		}
	}
	
	class LoginIdentificationExcep extends LoginExcepBase
	{
		// constructeur
		public function __construct()
		{
			parent::__construct("Vous n'êtes pas identifié.");
		}
	}
