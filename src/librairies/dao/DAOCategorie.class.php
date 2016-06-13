<?php
	include_once (dirname(__FILE__) . '/DAO.class.php');
	include_once (dirname(__FILE__) . '/DAOSous_categorie.class.php');
	include_once (dirname(__FILE__) . '/DAORecette.class.php');
	
	final class DAOCategorie extends DAO
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
			FROM v_categorie
			ORDER BY id
SQL;
			return $this->RetrieveAllGen($sql);
		}
		
		public function RetrieveById($id)
		{
			$sql =
<<<SQL
			SELECT id, intitule
			FROM v_categorie
			WHERE id = :id
SQL;
			$resultat = $this->Prepare($sql);
			$resultat->bindParam('id', $id, PDO::PARAM_INT);
			$resultat->execute();
			return $this->RetrieveGenEx($resultat);
		}
		
		public function RetrieveAllWithSousCat($inversion = TRUE)
		{
			$cats = $this->RetrieveAll();
			if ($inversion)
				$cats[] = array_shift($cats);
			$daoScat = new DAOSous_categorie($this->connexion);
			foreach ($cats as & $cat)
			{
				$cat['sous_categories'] = $daoScat->RetrieveAllByCategorie($cat['id']);
				if ($inversion)
					$cat['sous_categories'][] = array_shift($cat['sous_categories']);
			}
			return $cats;
		}
		
		public function RetrieveRandom()
		{
			$sql =
<<<SQL
			SELECT id, intitule
			FROM v_categorie
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
			UPDATE v_categorie SET intitule = :intitule
			WHERE v_categorie.id = :id
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
			// creation d'une categorie
			$sql =
<<<SQL
			INSERT INTO v_categorie (intitule)
			VALUES (:intitule)
SQL;
			$resultat = $this->Prepare($sql);
			$resultat->bindParam('intitule', $obj['intitule'], PDO::PARAM_STR);
			$resultat->execute();
			$lastid = $this->connexion->GetDB()->lastInsertId();
			
			// creation d'une sous categorie par defaut
			$scat = array();
			$scat['id_categorie'] = $lastid;
			$scat['intitule'] = 'Autres...';
			$daoSous_categorie = new DAOSous_categorie($this->connexion);
			$daoSous_categorie->Create($scat);
			
			// creation des sous categories
			if (!isset($obj['sous_categories'])) $obj['sous_categories'] = array();
			foreach ($obj['sous_categories'] as $scat)
			{
				$scat['id_categorie'] = $lastid;
				$daoSous_categorie->Create($scat);
			}
			
			return $lastid;
		}
		
		// delete
		public function Delete($obj)
		{
			// modifie les recette dependant de la categorie
			$daoRec = new DAORecette($this->connexion);
			$daoRec->UpdateRemoveCategorie($obj['id']);
			
			// detruit les sous categories
			$daoSCat = new DAOSous_categorie($this->connexion);
			$daoSCat->DeleteByCategorie($obj['id']);
				
			// execute la requette
			$sql =
<<<SQL
			DELETE FROM v_categorie
			WHERE v_categorie.id = :idCat
SQL;
			$resultat = $this->Prepare($sql);
			$resultat->bindParam('idCat', $obj['id'], PDO::PARAM_INT);
			return $resultat->execute();
		}
		
	}
