<?php
	include_once (dirname(__FILE__) . '/DAO.class.php');
	include_once (dirname(__FILE__) . '/DAOIngredient.class.php');
	include_once (dirname(__FILE__) . '/DAOEtape_preparation.class.php');
	include_once (dirname(__FILE__) . '/DAOCategorie.class.php');
	include_once (dirname(__FILE__) . '/DAOSous_categorie.class.php');
	include_once (dirname(__FILE__) . '/DAOCategorie_difficulte.class.php');
	include_once (dirname(__FILE__) . '/DAOCategorie_prix.class.php');
	include_once (dirname(__FILE__) . '/DAOUtilisateur.class.php');
	
	final class DAORecette extends DAO
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
			SELECT id, titre, commentaire, conseil, nb_personne, photo, date_creation, date_maj,
				   temps_cuisson, temps_preparation, id_sous_categorie, id_categorie,
				   id_utilisateur, id_categorie_prix, id_categorie_difficulte
			FROM v_recette
SQL;
			return $this->RetrieveAllGen($sql);
		}
		
		public function RetrieveById($id)
		{
			$sql =
<<<SQL
			SELECT id, titre, commentaire, conseil, nb_personne, photo, date_creation, date_maj,
				   temps_cuisson, temps_preparation, id_sous_categorie, id_categorie,
				   id_utilisateur, id_categorie_prix, id_categorie_difficulte
			FROM v_recette
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
			SELECT id, titre, commentaire, conseil, nb_personne, photo, date_creation, date_maj,
				   temps_cuisson, temps_preparation, id_sous_categorie, id_categorie,
				   id_utilisateur, id_categorie_prix, id_categorie_difficulte
			FROM v_recette
			ORDER BY RAND()
			LIMIT 1
SQL;
			return $this->RetrieveGen($sql);
		}
		
		public function RetrieveRandomByCritere($critere, $idUt = 0)
		{
			$sql =
<<<SQL
			SELECT id, titre, commentaire, conseil, nb_personne, photo, date_creation, date_maj,
				   temps_cuisson, temps_preparation, id_sous_categorie, id_categorie,
				   id_utilisateur, id_categorie_prix, id_categorie_difficulte
			FROM v_recette
SQL;
			$sql .= $this->GetSqlWhereCritere($critere, $idUt).' ';
			$sql .=
<<<SQL
			ORDER BY RAND()
			LIMIT 1
SQL;
			$resultat = $this->Prepare($sql);
			$this->BindSqlCritere($resultat, $critere, $idUt);
			$resultat->execute();
			return $this->RetrieveGenEx($resultat);
		}
		
		public function RetrieveByCritere(&$nbLigne, $limit, $offset, $critere, $idUt = 0)
		{
			// nombre de lignes
			$sqlWhere = $this->GetSqlWhereCritere($critere, $idUt);
			$sql =
<<<SQL
			SELECT COUNT(*)
			FROM v_recette
SQL;
			$sql .= $sqlWhere;
			$resultat = $this->Prepare($sql);
			$this->BindSqlCritere($resultat, $critere, $idUt);
			$resultat->execute();
			$nbLigne = $resultat->fetchColumn();
			
			// si le resultat n'est pas vide
			if ($nbLigne > 0)
			{
				// si l'offset est superieur au nombre de ligne on renvoie null
				if ($offset >= $nbLigne)
					return null;
				
				// dans les autres cas on renvoie le tableau de recettes
				else
				{
					$sql =
<<<SQL
					SELECT id, titre, commentaire, conseil, nb_personne, photo, date_creation, date_maj,
						   temps_cuisson, temps_preparation, id_sous_categorie, id_categorie,
						   id_utilisateur, id_categorie_prix, id_categorie_difficulte
					FROM v_recette
SQL;
					$sql .= $sqlWhere.$this->GetSqlOrderByCritere($critere);
					$sql .=
<<<SQL
					LIMIT :offset, :limit
SQL;
					$resultat = $this->Prepare($sql);
					$this->BindSqlCritere($resultat, $critere, $idUt);
					$resultat->bindParam('limit', $limit, PDO::PARAM_INT);
					$resultat->bindParam('offset', $offset, PDO::PARAM_INT);
					$resultat->execute();
					return $this->RetrieveAllGenEx($resultat);
				}
			}
			
			// sinon on retourne un tableau vide
			else
				return array();
		}
		
		public function RetrieveIngredients(&$recette)
		{
			$daoIngredient = new DAOIngredient($this->connexion);
			$recette['ingredients'] = $daoIngredient->RetrieveAllByRecette($recette['id']);
		}
		
		public function RetrieveEtapePreparation(&$recette)
		{
			$daoEtape = new DAOEtape_preparation($this->connexion);
			$recette['etape_preparations'] = $daoEtape->RetrieveAllByRecette($recette['id']);
		}
		
		public function RetrieveContenu(&$recette)
		{
			$this->RetrieveIngredients($recette);
			$this->RetrieveEtapePreparation($recette);
		}
		
		public function RetrieveCategorie(&$recette)
		{
			$daoCat = new DAOCategorie($this->connexion);
			$recette['categorie'] = $daoCat->RetrieveById($recette['id_categorie']);
		}
		
		public function RetrieveSousCategorie(&$recette)
		{
			$daoCat = new DAOSous_Categorie($this->connexion);
			$recette['sous_categorie'] = $daoCat->RetrieveById($recette['id_categorie'], $recette['id_sous_categorie']);
		}
		
		public function RetrieveCategorieDifficulte(&$recette)
		{
			$daoCat = new DAOCategorie_difficulte($this->connexion);
			$recette['categorie_difficulte'] = $daoCat->RetrieveById($recette['id_categorie_difficulte']);
		}
		
		public function RetrieveCategoriePrix(&$recette)
		{
			$daoCat = new DAOCategorie_prix($this->connexion);
			$recette['categorie_prix'] = $daoCat->RetrieveById($recette['id_categorie_prix']);
		}
		
		public function RetrieveAllCategories(&$recette)
		{
			$this->RetrieveCategorie($recette);
			$this->RetrieveSousCategorie($recette);
			$this->RetrieveCategorieDifficulte($recette);
			$this->RetrieveCategoriePrix($recette);
		}
		
		public function RetrieveUtilisateur(&$recette)
		{
			$daoUt = new DAOUtilisateur($this->connexion);
			$recette['utilisateur'] = $daoUt->RetrieveById($recette['id_utilisateur']);
		}
		
		// create
		public function Create($rec)
		{
			// creation de la recette
			$sql =
<<<SQL
			INSERT INTO v_recette (titre, commentaire, conseil, nb_personne, photo, date_creation,
								   date_maj, temps_cuisson, temps_preparation, id_sous_categorie,
								   id_categorie, id_utilisateur, id_categorie_prix, id_categorie_difficulte)
		    VALUES (:titre, :commentaire, :conseil, :nb_personne, :photo, :date_creation,
				    :date_maj, :temps_cuisson, :temps_preparation, :id_sous_categorie,
				    :id_categorie, :id_utilisateur, :id_categorie_prix, :id_categorie_difficulte)
SQL;
			$resultat = $this->Prepare($sql);
			self::BindRecetteBase($resultat, $rec, FALSE);
			$resultat->execute();
			
			// creation des ingredients
			$lastid = $this->connexion->GetDB()->lastInsertId();
			$daoIngredient = new DAOIngredient($this->connexion);
			if (!isset($rec['ingredients'])) $rec['ingredients'] = array();
			foreach ($rec['ingredients'] as $ing)
			{
				$ing['id_recette'] = $lastid;
				$daoIngredient->Create($ing);
			}
			
			// creation des etapes de preparation
			$daoEtape_preparation = new DAOEtape_preparation($this->connexion);
			if (!isset($rec['etape_preparations'])) $rec['etape_preparations'] = array();
			foreach ($rec['etape_preparations'] as $eta)
			{
				$eta['id_recette'] = $lastid;
				$daoEtape_preparation->Create($eta);
			}
			
			return $lastid;
		}
		
		// update
		public function Update($rec)
		{
			// modification d'une recette
			$sql =
<<<SQL
			UPDATE v_recette SET titre = :titre, commentaire = :commentaire, conseil = :conseil, nb_personne = :nb_personne, photo = :photo,
								 date_maj = :date_maj, temps_cuisson = :temps_cuisson, temps_preparation = :temps_preparation, id_sous_categorie = :id_sous_categorie,
								 id_categorie = :id_categorie, id_utilisateur = :id_utilisateur, id_categorie_prix = :id_categorie_prix, id_categorie_difficulte = :id_categorie_difficulte
			WHERE v_recette.id = :id
SQL;
			$resultat = $this->Prepare($sql);
			self::BindRecetteBase($resultat, $rec, TRUE);
			$resultat->bindParam('id', $rec['id'], PDO::PARAM_INT);
			$resultat->execute();
			
			// recreation des ingredients
			$lastid = $rec['id'];
			$daoIngredient = new DAOIngredient($this->connexion);
			$daoIngredient->DeleteByRecette($lastid);
			if (!isset($rec['ingredients'])) $rec['ingredients'] = array();
			foreach ($rec['ingredients'] as $ing)
			{
				$ing['id_recette'] = $lastid;
				$daoIngredient->Create($ing);
			}
				
			// recreation des etapes de preparation
			$daoEtape_preparation = new DAOEtape_preparation($this->connexion);
			$daoEtape_preparation->DeleteByRecette($lastid);
			if (!isset($rec['etape_preparations'])) $rec['etape_preparations'] = array();
			foreach ($rec['etape_preparations'] as $eta)
			{
				$eta['id_recette'] = $lastid;
				$daoEtape_preparation->Create($eta);
			}
			
			return $lastid;
		}
		
		
		// private functions
		private static function BindRecetteBase(&$resultat, $rec, $maj)
		{
			$resultat->bindParam('titre', $rec['titre'], PDO::PARAM_STR);
			$resultat->bindParam('commentaire', $rec['commentaire'], isset($rec['commentaire']) ? PDO::PARAM_STR : PDO::PARAM_NULL);
			$resultat->bindParam('conseil', $rec['conseil'], isset($rec['conseil']) ? PDO::PARAM_STR : PDO::PARAM_NULL);
			$resultat->bindParam('nb_personne', $rec['nb_personne'], PDO::PARAM_INT);
			$resultat->bindParam('photo', $rec['photo'], isset($rec['photo']) ? PDO::PARAM_STR : PDO::PARAM_NULL);
			if (!$maj)
				$resultat->bindParam('date_creation', $rec['date_creation'], PDO::PARAM_STR);
			$resultat->bindParam('date_maj', $rec['date_maj'], PDO::PARAM_STR);
			$resultat->bindParam('temps_cuisson', $rec['temps_cuisson'], isset($rec['temps_cuisson']) ? PDO::PARAM_INT : PDO::PARAM_NULL);
			$resultat->bindParam('temps_preparation', $rec['temps_preparation'], isset($rec['temps_preparation']) ? PDO::PARAM_INT : PDO::PARAM_NULL);
			$resultat->bindParam('id_sous_categorie', $rec['id_sous_categorie'], PDO::PARAM_INT);
			$resultat->bindParam('id_categorie', $rec['id_categorie'], PDO::PARAM_INT);
			$resultat->bindParam('id_utilisateur', $rec['id_utilisateur'], PDO::PARAM_INT);
			$resultat->bindParam('id_categorie_prix', $rec['id_categorie_prix'], PDO::PARAM_INT);
			$resultat->bindParam('id_categorie_difficulte', $rec['id_categorie_difficulte'], PDO::PARAM_INT);
		}
		
		private function GetSqlWhereCritere($critere, $idUt)
		{
			if (isset($critere['toutes']) && $critere['toutes'])
				return ($idUt != 0) ? ' WHERE id_utilisateur = :id_utilisateur' : '';
		
			$sql = '';
			$first = TRUE;
			if (isset($critere['id_categorie']))
			{
				$sql .= ($first ? ' WHERE ' : ' AND ') . 'id_categorie = :id_categorie';
				$first = FALSE;
			}
			if (isset($critere['id_sous_categorie']))
			{
				$sql .= ($first ? ' WHERE ' : ' AND ') . 'id_sous_categorie = :id_sous_categorie';
				$first = FALSE;
			}
			if ($idUt != 0)
			{
				$sql .= ($first ? ' WHERE ' : ' AND ') . 'id_utilisateur = :id_utilisateur';
				$first = FALSE;
			}
			
			return $sql;
		}
		
		private function GetSqlOrderByCritere($critere)
		{
			$sql = '';
			return $sql;
		}
		
		private function BindSqlCritere(&$resultat, $critere, $idUt)
		{
			if (isset($critere['id_categorie']))
				$resultat->bindParam('id_categorie', $critere['id_categorie'], PDO::PARAM_INT);
			if (isset($critere['id_sous_categorie']))
				$resultat->bindParam('id_sous_categorie', $critere['id_sous_categorie'], PDO::PARAM_INT);
			if ($idUt != 0)
				$resultat->bindParam('id_utilisateur', $idUt, PDO::PARAM_INT);
		}
	
	}
