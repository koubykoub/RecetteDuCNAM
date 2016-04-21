<?php
	// include
	include_once (dirname(__FILE__) . '/ModeleBase.class.php');
	include_once (dirname(__FILE__) . '/../../librairies/dao/DAORecette.class.php');
	include_once (dirname(__FILE__) . '/../../librairies/dao/DAOUtilisateur.class.php');
	include_once (dirname(__FILE__) . '/../../librairies/exception/SessionException.class.php');
	include_once (dirname(__FILE__) . '/../../librairies/exception/RecetteException.class.php');
	include_once (dirname(__FILE__) . '/ImageModele.class.php');
	
	// model des recettes
	class RecetteModele extends ModeleBase
	{
		// liste de recettes
		public static function ListeRecettes($critere, $page, $idUt = 0)
		{
			parent::StartSession();
			$donnees['liste_recettes_last_page'] = FALSE;
			$nbLigne = 0;
			$daoRecette = new DAORecette(parent::GetConnexion());
			$donnees['liste_recettes'] = $daoRecette->RetrieveByCritere($nbLigne, RECETTES_PAR_PAGE, RECETTES_PAR_PAGE * $page, $critere, $idUt);
			if (($nbLigne > 0) && (($page + 1) * RECETTES_PAR_PAGE) >= $nbLigne)
				$donnees['liste_recettes_last_page'] = TRUE;
			return $donnees;
		}
		
		// recette au hasard
		public static function RandomRecette($critere, $idUt = 0)
		{
			// recette
			$daoRecette = new DAORecette(parent::GetConnexion());
			$donnees = $daoRecette->RetrieveRandomByCritere($critere, $idUt);
			
			// contenu
			if (!is_null($donnees))
				$daoRecette->RetrieveContenu($donnees);
			
			return $donnees;
		}
		
		// creation recette
		public static function Recette($id)
		{
			$daoRecette = new DAORecette(parent::GetConnexion());
			$rec = $daoRecette->RetrieveById($id);
			self::RecetteContenu($rec);
			return $rec;
		}
		
		public static function CreationRecette($rec)
		{
			// validation de la recette
			self::ValidationRecette($rec, FALSE);
			
			// creation de la recette
			$recette = self::CreationRecetteBase($rec, FALSE);
			$daoRecette = new DAORecette(parent::GetConnexion());
			$id = $daoRecette->Create($recette);
			$tmpRec = $daoRecette->RetrieveById($id);
			
			// creation de l'image
			$tmpRec = ImageModele::ImageRecette($rec['photo'], $tmpRec);
			self::RecetteContenu($tmpRec);
			return $tmpRec;
		}
		
		public static function ModificationRecette($rec, $id)
		{
			// validation de la recette
			self::ValidationRecette($rec, TRUE);
			
			// modification de la recette
			$recette = self::CreationRecetteBase($rec, TRUE);
			$recette['id'] = $id;
			$daoRecette = new DAORecette(parent::GetConnexion());
			$newId = $daoRecette->Update($recette);
			$tmpRec = $daoRecette->RetrieveById($newId);
			
			// creation de l'image
			if ($rec['effacer_image'] || ($rec['photo']['error'] != UPLOAD_ERR_NO_FILE))
				$tmpRec = ImageModele::ImageRecette($rec['photo'], $tmpRec);
			self::RecetteContenu($tmpRec);
			return $tmpRec;
		}
		
		public static function RecetteSession()
		{
			if (isset($_SESSION['id_recette'])) return self::Recette($_SESSION['id_recette']);
			else throw new SessionExpireeExcep();
		}
		
		public static function IsPrevModifierRecette()
		{
			if (isset($_SESSION['modifier_recette']))
			{
				unset($_SESSION['modifier_recette']);
				return TRUE;
			}
			return FALSE;
		}
		
		public static function PrevModifierRecette()
		{
			$_SESSION['modifier_recette'] = TRUE;
		}
		
		// page de liste de recette
		public static function PageReset()
		{
			parent::StartSession();
			$_SESSION['liste_recette_page'] = 0;
			return 0;
		}
		
		public static function PageCourante()
		{
			parent::StartSession();
			if (!isset($_SESSION['liste_recette_page']))
				self::PageReset();
			return $_SESSION['liste_recette_page'];
		}
		
		public static function PageAction($action)
		{
			parent::StartSession();
			if (!isset($_SESSION['liste_recette_page']))
				self::PageReset();
			switch ($action)
			{
				// page suivante
				case 'suivant' :
					++$_SESSION['liste_recette_page'];
					break;
						
				// page precedente
				case 'precedent' :
					--$_SESSION['liste_recette_page'];
					break;
			
				// erreur
				default :
					// TODO
					break;
			}
			$donnees = $_SESSION['liste_recette_page'];
			return $donnees;
		}
		
		public static function IsPrevListerRecette()
		{
			if (isset($_SESSION['lister_recette']))
			{
				unset($_SESSION['lister_recette']);
				return TRUE;
			}
			return FALSE;
		}
		
		public static function IsPrevListerRecetteUtilisateur()
		{
			if (isset($_SESSION['lister_recette_utilisateur']))
			{
				unset($_SESSION['lister_recette_utilisateur']);
				return TRUE;
			}
			return FALSE;
		}
		
		public static function PrevListerRecette()
		{
			$_SESSION['lister_recette'] = TRUE;
		}
		
		public static function PrevListerRecetteUtilisateur()
		{
			$_SESSION['lister_recette_utilisateur'] = TRUE;
		}
		
		public static function SessionRecetteCreation()
		{
			parent::StartSession();
			$donnees['existe'] = FALSE;
			if (isset($_SESSION['recette_en_creation']))
			{
				// donnees
				if (isset($_SESSION['recette_en_creation']['titre_recette'])) $donnees['recette']['titre'] = $_SESSION['recette_en_creation']['titre_recette'];
				else $donnees['recette']['titre'] = '';
				if (isset($_SESSION['recette_en_creation']['commentaire_recette'])) $donnees['recette']['commentaire'] = $_SESSION['recette_en_creation']['commentaire_recette'];
				else $donnees['recette']['commentaire'] = '';
				if (isset($_SESSION['recette_en_creation']['conseil_recette'])) $donnees['recette']['conseil'] = $_SESSION['recette_en_creation']['conseil_recette'];
				else $donnees['recette']['conseil'] = '';
				if (isset($_SESSION['recette_en_creation']['nb_personne_recette'])) $donnees['recette']['nb_personne'] = $_SESSION['recette_en_creation']['nb_personne_recette'];
				else $donnees['recette']['nb_personne'] = 1;
				if (isset($_SESSION['recette_en_creation']['temps_cuisson_recette'])) $donnees['recette']['temps_cuisson'] = $_SESSION['recette_en_creation']['temps_cuisson_recette'];
				else $donnees['recette']['temps_cuisson'] = 0;
				if (isset($_SESSION['recette_en_creation']['temps_preparation_recette'])) $donnees['recette']['temps_preparation'] = $_SESSION['recette_en_creation']['temps_preparation_recette'];
				else $donnees['recette']['temps_preparation'] = 0;
				if (isset($_SESSION['recette_en_creation']['categorie_recette'])) $donnees['recette']['id_categorie'] = $_SESSION['recette_en_creation']['categorie_recette'];
				else $donnees['recette']['id_categorie'] = 1;
				if (isset($_SESSION['recette_en_creation']['sous_categorie_recette'])) $donnees['recette']['id_sous_categorie'] = $_SESSION['recette_en_creation']['sous_categorie_recette'];
				else $donnees['recette']['id_sous_categorie'] = 0;
				if (isset($_SESSION['recette_en_creation']['categorie_difficulte_recette'])) $donnees['recette']['id_categorie_difficulte'] = $_SESSION['recette_en_creation']['categorie_difficulte_recette'];
				else $donnees['recette']['id_categorie_difficulte'] = 1;
				if (isset($_SESSION['recette_en_creation']['categorie_prix_recette'])) $donnees['recette']['id_categorie_prix'] = $_SESSION['recette_en_creation']['categorie_prix_recette'];
				else $donnees['recette']['id_categorie_prix'] = 1;
				// ingredients
				$donnees['recette']['ingredients'] = array();
				if (isset($_SESSION['recette_en_creation']['ingredients_recette']))
				{
					foreach ($_SESSION['recette_en_creation']['ingredients_recette'] as $ingr)
						$donnees['recette']['ingredients'][]['texte_ingredient'] = $ingr;
				}
				if (count($donnees['recette']['ingredients']) == 0) $donnees['recette']['ingredients'][] = '';
				// etape de preparation
				$donnees['recette']['etape_preparations'] = array();
				if (isset($_SESSION['recette_en_creation']['etape_preparations_recette']))
				{
					foreach ($_SESSION['recette_en_creation']['etape_preparations_recette'] as $etape)
						$donnees['recette']['etape_preparations'][]['texte_etape'] = $etape;
				}
				if (count($donnees['recette']['etape_preparations']) == 0) $donnees['recette']['etape_preparations'][] = '';
				// fin session
				$donnees['existe'] = TRUE;
				unset($_SESSION['recette_en_creation']);
			}
			return $donnees;
		}
		
		
		// fonctions privees
		private static function RecetteContenu(&$rec)
		{
			parent::StartSession();
			$daoRecette = new DAORecette(parent::GetConnexion());
			$daoRecette->RetrieveContenu($rec);
			$daoRecette->RetrieveAllCategories($rec);
			$daoRecette->RetrieveUtilisateur($rec);
			$_SESSION['id_recette'] = $rec['id'];
		}
		
		private static function CreationRecetteBase($rec, $maj)
		{
			parent::StartSession();
			
			// recette
			$recette['titre'] = $rec['titre_recette'];
			if (!empty($rec['commentaire_recette'])) $recette['commentaire'] = $rec['commentaire_recette'];
			if (!empty($rec['conseil_recette'])) $recette['conseil'] = $rec['conseil_recette'];
			$recette['nb_personne'] = $rec['nb_personne_recette'];
			$recette['temps_cuisson'] = $rec['temps_cuisson_recette'];
			$recette['temps_preparation'] = $rec['temps_preparation_recette'];
			$recette['id_categorie'] = $rec['categorie_recette'];
			$recette['id_sous_categorie'] = $rec['sous_categorie_recette'];
			$recette['id_categorie_difficulte'] = $rec['categorie_difficulte_recette'];
			$recette['id_categorie_prix'] = $rec['categorie_prix_recette'];
			if (isset($_SESSION['id_utilisateur'])) $recette['id_utilisateur'] = $_SESSION['id_utilisateur'];
			else throw new SessionExpireeExcep();
			$dt = new DateTime();
			if ($maj)
				$recette['date_maj'] = $dt->format('Y-m-d H:i:s');
			else
			{
				$recette['date_creation'] = $dt->format('Y-m-d H:i:s');
				$recette['date_maj'] = $dt->format('Y-m-d H:i:s');
			}
			
			// ingredients
			$recette['ingredients'] = array();
			foreach ($rec['ingredients_recette'] as $i => $ingr_text)
			{
				$ingr['id'] = $i;
				$ingr['texte_ingredient'] = $ingr_text;
				$recette['ingredients'][] = $ingr;
			}
			
			// etape preparations
			$recette['etape_preparations'] = array();
			foreach ($rec['etape_preparations_recette'] as $i => $etape_text)
			{
				$etape['id'] = $i;
				$etape['texte_etape'] = $etape_text;
				$recette['etape_preparations'][] = $etape;
			}
			
			return $recette;
		}
		
		private static function ValidationRecette(&$rec, $maj)
		{
			// sauvegarde de la recette saisis dans la session
			parent::StartSession();
			unset($_SESSION['recette_en_creation']);
			$_SESSION['recette_en_creation'] = $rec;
			
			// nombre d'ingredient / etape de preparation
			if (count($rec['ingredients_recette']) < REC_NB_INGREDIENT_MIN) throw new RecetteQuantiteTropPetiteExcep('Ingrédient', REC_NB_INGREDIENT_MIN, $maj);
			if (count($rec['ingredients_recette']) > REC_NB_INGREDIENT_MAX) throw new RecetteQuantiteTropGrandeExcep('Ingrédient', REC_NB_INGREDIENT_MIN, $maj);
			if (count($rec['etape_preparations_recette']) < REC_NB_ETAPE_MIN) throw new RecetteQuantiteTropPetiteExcep('Préparation', REC_NB_ETAPE_MIN, $maj);
			if (count($rec['etape_preparations_recette']) > REC_NB_ETAPE_MAX) throw new RecetteQuantiteTropGrandeExcep('Préparation', REC_NB_ETAPE_MAX, $maj);
			
			// champs vides et donnees du mauvais type
			if (!is_string($rec['titre_recette'])) throw new RecetteIsNotStrExcep('Titre', $maj);
			$rec['titre_recette'] = trim($rec['titre_recette']);
			if (empty($rec['titre_recette'])) throw new RecetteDonneeManquanteExcep('Titre', $maj);
			if (!is_string($rec['commentaire_recette'])) throw new RecetteIsNotStrExcep('Commentaires', $maj);
			$rec['commentaire_recette'] = trim($rec['commentaire_recette']);
			if (!is_numeric($rec['nb_personne_recette'])) throw new RecetteIsNotNumberExcep('Nombre de personnes', $maj);
			if (!is_numeric($rec['temps_preparation_recette'])) throw new RecetteIsNotNumberExcep('Temps de préparation', $maj);
			if (!is_numeric($rec['temps_cuisson_recette'])) throw new RecetteIsNotNumberExcep('Temps de cuisson', $maj);
			if (!is_numeric($rec['categorie_recette'])) throw new RecetteIsNotNumberExcep('Catégorie', $maj);
			if (!is_numeric($rec['sous_categorie_recette'])) throw new RecetteIsNotNumberExcep('Sous catégorie', $maj);
			if (!is_numeric($rec['categorie_difficulte_recette'])) throw new RecetteIsNotNumberExcep('Difficulté', $maj);
			if (!is_numeric($rec['categorie_prix_recette'])) throw new RecetteIsNotNumberExcep('Prix', $maj);
			if (!is_string($rec['conseil_recette'])) throw new RecetteIsNotStrExcep('Conseils', $maj);
			$rec['conseil_recette'] = trim($rec['conseil_recette']);
			// photo
			if (($rec['photo']['error'] != UPLOAD_ERR_OK) && ($rec['photo']['error'] != UPLOAD_ERR_NO_FILE)) throw new RecetteImageExcep($rec['photo'], $maj);
			if ($rec['photo']['error'] == UPLOAD_ERR_OK)
			{
				// information su le fichier
				$finfo = new finfo(FILEINFO_MIME_TYPE);
				$ftype = $finfo->file($rec['photo']['tmp_name']);
				$eltInfo = explode('/', $ftype);
				// si le fichier n'est pas une image ou du bon type
				if (!isset($eltInfo[0]) || (strcmp($eltInfo[0], 'image') != 0)) throw new RecetteImageFichierExcep($rec['photo'], isset($eltInfo[0]) ? $eltInfo[0] : 'inconnu', $maj);
				if (!isset($eltInfo[1]) || !in_array($eltInfo[1], explode('/', IMAGE_TYPE_AUTORISE))) throw new RecetteImageTypeExcep($rec['photo'], isset($eltInfo[1]) ? $eltInfo[1] : 'inconnu', $maj);
			}
			// ingredients
			foreach ($rec['ingredients_recette'] as $i => &$ingr)
			{
				if (!is_string($ingr)) throw new RecetteIsNotStrExcep('Ingrédient' . ($i + 1), $maj);
				$ingr = trim($ingr);
				if (empty($ingr)) throw new RecetteDonneeManquanteExcep('Ingrédient' . ($i + 1), $maj);
			}
			unset($ingr);
			// etape de preparation
			foreach ($rec['etape_preparations_recette'] as $i => &$etape)
			{
				if (!is_string($etape)) throw new RecetteIsNotStrExcep('Préparation' . ($i + 1), $maj);
				$etape = trim($etape);
				if (empty($etape)) throw new RecetteDonneeManquanteExcep('Préparation' . ($i + 1), $maj);
			}
			unset($etape);
			
			// longueur des chaines / taille des nombres
			if (strlen($rec['titre_recette']) < REC_TITRE_LONGUEUR_MIN) throw new RecetteChaineTropPetiteExcep('Titre', REC_TITRE_LONGUEUR_MIN, $maj);
			if (strlen($rec['titre_recette']) > REC_TITRE_LONGUEUR_MAX) throw new RecetteChaineTropGrandeExcep('Titre', REC_TITRE_LONGUEUR_MAX, $maj);
			if (strlen($rec['commentaire_recette']) > REC_COMMENTAIRE_LONGUEUR_MAX) throw new RecetteChaineTropGrandeExcep('Commentaires', REC_COMMENTAIRE_LONGUEUR_MAX, $maj);
			if ($rec['nb_personne_recette'] < REC_NB_PERSONNE_MIN) throw new RecetteNombreTropPetitExcep('Nombre de personnes', REC_NB_PERSONNE_MIN, $maj);
			if ($rec['temps_preparation_recette'] < REC_TEMPS_PREPARATION_MIN) throw new RecetteNombreTropPetitExcep('Temps de préparation', REC_TEMPS_PREPARATION_MIN, $maj);
			if ($rec['temps_cuisson_recette'] < REC_TEMPS_CUISSON_MIN) throw new RecetteNombreTropPetitExcep('Temps de cuisson', REC_TEMPS_CUISSON_MIN, $maj);
			if (strlen($rec['conseil_recette']) > REC_CONSEIL_LONGUEUR_MAX) throw new RecetteChaineTropGrandeExcep('Conseils', REC_CONSEIL_LONGUEUR_MAX, $maj);
			// ingredients
			foreach ($rec['ingredients_recette'] as $i => $ingr)
			{
				if (strlen($ingr) > REC_INGREDIENT_LONGUEUR_MAX)
					throw new RecetteChaineTropGrandeExcep('Ingrédient' . ($i + 1), REC_INGREDIENT_LONGUEUR_MAX, $maj);
			}
			// etape de preparation
			foreach ($rec['etape_preparations_recette'] as $i => $etape)
			{
				if (strlen($etape) > REC_ETAPE_LONGUEUR_MAX)
					throw new RecetteChaineTropGrandeExcep('Ingrédient' . ($i + 1), REC_ETAPE_LONGUEUR_MAX, $maj);
			}
			
			// toutes les donnees sont bien valides donc l'enregistrement en session est detruit
			unset($_SESSION['recette_en_creation']);
		}
	
	}
