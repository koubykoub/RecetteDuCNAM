<?php
	// include
	include_once (dirname(__FILE__) . '/ModeleBase.class.php');
	include_once (dirname(__FILE__) . '/../../librairies/dao/DAOCommentaire.class.php');
	include_once (dirname(__FILE__) . '/../../librairies/exception/CommentaireException.class.php');
	
	// model des commentaires
	class CommentaireModele extends ModeleBase
	{
		public static function CreerCommentaire($comm, $idUt, $idRec)
		{
			// validation du commentaire
			self::ValidationCommentaire($comm);
			
			// creation donnees commentaire
			$commentaire['id_utilisateur'] = $idUt;
			$commentaire['id_recette'] = $idRec;
			$commentaire['texte_commentaire'] = $comm['texte_commentaire'];
			$commentaire['valeur_note'] = $comm['valeur_note'];
			$dt = new DateTime();
			$commentaire['date_commentaire'] = $dt->format('Y-m-d H:i:s');
			
			// verification de l'existance du commentaire
			$daoComm = new DAOCommentaire(parent::GetConnexion());
			$tmpComm = $daoComm->RetrieveByUtilisateurAndRecette($idUt, $idRec);
			
			// creation
			if (is_null($tmpComm))
				$daoComm->Create($commentaire);
			
			// mise a jour
			else
				$daoComm->Update($commentaire);
		}
		
		public static function CommentaireRecette($idRec)
		{
			// commentaires
			$daoComm = new DAOCommentaire(parent::GetConnexion());
			$comms = $daoComm->RetrieveByRecette($idRec);
				
			// utilisateurs
			$daoUt = new DAOUtilisateur(parent::GetConnexion());
			foreach ($comms as &$comm)
				$comm['utilisateur'] = $daoUt->RetrieveById($comm['id_utilisateur']);
					
			return $comms;
		}
		
		public static function StatistiqueRecette($idRec)
		{
			$daoComm = new DAOCommentaire(parent::GetConnexion());
			$stat = $daoComm->GetStatistiqueByRecette($idRec);
			return $stat;
		}
		
		public static function CommentaireUtilisateur($idUt, $idRec)
		{
			$comm['existe'] = FALSE;
			$daoComm = new DAOCommentaire(parent::GetConnexion());
			$tmpComm = $daoComm->RetrieveByUtilisateurAndRecette($idUt, $idRec);
			if (!is_null($tmpComm))
			{
				$comm['commentaire'] = $tmpComm;
				$comm['existe'] = TRUE;
			}
			return $comm;
		}
		
		public static function DetruireCommentaire($idUt, $idRec)
		{
			$daoComm = new DAOCommentaire(parent::GetConnexion());
			$daoComm->DeleteByUtilisateurAndRecette($idUt, $idRec);
		}
		
		public static function SessionCommentaireCreation($idUt, $idRec)
		{
			parent::StartSession();
			$donnees['existe'] = FALSE;
			if (isset($_SESSION['commentaire_en_creation']))
			{
				if (isset($_SESSION['commentaire_en_creation']['texte_commentaire'])) $donnees['commentaire']['texte_commentaire'] = $_SESSION['commentaire_en_creation']['texte_commentaire'];
				else $donnees['commentaire']['texte_commentaire'] = '';
				if (isset($_SESSION['commentaire_en_creation']['valeur_note'])) $donnees['commentaire']['valeur_note'] = $_SESSION['commentaire_en_creation']['valeur_note'];
				else $donnees['commentaire']['valeur_note'] = 3;
				$donnees['commentaire']['id_utilisateur'] = $idUt;
				$donnees['commentaire']['id_recette'] = $idRec;
				$donnees['existe'] = TRUE;
				unset($_SESSION['commentaire_en_creation']);
			}
			return $donnees;
		}
		
		
		// prive
		private static function ValidationCommentaire(&$comm)
		{
			// sauvegarde du commentaire saisi dans la session
			parent::StartSession();
			unset($_SESSION['commentaire_en_creation']);
			$_SESSION['commentaire_en_creation'] = $comm;
			
			// champs vides et donnees du mauvais type
			if (!is_string($comm['texte_commentaire'])) throw new CommentaireIsNotStrExcep('Commentaire');
			$comm['texte_commentaire'] = trim($comm['texte_commentaire']);
			if (!is_numeric($comm['valeur_note'])) throw new CommentaireIsNotNumberExcep('Note');
			
			// longueur des chaines / taille des nombres
			if (strlen($comm['texte_commentaire']) > COMM_TEXTE_LONGUEUR_MAX) throw new CommentaireChaineTropGrandeExcep('Commentaire', COMM_TEXTE_LONGUEUR_MAX);
			if ($comm['valeur_note'] < COMM_NOTE_MIN) throw new CommentaireNombreTropPetitExcep('Note', COMM_NOTE_MIN);
			if ($comm['valeur_note'] > COMM_NOTE_MAX) throw new CommentaireNombreTropGrandExcep('Note', COMM_NOTE_MAX);
			
			// toutes les donnees sont bien valides donc l'enregistrement en session est detruit
			unset($_SESSION['recette_en_creation']);
		}
		
	}
