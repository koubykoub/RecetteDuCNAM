<?php
	include_once (dirname(__FILE__) . '/DAO.class.php');

	final class DAOIngredient extends DAO
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
			SELECT id, id_recette, texte_ingredient
			FROM v_ingredient
SQL;
			return $this->RetrieveAllGen($sql);
		}
		
		public function RetrieveAllByRecette($idRec)
		{
			$sql =
<<<SQL
			SELECT id, id_recette, texte_ingredient
			FROM v_ingredient
			WHERE id_recette = :id_recette
			ORDER BY id
SQL;
			$resultat = $this->Prepare($sql);
			$resultat->bindParam('id_recette', $idRec, PDO::PARAM_INT);
			$resultat->execute();
			return $this->RetrieveAllGenEx($resultat);
		}
		
		// create
		public function Create($obj)
		{
			$sql =
<<<SQL
			INSERT INTO v_ingredient (id, id_recette, texte_ingredient)
			VALUES (:id, :id_recette, :texte_ingredient)
SQL;
			$resultat = $this->Prepare($sql);
			$resultat->bindParam('id', $obj['id'], PDO::PARAM_INT);
			$resultat->bindParam('id_recette', $obj['id_recette'], PDO::PARAM_INT);
			$resultat->bindParam('texte_ingredient', $obj['texte_ingredient'], PDO::PARAM_STR);
			$resultat->execute();
			return $this->connexion->GetDB()->lastInsertId();
		}
		
		// delete
		public function DeleteByRecette($idRec)
		{
			$sql =
<<<SQL
			DELETE FROM v_ingredient
			WHERE v_ingredient.id_recette = :idRec
SQL;
			$resultat = $this->Prepare($sql);
			$resultat->bindParam('idRec', $idRec, PDO::PARAM_INT);
			return $resultat->execute();
		}
		
	}
