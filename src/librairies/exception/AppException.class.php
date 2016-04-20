<?php
	// class de base
	class AppException extends Exception
	{
		// constructeur
		public function __construct($message)
		{
			parent::__construct($message);
		}
		
		// message
		protected static function CreateMessage($page, $form, $mess, $lien)
		{
			$message = '<p>' . $mess . '</p>'."\n";
			$message .= '<form method="post" action="" name="' . $form . '">'."\n";
			$message .= "\t".'<input type="hidden" name="page" id="page" value="' . $page . '" />'."\n";
			$message .= "\t".'<a href="javascript:document.' . $form . '.submit();">' . $lien . '</a>'."\n";
			$message .= '</form>';
			return $message;
		}
		
	}
	
	class DAOErreurExcep extends AppException
	{
		// constructeur
		public function __construct($message)
		{
			parent::__construct(parent::CreateMessage('accueil', 'retour_accueil', 'Erreur interne :<br /><span>' . $message . '</span>.', 'Retour à l\'accueil'));
		}
	}

