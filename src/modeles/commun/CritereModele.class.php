<?php
	// include
	include_once (dirname(__FILE__) . '/ModeleBase.class.php');
	include_once (dirname(__FILE__) . '/../../librairies/dao/DAOCategorie.class.php');
	include_once (dirname(__FILE__) . '/../../librairies/dao/DAOCategorie_difficulte.class.php');
	include_once (dirname(__FILE__) . '/../../librairies/dao/DAOCategorie_prix.class.php');
	include_once (dirname(__FILE__) . '/../../librairies/exception/CritereException.class.php');
	
	// model des criteres
	class CritereModele extends ModeleBase
	{
		// categories
		public static function Categories($inversion = TRUE)
		{
			$daoCat = new DAOCategorie(parent::GetConnexion());
			return $daoCat->RetrieveAllWithSousCat($inversion);
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
		
		public static function GestionCategorie($donneeControleur)
		{
			if ($donneeControleur['modification'])
			{
				switch ($donneeControleur['action'])
				{
					case 'modifier' :
						if (!isset($donneeControleur['intitule']) || empty($donneeControleur['intitule']) || (strlen($donneeControleur['intitule']) > 50))
							throw new CritereIntituleNonComformeExcep();
						if (!isset($donneeControleur['id_categorie']) || empty($donneeControleur['id_categorie']))
							throw new CritereIdManquanteExcep();
						$cat['id'] = $donneeControleur['id_categorie'];
						$cat['intitule'] = $donneeControleur['intitule'];
						switch ($donneeControleur['type_categorie'])
						{
							case 'categorie' :
								$dao = new DAOCategorie(parent::GetConnexion());
								$dao->Update($cat);
								break;
								
							case 'sous_categorie' :
								if (!isset($donneeControleur['id_sous_categorie']) || empty($donneeControleur['id_sous_categorie']))
									throw new CritereIdManquanteExcep();
								$cat['id'] = $donneeControleur['id_sous_categorie'];
								$cat['id_categorie'] = $donneeControleur['id_categorie'];
								$dao = new DAOSous_Categorie(parent::GetConnexion());
								$dao->Update($cat);
								break;
								
							case 'categorie_prix' :
								$dao = new DAOCategorie_prix(parent::GetConnexion());
								$dao->Update($cat);
								break;
								
							case 'categorie_difficulte' :
								$dao = new DAOCategorie_difficulte(parent::GetConnexion());
								$dao->Update($cat);
								break;
								
							default :
								throw new CritereTypeInconnueExcep($donneeControleur['type_categorie']);
								break;
						}
						break;
						
					case 'supprimer' :
						if (!isset($donneeControleur['id_categorie']) || empty($donneeControleur['id_categorie']))
							throw new CritereIdManquanteExcep();
						$cat['id'] = $donneeControleur['id_categorie'];
						switch ($donneeControleur['type_categorie'])
						{
							case 'categorie' :
								$dao = new DAOCategorie(parent::GetConnexion());
								$dao->Delete($cat);
								break;
						
							case 'sous_categorie' :
								if (!isset($donneeControleur['id_sous_categorie']) || empty($donneeControleur['id_sous_categorie']))
									throw new CritereIdManquanteExcep();
								$cat['id'] = $donneeControleur['id_sous_categorie'];
								$cat['id_categorie'] = $donneeControleur['id_categorie'];
								$dao = new DAOSous_Categorie(parent::GetConnexion());
								$dao->Delete($cat);
								break;
						
							case 'categorie_prix' :
								$dao = new DAOCategorie_prix(parent::GetConnexion());
								$dao->Delete($cat);
								break;
						
							case 'categorie_difficulte' :
								$dao = new DAOCategorie_difficulte(parent::GetConnexion());
								$dao->Delete($cat);
								break;
						
							default :
								throw new CritereTypeInconnueExcep($donneeControleur['type_categorie']);
								break;
						}
						break;
						
					case 'ajouter' :
						if (!isset($donneeControleur['intitule']) || empty($donneeControleur['intitule']) || (strlen($donneeControleur['intitule']) > 50))
							throw new CritereIntituleNonComformeExcep();
						$cat['intitule'] = $donneeControleur['intitule'];
						switch ($donneeControleur['type_categorie'])
						{
							case 'categorie' :
								$dao = new DAOCategorie(parent::GetConnexion());
								$dao->Create($cat);
								break;
						
							case 'sous_categorie' :
								if (!isset($donneeControleur['id_categorie']) || empty($donneeControleur['id_categorie']))
									throw new CritereIdManquanteExcep();
								$cat['id_categorie'] = $donneeControleur['id_categorie'];
								$dao = new DAOSous_Categorie(parent::GetConnexion());
								$dao->Create($cat);
								break;
						
							case 'categorie_prix' :
								$dao = new DAOCategorie_prix(parent::GetConnexion());
								$dao->Create($cat);
								break;
						
							case 'categorie_difficulte' :
								$dao = new DAOCategorie_difficulte(parent::GetConnexion());
								$dao->Create($cat);
								break;
						
							default :
								throw new CritereTypeInconnueExcep($donneeControleur['type_categorie']);
								break;
						}
						break;
						
					default :
						throw new CritereActionInconnueExcep($donneeControleur['action']);
						break;
				}
			}
		}
		
	}
