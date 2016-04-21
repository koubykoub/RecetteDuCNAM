<?php
	// include
	include_once (dirname(__FILE__) . '/AppException.class.php');

	// exceptions de gestion des images
	class ImageExcepBase extends AppException
	{
		// constructeur
		public function __construct($message)
		{
			$mess = parent::CreateMessage('accueil', 'Image', $message, "Retour à l'accueil");
			parent::__construct($mess);
		}
	
	}
	
	class ImageCreationExcep extends ImageExcepBase
	{
		// constructeur
		public function __construct()
		{
			parent::__construct('Impossible de creer l\'image.');
		}
	}
	