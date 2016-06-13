<?php
	// include
	include_once (dirname(__FILE__) . '/AppException.class.php');
	
	// exceptions de session
	class CritereExcepBase extends AppException
	{
		// constructeur
		public function __construct($message)
		{
			$mess = parent::CreateMessage('accueil', 'Catégories', $message, "Retour à l'accueil");
			parent::__construct($mess);
		}
	
	}
	
	// action inconnue
	class CritereActionInconnueExcep extends CritereExcepBase
	{
		// constructeur
		public function __construct($donnee)
		{
			parent::__construct('Action inconnue :<br /><span>' . $donnee . '</span>.');
		}
	}
	
	// intitule non conforme
	class CritereIntituleNonComformeExcep extends CritereExcepBase
	{
		// constructeur
		public function __construct()
		{
			parent::__construct('Intitulé non comforme.');
		}
	}
	
	// type de categorie inconnue
	class CritereTypeInconnueExcep extends CritereExcepBase
	{
		// constructeur
		public function __construct($donnee)
		{
			parent::__construct('Type de catégorie inconnue :<br /><span>' . $donnee . '</span>.');
		}
	}
	
	// id manquante
	class CritereIdManquanteExcep extends CritereExcepBase
	{
		// constructeur
		public function __construct()
		{
			parent::__construct('L\'id de la catégorie est manquante.');
		}
	}
	