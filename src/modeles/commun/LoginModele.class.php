<?php
	// include
	include_once (dirname(__FILE__) . '/ModeleBase.class.php');
	include_once (dirname(__FILE__) . '/../../librairies/dao/DAOUtilisateur.class.php');
	include_once (dirname(__FILE__) . '/../../librairies/exception/CompteException.class.php');
	include_once (dirname(__FILE__) . '/../../librairies/exception/LoginException.class.php');
	
	// model du login
	class LoginModele extends ModeleBase
	{
		// identification
		public static function Identification($ident)
		{
			parent::StartSession();
			if ($ident['identifie'])
			{
				$login = trim($ident['login']);
				$mdp = trim($ident['mdp']);
				$donnees['identifie'] = TRUE;
				$daoUt = new DAOUtilisateur(parent::GetConnexion());
				$donnees['utilisateur'] = $daoUt->RetrieveByLogin($login);
				if (is_null($donnees['utilisateur']) || (strcmp($mdp, $donnees['utilisateur']['mdp']) != 0))
					throw new LoginIncorrectExcep();
				$_SESSION['id_utilisateur'] = $donnees['utilisateur']['id'];
				return $donnees;
			}
			return self::IdentificationSession();
		}
		
		// identification par session
		public static function IdentificationSession()
		{
			parent::StartSession();
			if (isset($_SESSION['id_utilisateur']))
			{
				$daoUt = new DAOUtilisateur(parent::GetConnexion());
				$donnees['utilisateur'] = $daoUt->RetrieveById($_SESSION['id_utilisateur']);
				$donnees['identifie'] = TRUE;
				return $donnees;
			}
			$donnees['identifie'] = FALSE;
			return $donnees;
		}
		
		// deconnexion
		public static function Deconnexion()
		{
			parent::StartSession();
			unset($_SESSION['id_utilisateur']);
			$donnees['identifie'] = FALSE;
			return $donnees;
		}
		
		// compte
		public static function CreerCompte($compte)
		{
			// session
			parent::StartSession();
			
			// validation du compte
			self::ValidationCompte($compte, FALSE);
		
			// creation de l'utilisateur
			$daoUt = new DAOUtilisateur(parent::GetConnexion());
			$ut = self::CreationUtilisateurBase($compte);
			$id = $daoUt->Create($ut);
			$_SESSION['id_utilisateur'] = $id;
			return $daoUt->RetrieveById($id);
		}
		
		public static function MofifierCompte($compte, $utilisateur)
		{
			// validation du compte
			self::ValidationCompte($compte, TRUE, $utilisateur);
		
			// creation du nouvel utilisateur
			$daoUt = new DAOUtilisateur(parent::GetConnexion());
			$ut = self::CreationUtilisateurBase($compte);
			$ut['id'] = $utilisateur['id'];
			$id = $daoUt->Update($ut);
			return $daoUt->RetrieveById($id);
		}
		
		public static function SessionCompteCreation()
		{
			parent::StartSession();
			$donnees['identifie'] = FALSE;
			if (isset($_SESSION['compte_en_creation']))
			{
				if (isset($_SESSION['compte_en_creation']['login'])) $donnees['utilisateur']['login'] = $_SESSION['compte_en_creation']['login'];
				else $donnees['utilisateur']['login'] = '';
				if (isset($_SESSION['compte_en_creation']['nom'])) $donnees['utilisateur']['nom'] = $_SESSION['compte_en_creation']['nom'];
				else $donnees['utilisateur']['nom'] = '';
				if (isset($_SESSION['compte_en_creation']['prenom'])) $donnees['utilisateur']['prenom'] = $_SESSION['compte_en_creation']['prenom'];
				else $donnees['utilisateur']['prenom'] = '';
				if (isset($_SESSION['compte_en_creation']['email_left'])) $donnees['utilisateur']['email_left'] = $_SESSION['compte_en_creation']['email_left'];
				else $donnees['utilisateur']['email_left'] = '';
				if (isset($_SESSION['compte_en_creation']['email_right'])) $donnees['utilisateur']['email_right'] = $_SESSION['compte_en_creation']['email_right'];
				else $donnees['utilisateur']['email_right'] = '';
				$donnees['identifie'] = TRUE;
				unset($_SESSION['compte_en_creation']);
			}
			return $donnees;
		}
		
		
		// prive
		private static function CreationUtilisateurBase($compte)
		{
			$ut['login'] = $compte['login'];
			$ut['mdp'] = $compte['mdp'];
			$ut['nom'] = $compte['nom'];
			$ut['prenom'] = $compte['prenom'];
			if (isset($compte['email'])) $ut['email'] = $compte['email'];
			$dt = new DateTime();
			$ut['date_inscription'] = $dt->format('Y-m-d H:i:s');
			return $ut;
		}
		
		private static function ValidationCompte(&$compte, $maj, $utilisateur = null)
		{
			// sauvegarde du compte saisi dans la session
			parent::StartSession();
			unset($_SESSION['compte_en_creation']);
			$_SESSION['compte_en_creation'] = $compte;
			
			// champs vides et donnees du mauvais type
			if (!is_string($compte['login'])) throw new CompteIsNotStrExcep('Indentifiant', $maj);
			$compte['login'] = trim($compte['login']);
			if (empty($compte['login'])) throw new CompteDonneeManquanteExcep('Indentifiant', $maj);
			if ($maj)
			{
				if (!is_string($compte['ancien_mdp'])) throw new CompteIsNotStrExcep('Ancien mot de passe', $maj);
				$compte['ancien_mdp'] = trim($compte['ancien_mdp']);
				if (empty($compte['ancien_mdp'])) throw new CompteDonneeManquanteExcep('Ancien mot de passe', $maj);
				if (!is_string($compte['mdp'])) throw new CompteIsNotStrExcep('Nouveau mot de passe', $maj);
				$compte['mdp'] = trim($compte['mdp']);
				if (!is_string($compte['mdp2'])) throw new CompteIsNotStrExcep('Répéter le nouveau mot de passe', $maj);
				$compte['mdp2'] = trim($compte['mdp2']);
				if (empty($compte['mdp']) && !empty($compte['mdp2'])) throw new CompteDonneeManquanteExcep('Nouveau mot de passe', $maj);
				if (!empty($compte['mdp']) && empty($compte['mdp2'])) throw new CompteDonneeManquanteExcep('Répéter le nouveau mot de passe', $maj);
			}
			else
			{
				if (!is_string($compte['mdp'])) throw new CompteIsNotStrExcep('Mot de passe', $maj);
				$compte['mdp'] = trim($compte['mdp']);
				if (empty($compte['mdp'])) throw new CompteDonneeManquanteExcep('Mot de passe', $maj);
				if (!is_string($compte['mdp2'])) throw new CompteIsNotStrExcep('Répéter le mot de passe', $maj);
				$compte['mdp2'] = trim($compte['mdp2']);
				if (empty($compte['mdp2'])) throw new CompteDonneeManquanteExcep('Répéter le mot de passe', $maj);
			}
			if (!is_string($compte['nom'])) throw new CompteIsNotStrExcep('Nom', $maj);
			$compte['nom'] = trim($compte['nom']);
			if (empty($compte['nom'])) throw new CompteDonneeManquanteExcep('Nom', $maj);
			if (!is_string($compte['prenom'])) throw new CompteIsNotStrExcep('Prénom', $maj);
			$compte['prenom'] = trim($compte['prenom']);
			if (empty($compte['prenom'])) throw new CompteDonneeManquanteExcep('Prénom', $maj);
			if (!is_string($compte['email_left'])) throw new CompteIsNotStrExcep('Email partie gauche', $maj);
			$compte['email_left'] = trim($compte['email_left']);
			if (!is_string($compte['email_right'])) throw new CompteIsNotStrExcep('Email partie droite', $maj);
			$compte['email_right'] = trim($compte['email_right']);
			if (!empty($compte['email_left']) && empty($compte['email_right'])) throw new CompteDonneeManquanteExcep('Email partie droite', $maj);
			if (empty($compte['email_left']) && !empty($compte['email_right'])) throw new CompteDonneeManquanteExcep('Email partie gauche', $maj);
			
			// creation de l'email
			$compte['email_left'] = trim($compte['email_left']);
			$compte['email_right'] = trim($compte['email_right']);
			if (!empty($compte['email_left']) && !empty($compte['email_right']))
				$compte['email'] = $compte['email_left'] . '@' . $compte['email_right'];
			
			// longueur des chaines
			if (strlen($compte['login']) < UT_LOGIN_LONGUEUR_MIN) throw new CompteChaineTropPetiteExcep('Indentifiant', UT_LOGIN_LONGUEUR_MIN, $maj);
			if (strlen($compte['login']) > UT_LOGIN_LONGUEUR_MAX) throw new CompteChaineTropGrandeExcep('Indentifiant', UT_LOGIN_LONGUEUR_MAX, $maj);
			if (!$maj || !empty($compte['mdp']))
			{
				if (strlen($compte['mdp']) < UT_MDP_LONGUEUR_MIN) throw new CompteChaineTropPetiteExcep('Mot de passe', UT_MDP_LONGUEUR_MIN, $maj);
				if (strlen($compte['mdp']) > UT_MDP_LONGUEUR_MAX) throw new CompteChaineTropGrandeExcep('Mot de passe', UT_MDP_LONGUEUR_MAX, $maj);
			}
			if (strlen($compte['nom']) > UT_NOM_LONGUEUR_MAX) throw new CompteChaineTropGrandeExcep('Nom', UT_NOM_LONGUEUR_MAX, $maj);
			if (strlen($compte['prenom']) > UT_PRENOM_LONGUEUR_MAX) throw new CompteChaineTropGrandeExcep('Prénom', UT_PRENOM_LONGUEUR_MAX, $maj);
			if (isset($compte['email']) && (strlen($compte['email']) > UT_EMAIL_LONGUEUR_MAX)) throw new CompteChaineTropGrandeExcep('Email', UT_EMAIL_LONGUEUR_MAX, $maj);
			
			// validite du login
			$daoUt = new DAOUtilisateur(parent::GetConnexion());
			$tmpUt = $daoUt->RetrieveByLogin($compte['login']);
			if ($maj)
			{
				if (!is_null($tmpUt) && ($tmpUt['id'] != $utilisateur['id'])) throw new CompteLoginExistantExcep($tmpUt['login'], $maj);
			}
			elseif (!is_null($tmpUt)) throw new CompteLoginExistantExcep($tmpUt['login'], $maj);
			
			// validite du mot de passe
			if (strcmp($compte['mdp'], $compte['mdp2']) != 0) throw new CompteRepMDPInvalideExcep($maj);
			if ($maj)
			{
				if (strcmp($compte['ancien_mdp'], $utilisateur['mdp']) != 0) throw new CompteAncienMDPInvalideExcep($maj);
				if (empty($compte['mdp']) && empty($compte['mdp2']))
					$compte['mdp'] = $compte['ancien_mdp'];
			}
			
			// validite des carateres du login et du mot de passe
			$validChar = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_@-+()*/.';
			if (strlen($compte['login']) != strspn($compte['login'], UT_LOGIN_CARATERES_VALIDES)) throw new CompteCaractereInvalideExcep(UT_LOGIN_CARATERES_VALIDES, $validChar, $maj);
			if (strlen($compte['mdp']) != strspn($compte['mdp'], UT_LOGIN_CARATERES_VALIDES)) throw new CompteCaractereInvalideExcep(UT_LOGIN_CARATERES_VALIDES, $validChar, $maj);
			
			// toutes les donnees sont bien valides donc l'enregistrement en session est detruit
			unset($_SESSION['compte_en_creation']);
		}
		
	}
