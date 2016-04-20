<?php
	// assure la connexion avec une base de donnee
	class Connexion
	{
		// attributs
		private $dbh;
		private $serveur;
		private $user;
		private $pwd;
		
		// constructeur
		public function __construct($serveur, $user, $pwd)
		{
			$this->SetConnextion($serveur, $user, $pwd);
		}
		
		// destructeur
		public function __destruct()
		{
			$dbh = null;
		}
		
		// creation d'une nouvelle connexion
		public function SetConnextion($serveur, $user, $pwd)
		{
			$this->serveur = $serveur;
			$this->user = $user;
			$this->pwd = $pwd;
			$this->dbh = new PDO($this->serveur, $this->user, $this->pwd);
			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		
		// getters des attributs
		public function GetDB()
		{
			return $this->dbh;
		}
		
		public function GetServeur()
		{
			return $this->serveur;
		}
		
		public function GetUser()
		{
			return $this->user;
		}
		
		public function GetPwd()
		{
			return $this->pwd;
		}
		
	}
