<?php
	// include
	include_once (dirname(__FILE__) . '/../../librairies/exception/RequeteException.class.php');

	// controleur de recette
	class RecetteControleur
	{
		// id de la recette
		public static function IdRecette()
		{
			if (isset($_REQUEST['id_recette']) && !is_null($_REQUEST['id_recette']))
				return $_REQUEST['id_recette'];
			return 0;
		}
		
		// creation de recette
		public static function CreationRecette()
		{
			$donnees['creation_recette'] = false;
			if (isset($_REQUEST['titre']) && isset($_REQUEST['commentaire']) && isset($_REQUEST['nb_personne']) && isset($_REQUEST['temps_preparation']) &&
				isset($_REQUEST['temps_cuisson']) && isset($_REQUEST['sous_categorie']) && isset($_REQUEST['categorie_difficulte']) && isset($_REQUEST['categorie_prix']) &&
				isset($_REQUEST['conseil']) && isset($_REQUEST['ingredient_0']) && isset($_REQUEST['etape_preparation_0']))
			{
				// recette
				// titre
				if (!is_null($_REQUEST['titre'])) $donnees['titre_recette'] = $_REQUEST['titre'];
				else throw new RequeteDonneeManquanteExcep('titre');
				// commentaire
				if (!is_null($_REQUEST['commentaire'])) $donnees['commentaire_recette'] = $_REQUEST['commentaire'];
				else throw new RequeteDonneeManquanteExcep('commentaire');
				// nb personnes
				if (!is_null($_REQUEST['nb_personne'])) $donnees['nb_personne_recette'] = $_REQUEST['nb_personne'];
				else throw new RequeteDonneeManquanteExcep('nb_personne');
				// temps preparation
				if (!is_null($_REQUEST['temps_preparation'])) $donnees['temps_preparation_recette'] = $_REQUEST['temps_preparation'];
				else throw new RequeteDonneeManquanteExcep('temps_preparation');
				// temps cuisson
				if (!is_null($_REQUEST['temps_cuisson'])) $donnees['temps_cuisson_recette'] = $_REQUEST['temps_cuisson'];
				else throw new RequeteDonneeManquanteExcep('temps_cuisson');
				// categorie
				if (!is_null($_REQUEST['categorie'])) $donnees['categorie_recette'] = $_REQUEST['categorie'];
				else throw new RequeteDonneeManquanteExcep('categorie');
				// sous categorie
				if (!is_null($_REQUEST['sous_categorie'])) $donnees['sous_categorie_recette'] = $_REQUEST['sous_categorie'];
				else throw new RequeteDonneeManquanteExcep('sous_categorie');
				// categorie difficulte
				if (!is_null($_REQUEST['categorie_difficulte'])) $donnees['categorie_difficulte_recette'] = $_REQUEST['categorie_difficulte'];
				else throw new RequeteDonneeManquanteExcep('categorie_difficulte');
				// categorie prix
				if (!is_null($_REQUEST['categorie_prix'])) $donnees['categorie_prix_recette'] = $_REQUEST['categorie_prix'];
				else throw new RequeteDonneeManquanteExcep('categorie_prix');
				// conseils
				if (!is_null($_REQUEST['conseil'])) $donnees['conseil_recette'] = $_REQUEST['conseil'];
				else throw new RequeteDonneeManquanteExcep('conseil');
				// photo
				if (isset($_FILES['photo']) && !is_null($_FILES['photo'])) $donnees['photo'] = $_FILES['photo'];
				else throw new RequeteDonneeManquanteExcep('photo');
				if (isset($_REQUEST['effacer_image']) && !is_null($_REQUEST['effacer_image'])) $donnees['effacer_image'] = TRUE;
				else $donnees['effacer_image'] = FALSE;
			
				// ingredients
				$i = 0;
				$str = 'ingredient_'.$i;
				$donnees['ingredients_recette'] = array();
				while (isset($_REQUEST[$str]))
				{
					if (!is_null($_REQUEST[$str])) $donnees['ingredients_recette'][] = $_REQUEST[$str];
					else throw new RequeteDonneeManquanteExcep($str);
					++$i;
					$str = 'ingredient_'.$i;
				}
			
				// etape preparation
				$i = 0;
				$str = 'etape_preparation_'.$i;
				$donnees['etape_preparations_recette'] = array();
				while (isset($_REQUEST[$str]))
				{
					if (!is_null($_REQUEST[$str])) $donnees['etape_preparations_recette'][] = $_REQUEST[$str];
					else throw new RequeteDonneeManquanteExcep($str);
					++$i;
					$str = 'etape_preparation_'.$i;
				}
			
				$donnees['creation_recette'] = true;
			}
			
			return $donnees;
		}
	
	}
