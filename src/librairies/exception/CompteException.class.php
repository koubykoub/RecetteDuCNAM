<?php
	// include
	include_once (dirname(__FILE__) . '/AppException.class.php');
	
	// exceptions de creation de compte
	class CompteExcepBase extends AppException
	{
		// constructeur
		public function __construct($message, $maj)
		{
			if ($maj)
				$mess = parent::CreateMessage('modifier_compte', 'saisie de compte', $message, "Retour à la modification du compte");
			else
				$mess = parent::CreateMessage('creer_compte', 'saisie de compte', $message, "Retour à la creation du compte");
			parent::__construct($mess);
		}
		
	}
	
	class CompteDonneeManquanteExcep extends CompteExcepBase
	{
		// constructeur
		public function __construct($donnee, $maj)
		{
			parent::__construct("Donnée manquante pour la création d'un compte :<br /><span>" . $donnee . '</span>.', $maj);
		}
	
	}
	
	class CompteDonneeInvalideExcep extends CompteExcepBase
	{
		// constructeur
		public function __construct($donnee, $maj)
		{
			parent::__construct("Donnée invalide pour la création d'un compte :<br /><span>" . $donnee . '</span>.', $maj);
		}
	
	}
	
	class CompteIsNotStrExcep extends CompteExcepBase
	{
		// constructeur
		public function __construct($donnee, $maj)
		{
			parent::__construct('Le champs <span>' . $donnee . '</span> devrait être une chaîne de caractères.', $maj);
		}
	}
	
	class CompteCaractereInvalideExcep extends CompteExcepBase
	{
		// constructeur
		public function __construct($donnee, $validChar, $maj)
		{
			parent::__construct('Le champs <span>' . $donnee . '</span> ne peut contenir que les caractères suivant :<br />' . $validChar . '</span>.', $maj);
		}
	
	}
	
	class CompteChaineTropPetiteExcep extends CompteExcepBase
	{
		// constructeur
		public function __construct($donnee, $min, $maj)
		{
			parent::__construct('Le champs <span>' . $donnee . '</span> ne contient pas assez de caractères (<span>' . $min . '</span> minimum).', $maj);
		}
	
	}
	
	class CompteChaineTropGrandeExcep extends CompteExcepBase
	{
		// constructeur
		public function __construct($donnee, $max, $maj)
		{
			parent::__construct('Le champs <span>' . $donnee . '</span> contient trop de caractères (<span>' . $max. '</span> maximum).', $maj);
		}
	
	}
	
	class CompteRepMDPInvalideExcep extends CompteExcepBase
	{
		// constructeur
		public function __construct($maj)
		{
			parent::__construct('Le mot de passe a mal été répété.', $maj);
		}
	}
	
	class CompteAncienMDPInvalideExcep extends CompteExcepBase
	{
		// constructeur
		public function __construct($maj)
		{
			parent::__construct('Ancien mot de passe incorrecte.', $maj);
		}
	}
	
	class CompteLoginExistantExcep extends CompteExcepBase
	{
		// constructeur
		public function __construct($login, $maj)
		{
			parent::__construct("L'identifiant <span>" . $login . "</span> existe déjà.", $maj);
		}
	}
	