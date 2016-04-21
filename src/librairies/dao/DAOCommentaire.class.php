<?php
	include_once (dirname(__FILE__) . '/DAO.class.php');
	
	final class DAOCommentaire extends DAO
	{
		// constructeur
		public function __construct($connexion)
		{
			parent::__construct($connexion);
		}
		
		// CRUD
		// retrieve
		public function RetrieveAll()
		{
			$sql =
<<<SQL
			SELECT id_utilisateur, id_recette, texte_commentaire, valeur_note, date_commentaire
			FROM v_commentaire
SQL;
			return $this->RetrieveAllGen($sql);
		}
		
		public function RetrieveByRecette($idRec)
		{
			$sql =
<<<SQL
			SELECT id_utilisateur, id_recette, texte_commentaire, valeur_note, date_commentaire
			FROM v_commentaire
			WHERE id_recette = :id_recette
			ORDER BY date_commentaire DESC
SQL;
			$resultat = $this->Prepare($sql);
			$resultat->bindParam('id_recette', $idRec, PDO::PARAM_INT);
			$resultat->execute();
			return $this->RetrieveAllGenEx($resultat);
		}
		
		public function RetrieveByUtilisateurAndRecette($idUt, $idRec)
		{
			$sql =
<<<SQL
			SELECT id_utilisateur, id_recette, texte_commentaire, valeur_note, date_commentaire
			FROM v_commentaire
			WHERE id_utilisateur = :idUt
				AND id_recette = :idRec
SQL;
			$resultat = $this->Prepare($sql);
			$resultat->bindParam('idUt', $idUt, PDO::PARAM_INT);
			$resultat->bindParam('idRec', $idRec, PDO::PARAM_INT);
			$resultat->execute();
			return $this->RetrieveGenEx($resultat);
		}
		
		// create
		public function Create($comm)
		{
			// execute la requette
			$sql =
<<<SQL
			INSERT INTO v_commentaire (id_utilisateur, id_recette, texte_commentaire, valeur_note, date_commentaire)
			VALUES (:id_utilisateur, :id_recette, :texte_commentaire, :valeur_note, :date_commentaire)
SQL;
			$resultat = $this->Prepare($sql);
			self::BindCommentaireBase($resultat, $comm);
			$resultat->execute();
			return $this->connexion->GetDB()->lastInsertId();
		}
		
		// update
		public function Update($comm)
		{
			// execute la requette
			$sql =
<<<SQL
			UPDATE v_commentaire SET texte_commentaire = :texte_commentaire, valeur_note = :valeur_note, date_commentaire = :date_commentaire
			WHERE v_commentaire.id_utilisateur = :id_utilisateur
				AND v_commentaire.id_recette = :id_recette
SQL;
			$resultat = $this->Prepare($sql);
			self::BindCommentaireBase($resultat, $comm);
			$resultat->execute();
			return $this->connexion->GetDB()->lastInsertId();
		}
		
		// delete
		public function DeleteByRecette($idRec)
		{
			// execute la requette
			$sql =
<<<SQL
			DELETE FROM v_commentaire
			WHERE v_commentaire.id_recette = :idRec
SQL;
			$resultat = $this->Prepare($sql);
			$resultat->bindParam('idRec', $idRec, PDO::PARAM_INT);
			$resultat->execute();
		}
		
		public function DeleteByUtilisateurAndRecette($idUt, $idRec)
		{
			// execute la requette
			$sql =
<<<SQL
			DELETE FROM v_commentaire
			WHERE v_commentaire.id_utilisateur = :idUt
				AND v_commentaire.id_recette = :idRec
SQL;
			$resultat = $this->Prepare($sql);
			$resultat->bindParam('idUt', $idUt, PDO::PARAM_INT);
			$resultat->bindParam('idRec', $idRec, PDO::PARAM_INT);
			return $resultat->execute();
		}
		
		// statistiques
		public function GetStatistiqueByRecette($idRec)
		{
			// execute la requette
			$sql =
<<<SQL
			SELECT COUNT(*) "nb_note", AVG(valeur_note) "moyenne_note"
			FROM v_commentaire
			WHERE id_recette = :isRec
SQL;
			$resultat = $this->Prepare($sql);
			$resultat->bindParam('isRec', $idRec, PDO::PARAM_INT);
			$resultat->execute();
			return $this->RetrieveGenEx($resultat);
		}
		
		
		// fonctions privees
		private static function BindCommentaireBase(&$resultat, $comm)
		{
			$resultat->bindParam('id_utilisateur', $comm['id_utilisateur'], PDO::PARAM_INT);
			$resultat->bindParam('id_recette', $comm['id_recette'], PDO::PARAM_INT);
			$resultat->bindParam('texte_commentaire', $comm['texte_commentaire'], PDO::PARAM_STR);
			$resultat->bindParam('valeur_note', $comm['valeur_note'], PDO::PARAM_INT);
			$resultat->bindParam('date_commentaire', $comm['date_commentaire'], PDO::PARAM_STR);
		}
		
	}
