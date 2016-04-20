<?php
	// include
	include_once (dirname(__FILE__) . '/../../librairies/exception/RequeteException.class.php');

	// controleur de critere
	class CommentaireControleur
	{
		// commentaire
		public static function Commentaire()
		{
			$donnees['creer_commentaire'] = FALSE;
			if (isset($_REQUEST['commentaire_texte']) && isset($_REQUEST['commentaire_note']))
			{
				$donnees['creer_commentaire'] = TRUE;
				// texte
				if (!is_null($_REQUEST['commentaire_texte'])) $donnees['texte_commentaire'] = $_REQUEST['commentaire_texte'];
				else throw new RequeteDonneeManquanteExcep('commentaire_texte');
				// note
				if (!is_null($_REQUEST['commentaire_note'])) $donnees['valeur_note'] = $_REQUEST['commentaire_note'];
				else throw new RequeteDonneeManquanteExcep('valeur_note');
			}
			
			return $donnees;
		}
		
		public static function DetruireCommentaire()
		{
			return isset($_REQUEST['detruire_commentaire']);
		}
		
	}
