<?php
	include_once (dirname(__FILE__) . '/DAO.class.php');
	include_once (dirname(__FILE__) . '/DAORecette.class.php');
	
	final class DAOCategorie_prix extends DAO
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
			FROM v_categorie_prix
			ORDER BY id
SQL;
			return $this->RetrieveAllGen($sql);
		}
		
		public function RetrieveById($id)
		{
			$sql =
<<<SQL
			SELECT id, intitule
			FROM v_categorie_prix
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
			FROM v_categorie_prix
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
			UPDATE v_categorie_prix SET intitule = :intitule
			WHERE v_categorie_prix.id = :id
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
			INSERT INTO v_categorie_prix (intitule)
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
			$daoRec->UpdateRemoveCategoriePrix($obj['id']);
				
			// execute la requette
			$sql =
<<<SQL
			DELETE FROM v_categorie_prix
			WHERE v_categorie_prix.id = :idCat
SQL;
			$resultat = $this->Prepare($sql);
			$resultat->bindParam('idCat', $obj['id'], PDO::PARAM_INT);
			return $resultat->execute();
		}
		
	}
