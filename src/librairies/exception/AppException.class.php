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
		
		// image
		protected static function GetStrImageError($image)
		{
			switch ($image['error'])
			{
				case UPLOAD_ERR_INI_SIZE :
					return 'La taille du fichier téléchargé ne doit pas excèder la valeur de ' . ini_get('upload_max_filesize') . ' octets, limite configurée dans le site.';
				case UPLOAD_ERR_FORM_SIZE :
					return 'La taille du fichier téléchargé ne doit pas excèder la valeur de ' . IMAGE_UTILISATEUR_SIZE_MAX . ' octets.';
				case UPLOAD_ERR_PARTIAL :
					return 'Le fichier n\'a été que partiellement téléchargé.';
				case UPLOAD_ERR_NO_TMP_DIR :
					return 'Le dossier temporaire est manquant.';
				case UPLOAD_ERR_CANT_WRITE :
					return 'Échec de l\'écriture du fichier sur le disque.';
				case UPLOAD_ERR_EXTENSION :
					return 'Une extension PHP a arrêté l\'envoi de fichier. PHP ne propose aucun moyen de déterminer quelle extension est en cause. L\'examen du phpinfo() peut aider.';
				default :
					return 'Erreur inconnue';
			}
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

