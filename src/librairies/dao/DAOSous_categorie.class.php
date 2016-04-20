<?php
	include_once (dirname(__FILE__) . '/DAO.class.php');
	
	final class DAOSous_categorie extends DAO
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
			SELECT id, id_categorie, intitule
			FROM v_sous_categorie
			ORDER BY id
SQL;
			return $this->RetrieveAllGen($sql);
		}
		
		public function RetrieveById($id_cat, $id_sous_cat)
		{
			$sql =
<<<SQL
			SELECT id, id_categorie, intitule
			FROM v_sous_categorie
			WHERE id = :id_sous_cat
				AND id_categorie = :id_cat
SQL;
			$resultat = $this->Prepare($sql);
			$resultat->bindParam('id_cat', $id_cat, PDO::PARAM_INT);
			$resultat->bindParam('id_sous_cat', $id_sous_cat, PDO::PARAM_INT);
			$resultat->execute();
			return $this->RetrieveGenEx($resultat);
		}
		
		public function RetrieveAllByCategorie($catId)
		{
			$sql =
<<<SQL
			SELECT id, id_categorie, intitule
			FROM v_sous_categorie
			WHERE id_categorie = :id_categorie
			ORDER BY id
SQL;
			$resultat = $this->Prepare($sql);
			$resultat->bindParam('id_categorie', $catId, PDO::PARAM_INT);
			$resultat->execute();
			return $this->RetrieveAllGenEx($resultat);
		}
		
		public function RetrieveRandom($id)
		{
			$sql =
<<<SQL
			SELECT id, id_categorie, intitule
			FROM v_sous_categorie
			WHERE id_categorie = :id
			ORDER BY RAND()
			LIMIT 1
SQL;
			$resultat = $this->Prepare($sql);
			$resultat->bindParam('id', $id, PDO::PARAM_INT);
			$resultat->execute();
			return $this->RetrieveGenEx($resultat);
		}
		
		// create
		public function Create($obj)
		{
			// execute la requette
			$sql =
<<<SQL
			INSERT INTO v_sous_categorie (id, id_categorie, intitule)
			SELECT MAX(sc.id) + 1, :id_categorie, :intitule
			FROM v_sous_categorie sc
			WHERE sc.id_categorie = :id_categorie
SQL;
			$resultat = $this->Prepare($sql);
			$resultat->bindParam('id_categorie', $obj['id_categorie'], PDO::PARAM_INT);
			$resultat->bindParam('intitule', $obj['intitule'], PDO::PARAM_STR);
			$resultat->execute();
			return $this->connexion->GetDB()->lastInsertId();
		}
		
	}
