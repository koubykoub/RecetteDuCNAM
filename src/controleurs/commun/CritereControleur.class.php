<?php
	// include
	include_once (dirname(__FILE__) . '/../../librairies/exception/RequeteException.class.php');

	// controleur de critere
	class CritereControleur
	{
		// page suivante / precedentes
		public static function ListerPageAction()
		{
			if (isset($_REQUEST['lister_page_action']))
			{
				if (!is_null($_REQUEST['lister_page_action']) && !empty($_REQUEST['lister_page_action'])) return $_REQUEST['lister_page_action'];
				else throw new RequeteDonneeManquanteExcep('lister_page_action');
			}
			return null;
		}
		
		// criteres
		public static function Criteres()
		{
			// toutes
			if (isset($_REQUEST['critere_toutes']))
				$donnees['toutes'] = TRUE;
			
			// categorie / sous categorie
			if (isset($_REQUEST['critere_id_categorie']))
			{
				$donnees['toutes'] = FALSE;
				if (!is_null($_REQUEST['critere_id_categorie'])) $donnees['id_categorie'] = $_REQUEST['critere_id_categorie'];
				else throw new RequeteDonneeManquanteExcep('critere_id_categorie');
			
				// sous categorie
				if (isset($_REQUEST['critere_id_sous_categorie']))
				{
					if (!is_null($_REQUEST['critere_id_sous_categorie'])) $donnees['id_sous_categorie'] = $_REQUEST['critere_id_sous_categorie'];
					else throw new RequeteDonneeManquanteExcep('critere_id_sous_categorie');
				}
			}
			
			if (!isset($donnees)) return null;
			return $donnees;
		}
		
	}
