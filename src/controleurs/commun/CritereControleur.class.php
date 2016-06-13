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
		
		// gestion categorie
		public static function GestionCategorie()
		{
			$donnee['modification'] = FALSE;
			if (isset($_REQUEST['action']))
			{
				$donnee['modification'] = TRUE;
				$donnee['action'] = $_REQUEST['action'];
				if (isset($_REQUEST['type_categorie'])) $donnee['type_categorie'] = $_REQUEST['type_categorie'];
				else throw new RequeteDonneeManquanteExcep('type_categorie');
				switch ($donnee['action'])
				{
					case 'modifier' :
						if (isset($_REQUEST['id_categorie'])) $donnee['id_categorie'] = $_REQUEST['id_categorie'];
						else throw new RequeteDonneeManquanteExcep('id_categorie');
						if (isset($_REQUEST['intitule'])) $donnee['intitule'] = $_REQUEST['intitule'];
						else throw new RequeteDonneeManquanteExcep('intitule');
						if (strcmp('sous_categorie', $donnee['type_categorie']) == 0)
						{
							if (isset($_REQUEST['id_sous_categorie'])) $donnee['id_sous_categorie'] = $_REQUEST['id_sous_categorie'];
							else throw new RequeteDonneeManquanteExcep('id_sous_categorie');
						}
						break;
						
					case 'supprimer' :
						if (isset($_REQUEST['id_categorie'])) $donnee['id_categorie'] = $_REQUEST['id_categorie'];
						else throw new RequeteDonneeManquanteExcep('id_categorie');
						if (strcmp('sous_categorie', $donnee['type_categorie']) == 0)
						{
							if (isset($_REQUEST['id_sous_categorie'])) $donnee['id_sous_categorie'] = $_REQUEST['id_sous_categorie'];
							else throw new RequeteDonneeManquanteExcep('id_sous_categorie');
						}
						break;
						
					case 'ajouter' :
						if (isset($_REQUEST['intitule'])) $donnee['intitule'] = $_REQUEST['intitule'];
						else throw new RequeteDonneeManquanteExcep('intitule');
						if (strcmp('sous_categorie', $donnee['type_categorie']) == 0)
						{
							if (isset($_REQUEST['id_categorie'])) $donnee['id_categorie'] = $_REQUEST['id_categorie'];
							else throw new RequeteDonneeManquanteExcep('id_categorie');
						}
						break;
						
					default :
						throw new RequeteActionInconnueExcep($donnee['action']);
						break;
				}
			}
			return $donnee;
		}
		
	}
