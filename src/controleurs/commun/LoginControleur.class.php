<?php
	//include
	include_once (dirname(__FILE__) . '/../../librairies/exception/LoginException.class.php');
	include_once (dirname(__FILE__) . '/../../librairies/exception/RequeteException.class.php');

	// controleur de login
	class LoginControleur
	{
		// identification
		public static function Identification()
		{
			$donnees['identifie'] = FALSE;
			if (isset($_REQUEST['login']) && isset($_REQUEST['mdp']))
			{
				$donnees['login'] = $_REQUEST['login'];
				$donnees['mdp'] = $_REQUEST['mdp'];
				if (is_null($donnees['login']) || !is_string($donnees['login']) || empty($donnees['login']) ||
					is_null($donnees['mdp']) || !is_string($donnees['mdp']) || empty($donnees['mdp']))
					throw new LoginIncorrectExcep();
				$donnees['identifie'] = TRUE;
			}
			
			return $donnees;
		}
		
		// deconnexion
		public static function Deconnexion()
		{
			return isset($_REQUEST['deconnexion']);
		}
		
		// compte
		public static function DonneesCompte($maj)
		{
			$donnees['creation_compte'] = FALSE;
			if (isset($_REQUEST['login']) && isset($_REQUEST['mdp']) && isset($_REQUEST['mdp2']) && isset($_REQUEST['nom']) &&
				isset($_REQUEST['prenom']) && isset($_REQUEST['email_left']) && isset($_REQUEST['email_right']))
			{
				// nom
				if (!is_null($_REQUEST['login'])) $donnees['login'] = $_REQUEST['login'];
				else throw new RequeteDonneeManquanteExcep('login');
				// mot de passe
				if (!is_null($_REQUEST['mdp'])) $donnees['mdp'] = $_REQUEST['mdp'];
				else throw new RequeteDonneeManquanteExcep('mdp');
				if (!is_null($_REQUEST['mdp2'])) $donnees['mdp2'] = $_REQUEST['mdp2'];
				else throw new RequeteDonneeManquanteExcep('mdp2');
				if ($maj)
				{
					if (!is_null($_REQUEST['ancien_mdp'])) $donnees['ancien_mdp'] = $_REQUEST['ancien_mdp'];
					else throw new RequeteDonneeManquanteExcep('ancien_mdp');
				}
				// nom
				if (!is_null($_REQUEST['nom'])) $donnees['nom'] = $_REQUEST['nom'];
				else throw new RequeteDonneeManquanteExcep('nom');
				// prenom
				if (!is_null($_REQUEST['prenom'])) $donnees['prenom'] = $_REQUEST['prenom'];
				else throw new RequeteDonneeManquanteExcep('prenom');
				// email
				if (!is_null($_REQUEST['email_left'])) $donnees['email_left'] = $_REQUEST['email_left'];
				else throw new RequeteDonneeManquanteExcep('email_left');
				if (!is_null($_REQUEST['email_right'])) $donnees['email_right'] = $_REQUEST['email_right'];
				else throw new RequeteDonneeManquanteExcep('email_right');
				// photo
				if (isset($_FILES['photo']) && !is_null($_FILES['photo'])) $donnees['photo'] = $_FILES['photo'];
				else throw new RequeteDonneeManquanteExcep('photo');
				if (isset($_REQUEST['effacer_image']) && !is_null($_REQUEST['effacer_image'])) $donnees['effacer_image'] = TRUE;
				else $donnees['effacer_image'] = FALSE;
					
				$donnees['creation_compte'] = TRUE;
			}
			return $donnees;
		}
		
		public static function DestructionCompte()
		{
			return isset($_REQUEST['detruire_compte']);
		}
		
	}
