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
		protected static function CreateMessage($page, $type, $mess, $lien)
		{
			$message = '<h3>' . $type . '</h3>'."\n";
			$message .= '<p>' . $mess . '</p>'."\n";
			$message .= '<form method="post" action="" name="retour_' . $page . '">'."\n";
			$message .= "\t".'<input type="hidden" name="page" id="page" value="' . $page . '" />'."\n";
			$message .= "\t".'<a href="javascript:document.retour_' . $page . '.submit();">' . $lien . '</a>'."\n";
			$message .= '</form>';
			return $message;
		}
		
	}
	
	class ErreurInterneExcep extends AppException
	{
		// constructeur
		public function __construct($message)
		{
			parent::__construct(parent::CreateMessage('accueil', 'Erreur interne', '<span>' . $message . '</span>.', 'Retour à l\'accueil'));
		}
	}
	
	class ErreurGeneraleExcep extends AppException
	{
		// constructeur
		public function __construct($message)
		{
			parent::__construct(parent::CreateMessage('accueil', 'Erreur generale', '<span>' . $message . '</span>.', 'Retour à l\'accueil'));
		}
	}

