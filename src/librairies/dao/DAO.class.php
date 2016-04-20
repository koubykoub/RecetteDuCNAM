<?php
	include_once(dirname(__FILE__) . '/Connexion.class.php');
	
	// class de base des DAO (Data base Access Object) permettant de récupérer les donnees sur une base de donnee
	abstract class DAO
	{
		// attributs
		protected $connexion;
		
		// constructeur
		public function __construct(Connexion $connexion)
		{
			$this->connexion = $connexion;
		}
		
		// getter
		public function GetConnexion()
		{
			return $this->connexion;
		}
		
		// prepare une requette sql
		protected function Prepare($sql)
		{
			$resultat = $this->connexion->GetDB()->prepare($sql);
			$resultat->setFetchMode(PDO::FETCH_ASSOC);
			return $resultat;
		}
		
		// renvoie generique
		protected function RetrieveAllGen($sql)
		{
			// execute la requette
			$resultat = $this->Prepare($sql);
			$resultat->execute();
			return $this->RetrieveAllGenEx($resultat);
		}
		
		protected function RetrieveAllGenEx($resultat)
		{
			// creation de la liste
			$listElt = array();
			if (!is_null($resultat))
			{
				foreach ($resultat as $resElt)
					$listElt[] = $resElt;
			}
		
			// renvoie la liste
			return $listElt;
		}
		
		protected function RetrieveGen($sql)
		{
			// execute la requette
			$resultat = $this->Prepare($sql);
			$resultat->execute();
			return $this->RetrieveGenEx($resultat);
		}
		
		protected function RetrieveGenEx($resultat)
		{
			// renvoie le premier element
			if (!is_null($resultat))
			{
				foreach ($resultat as $resElt)
					return $resElt;
			}
			return null;
		}

	}
