<?php
// include
	include_once (dirname(__FILE__) . '/AppException.class.php');
	
	// exceptions de creation de compte
	class RequeteExcepBase extends AppException
	{
		// constructeur
		public function __construct($message)
		{
			$mess = parent::CreateMessage('accueil', 'Requête', $message, "Retour à l'accueil");
			parent::__construct($mess);
		}
		
	}
	
	// page inconnue
	class PageInconnueExcep extends RequeteExcepBase
	{
		// constructeur
		public function __construct($mess)
		{
			parent::__construct('Page inconnue :<br /><span>' . $mess . '</span>.');
		}
	
	}
	
	// exceptions de requetes
	class RequeteDonneeManquanteExcep extends RequeteExcepBase
	{
		// constructeur
		public function __construct($donnee)
		{
			parent::__construct('Donnée de requete manquante :<br /><span>' . $donnee . '</span>.');
		}
	}
	
	// action inconnue
	class RequeteActionInconnueExcep extends RequeteExcepBase
	{
		// constructeur
		public function __construct($donnee)
		{
			parent::__construct('Action inconnue :<br /><span>' . $donnee . '</span>.');
		}
	}
