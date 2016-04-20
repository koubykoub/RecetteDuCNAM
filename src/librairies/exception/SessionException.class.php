<?php
	// include
	include_once (dirname(__FILE__) . '/AppException.class.php');

	// exception de session
	class SessionDonneeManquanteExcep extends AppException
	{
		// constructeur
		public function __construct($donnee)
		{
			$message = parent::CreateMessage('accueil', 'retour_accueil', 'Donnée de session manquante :<br /><span>' . $donnee . '</span>.', "Retour à l'accueil");
			parent::__construct($message);
		}
	}
	
	class SessionExpireeExcep extends AppException
	{
		// constructeur
		public function __construct()
		{
			$message = parent::CreateMessage('accueil', 'retour_accueil', 'La session a expiré.', "Retour à l'accueil");
			parent::__construct($message);
		}
	}