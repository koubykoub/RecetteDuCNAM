<?php
	// include
	include_once (dirname(__FILE__) . '/AppException.class.php');
	
	// exceptions de creation de compte
	class RecetteExcepBase extends AppException
	{
		// constructeur
		public function __construct($message, $maj)
		{
			if ($maj)
				$mess = parent::CreateMessage('modifier_recette', 'saisie de recette', $message, "Retour à la modification de la recette");
			else
				$mess = parent::CreateMessage('creer_recette', 'saisie de recette', $message, "Retour à la creation de la recette");
			parent::__construct($mess);
		}
		
	}
	
	class RecetteDonneeManquanteExcep extends RecetteExcepBase
	{
		// constructeur
		public function __construct($donnee, $maj)
		{
			parent::__construct("Donnée manquante pour la création d'une recette :<br /><span>" . $donnee . '</span>.', $maj);
		}
	
	}
	
	class RecetteDonneeInvalideExcep extends RecetteExcepBase
	{
		// constructeur
		public function __construct($donnee, $maj)
		{
			parent::__construct("Donnée invalide pour la création d'une recette :<br /><span>" . $donnee . '</span>.', $maj);
		}
	
	}

	class RecetteIsNotStrExcep extends RecetteExcepBase
	{
		// constructeur
		public function __construct($donnee, $maj)
		{
			parent::__construct('Le champs <span>' . $donnee . '</span> devrait être une chaîne de caractères.', $maj);
		}
	}
	
	class RecetteIsNotNumberExcep extends RecetteExcepBase
	{
		// constructeur
		public function __construct($donnee, $maj)
		{
			parent::__construct('Le champs <span>' . $donnee . '</span> devrait être un nombre.', $maj);
		}
	}
	
	class RecetteChaineTropPetiteExcep extends RecetteExcepBase
	{
		// constructeur
		public function __construct($donnee, $min, $maj)
		{
			parent::__construct('Le champs <span>' . $donnee . '</span> ne contient pas assez de caractères :<br /><span>' . $min . '</span> minimum.', $maj);
		}
	
	}
	
	class RecetteChaineTropGrandeExcep extends RecetteExcepBase
	{
		// constructeur
		public function __construct($donnee, $max, $maj)
		{
			parent::__construct('Le champs <span>' . $donnee . '</span> contient trop de caractères :<br /><span>' . $max. '</span> maximum.', $maj);
		}
	
	}
	
	class RecetteNombreTropPetitExcep extends RecetteExcepBase
	{
		// constructeur
		public function __construct($donnee, $min, $maj)
		{
			parent::__construct('Le champs <span>' . $donnee . '</span> contient un nombre trop petit :<br /><span>' . $min . '</span> minimum.', $maj);
		}
	
	}
	
	class RecetteNombreTropGrandExcep extends RecetteExcepBase
	{
		// constructeur
		public function __construct($donnee, $max, $maj)
		{
			parent::__construct('Le champs <span>' . $donnee . '</span> contient un nombre trop grand :<br /><span>' . $max. '</span> maximum.', $maj);
		}
	
	}
	
	class RecetteQuantiteTropPetiteExcep extends RecetteExcepBase
	{
		// constructeur
		public function __construct($donnee, $min, $maj)
		{
			parent::__construct('Le nombre de champs <span>' . $donnee . '</span> est trop basse :<br /><span>' . $min. '</span> minimum.', $maj);
		}
	
	}
	
	class RecetteQuantiteTropGrandeExcep extends RecetteExcepBase
	{
		// constructeur
		public function __construct($donnee, $max, $maj)
		{
			parent::__construct('Le nombre de champs <span>' . $donnee . '</span> est trop élevé :<br /><span>' . $max. '</span> maximum.', $maj);
		}
	
	}
	