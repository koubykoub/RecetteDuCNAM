<?php
	// include
	include_once (dirname(__FILE__) . '/AppException.class.php');
	
	// page inconnue
	class PageInconnueExcep extends AppException
	{
		// constructeur
		public function __construct($mess)
		{
			$message = parent::CreateMessage('accueil', 'retour_accueil', 'Page inconnue :<br /><span>' . $mess . '</span>.', "Retour à l'accueil");
			parent::__construct($message);
		}
	
	}
	
	// exceptions de requetes
	class RequeteDonneeManquanteExcep extends AppException
	{
		// constructeur
		public function __construct($donnee)
		{
			$message = parent::CreateMessage('accueil', 'retour_accueil', 'Donnée de requete manquante :<br /><span>' . $donnee . '</span>.', "Retour à l'accueil");
			parent::__construct($message);
		}
	}
