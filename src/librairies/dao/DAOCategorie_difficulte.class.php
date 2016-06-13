<?php
	include_once (dirname(__FILE__) . '/DAO.class.php');
	include_once (dirname(__FILE__) . '/DAORecette.class.php');
	
	final class DAOCategorie_difficulte extends DAO
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
			SELECT id, intitule
			FROM v_categorie_difficulte
			ORDER BY id
SQL;
			return $this->RetrieveAllGen($sql);
		}
		
		public function RetrieveById($id)
		{
			$sql =
<<<SQL
			SELECT id, intitule
			FROM v_categorie_difficulte
			WHERE id = :id
SQL;
			$resultat = $this->Prepare($sql);
			$resultat->bindParam('id', $id, PDO::PARAM_INT);
			$resultat->execute();
			return $this->RetrieveGenEx($resultat);
		}
		
		public function RetrieveRandom()
		{
			$sql =
<<<SQL
			SELECT id, intitule
			FROM v_categorie_difficulte
			ORDER BY RAND()
			LIMIT 1
SQL;
			return $this->RetrieveGen($sql);
		}
		
		// update
		public function Update($obj)
		{
			// modification d'une recette
			$sql =
<<<SQL
			UPDATE v_categorie_difficulte SET intitule = :intitule
			WHERE v_categorie_difficulte.id = :id
SQL;
			$resultat = $this->Prepare($sql);
			$resultat->bindParam('intitule', $obj['intitule'], PDO::PARAM_STR);
			$resultat->bindParam('id', $obj['id'], PDO::PARAM_INT);
			$resultat->execute();
			return $obj['id'];
		}
		
		// create
		public function Create($obj)
		{
			// execute la requette
			$sql =
<<<SQL
			INSERT INTO v_categorie_difficulte (intitule)
			VALUES (:intitule)
SQL;
			$resultat = $this->Prepare($sql);
			$resultat->bindParam('intitule', $obj['intitule'], PDO::PARAM_STR);
			$resultat->execute();
			return $this->connexion->GetDB()->lastInsertId();
		}
		
		// delete
		public function Delete($obj)
		{
			// modifie les recette dependant de la categorie
			$daoRec = new DAORecette($this->connexion);
			$daoRec->UpdateRemoveCategorieDiff($obj['id']);
		
			// execute la requette
			$sql =
<<<SQL
			DELETE FROM v_categorie_difficulte
			WHERE v_categorie_difficulte.id = :idCat
SQL;
			$resultat = $this->Prepare($sql);
			$resultat->bindParam('idCat', $obj['id'], PDO::PARAM_INT);
			return $resultat->execute();
		}
		
	}
