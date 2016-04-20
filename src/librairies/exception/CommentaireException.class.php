<?php
	// include
	include_once (dirname(__FILE__) . '/AppException.class.php');
	
	// exceptions de creation de compte
	class CommentaireExcepBase extends AppException
	{
		// constructeur
		public function __construct($message)
		{

			$mess = parent::CreateMessage('afficher_recette', 'saisie de commentaire', $message, "Retour à la recette");
			parent::__construct($mess);
		}
	
	}

	class CommentaireIsNotStrExcep extends CommentaireExcepBase
	{
		// constructeur
		public function __construct($donnee)
		{
			parent::__construct('Le champs <span>' . $donnee . '</span> devrait être une chaîne de caractères.');
		}
	}
	
	class CommentaireIsNotNumberExcep extends CommentaireExcepBase
	{
		// constructeur
		public function __construct($donnee)
		{
			parent::__construct('Le champs <span>' . $donnee . '</span> devrait être un nombre.');
		}
	}
	
	class CommentaireChaineTropGrandeExcep extends CommentaireExcepBase
	{
		// constructeur
		public function __construct($donnee, $max)
		{
			parent::__construct('Le champs <span>' . $donnee . '</span> contient trop de caractères :<br /><span>' . $max. '</span> maximum.');
		}
	
	}
	
	class CommentaireNombreTropPetitExcep extends CommentaireExcepBase
	{
		// constructeur
		public function __construct($donnee, $min)
		{
			parent::__construct('Le champs <span>' . $donnee . '</span> contient un nombre trop petit :<br /><span>' . $min . '</span> minimum.');
		}
	
	}
	
	class CommentaireNombreTropGrandExcep extends CommentaireExcepBase
	{
		// constructeur
		public function __construct($donnee, $max)
		{
			parent::__construct('Le champs <span>' . $donnee . '</span> contient un nombre trop grand :<br /><span>' . $max. '</span> maximum.');
		}
	
	}
	