<?php
	include_once (dirname(__FILE__) . '/DAO.class.php');

	final class DAOUtilisateur extends DAO
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
			SELECT id, login, mdp, nom, prenom, email, photo, date_inscription
			FROM v_utilisateur
SQL;
			return $this->RetrieveAllGen($sql);
		}
		
		public function RetrieveById($id)
		{
			$sql =
<<<SQL
			SELECT id, login, mdp, nom, prenom, email, photo, date_inscription
			FROM v_utilisateur
			WHERE id = :id
SQL;
			$resultat = $this->Prepare($sql);
			$resultat->bindParam('id', $id, PDO::PARAM_INT);
			$resultat->execute();
			return $this->RetrieveGenEx($resultat);
		}
		
		public function RetrieveByLogin($login)
		{
			// execute la requette
			$sql =
<<<SQL
			SELECT id, login, mdp, nom, prenom, email, photo, date_inscription
			FROM v_utilisateur
			WHERE login = :login
SQL;
			$resultat = $this->Prepare($sql);
			$resultat->bindParam('login', $login, PDO::PARAM_STR);
			$resultat->execute();
			return $this->RetrieveGenEx($resultat);
		}
		
		public function IsExistsByLogin($login)
		{
			// execute la requette
			$sql =
<<<SQL
			SELECT id
			FROM v_utilisateur
			WHERE login = :login
SQL;
			$resultat = $this->Prepare($sql);
			$resultat->bindParam('login', $login, PDO::PARAM_STR);
			$resultat->execute();
			return $this->RetrieveGenEx($resultat) != null;
		}
		
		// create
		public function Create($ut)
		{
			// creation d'un utilisateur
			$sql =
<<<SQL
			INSERT INTO v_utilisateur (login, mdp, nom, prenom, email, photo, date_inscription)
			VALUES (:login, :mdp, :nom, :prenom, :email, :photo, :date_inscription)
SQL;
			$resultat = $this->Prepare($sql);
			self::BindUtilisateurBase($resultat, $ut);
			$resultat->execute();
			return $this->connexion->GetDB()->lastInsertId();
		}
		
		// update
		public function Update($ut)
		{
			// modification d'un utilisateur
			$sql =
<<<SQL
			UPDATE v_utilisateur SET login = :login, mdp = :mdp, nom = :nom, prenom = :prenom,
								 	 email = :email, photo = :photo, date_inscription = :date_inscription
			WHERE v_utilisateur.id = :id
SQL;
			$resultat = $this->Prepare($sql);
			self::BindUtilisateurBase($resultat, $ut);
			$resultat->bindParam('id', $ut['id'], PDO::PARAM_INT);
			$resultat->execute();
			return $ut['id'];
		}
		
		
		// fonctions privees
		private static function BindUtilisateurBase(&$resultat, $ut)
		{
			$resultat->bindParam('login', $ut['login'], PDO::PARAM_STR);
			$resultat->bindParam('mdp', $ut['mdp'], PDO::PARAM_STR);
			$resultat->bindParam('nom', $ut['nom'], PDO::PARAM_STR);
			$resultat->bindParam('prenom', $ut['prenom'], PDO::PARAM_STR);
			$resultat->bindParam('email', $ut['email'], isset($ut['email']) ? PDO::PARAM_STR : PDO::PARAM_NULL);
			$resultat->bindParam('photo', $ut['photo'], isset($ut['photo']) ? PDO::PARAM_LOB : PDO::PARAM_NULL);
			$resultat->bindParam('date_inscription', $ut['date_inscription'], PDO::PARAM_STR);
		}
		
	}
