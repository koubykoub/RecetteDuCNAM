<?php
	include_once (dirname(__FILE__) . '/DAO.class.php');
	include_once (dirname(__FILE__) . '/DAOSous_categorie.class.php');
	
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
		
		public function RetrieveAllWithSousCat()
		{
			$cats = $this->RetrieveAll();
			$cats[] = array_shift($cats);
			$daoScat = new DAOSous_categorie($this->connexion);
			foreach ($cats as & $cat)
			{
				$cat['sous_categories'] = $daoScat->RetrieveAllByCategorie($cat['id']);
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
		
	}
