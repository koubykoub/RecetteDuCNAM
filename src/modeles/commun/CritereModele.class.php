<?php
	// include
	include_once (dirname(__FILE__) . '/ModeleBase.class.php');
	include_once (dirname(__FILE__) . '/../../librairies/dao/DAOCategorie.class.php');
	include_once (dirname(__FILE__) . '/../../librairies/dao/DAOCategorie_difficulte.class.php');
	include_once (dirname(__FILE__) . '/../../librairies/dao/DAOCategorie_prix.class.php');
	
	// model des criteres
	class CritereModele extends ModeleBase
	{
		// categories
		public static function Categories()
		{
			$daoCat = new DAOCategorie(parent::GetConnexion());
			return $daoCat->RetrieveAllWithSousCat();
		}
		
		public static function CategoriesDif()
		{
			$daoCat = new DAOCategorie_difficulte(parent::GetConnexion());
			return $daoCat->RetrieveAll();
		}
		
		public static function CategoriesPrix()
		{
			$daoCat = new DAOCategorie_prix(parent::GetConnexion());
			return $daoCat->RetrieveAll();
		}
		
		// critere de recherche
		public static function CritereRecherche($critere)
		{
			if (is_null($critere))
				return self::CritereRechercheSession();
			$donnees['toutes'] = $critere['toutes'];
			
			// categorie / sous categories
			if (isset($critere['id_categorie']))
			{
				$donnees['id_categorie'] = $critere['id_categorie'];
				if (isset($critere['id_sous_categorie']))
					$donnees['id_sous_categorie'] = $critere['id_sous_categorie'];
			}
			parent::StartSession();
			$_SESSION['critere'] = $donnees;
			return $donnees;
		}
		
		public static function CritereRechercheSession()
		{
			parent::StartSession();
			if (!isset($_SESSION['critere']))
				$_SESSION['critere'] = array('toutes' => TRUE);
			return $_SESSION['critere'];
		}
		
		public static function CritereRechercheToutes()
		{
			return array('toutes' => TRUE);
		}
		
		public static function CritereRechercheDonnees(&$critere)
		{
			// categorie / sous categorie
			if (isset($critere['id_categorie']))
			{
				$daoCat = new DAOCategorie(parent::GetConnexion());
				$critere['categorie'] = $daoCat->RetrieveById($critere['id_categorie']);
				
				if (isset($critere['id_sous_categorie']))
				{
					$daoSCat = new DAOSous_categorie(parent::GetConnexion());
					$critere['sous_categorie'] = $daoSCat->RetrieveById($critere['id_categorie'], $critere['id_sous_categorie']);
				}
			}
		}
		
	}
