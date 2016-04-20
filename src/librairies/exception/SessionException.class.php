<?php
	// include
	include_once (dirname(__FILE__) . '/AppException.class.php');
	
	// exceptions de creation de compte
	class SessionExcepBase extends AppException
	{
		// constructeur
		public function __construct($message)
		{
			$mess = parent::CreateMessage('accueil', 'Session', $message, "Retour à l'accueil");
			parent::__construct($mess);
		}
		
	}

	// exception de session
	class SessionDonneeManquanteExcep extends SessionExcepBase
	{
		// constructeur
		public function __construct($donnee)
		{
			parent::__construct('Donnée de session manquante :<br /><span>' . $donnee . '</span>.');
		}
	}
	
	class SessionExpireeExcep extends SessionExcepBase
	{
		// constructeur
		public function __construct()
		{
			parent::__construct('La session a expiré.');
		}
	}