<?php
	// include
	include_once (dirname(__FILE__) . '/ModeleBase.class.php');
	include_once (dirname(__FILE__) . '/../../librairies/dao/DAOCommentaire.class.php');
	
	// model des commentaires
	class CommentaireModele extends ModeleBase
	{
		public static function CreerCommentaire($comm, $idUt, $idRec)
		{
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
		
	}
