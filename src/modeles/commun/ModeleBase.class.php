<?php
	// modele de base
	class ModeleBase
	{
		// attributs
		private static $connexion;
		
		// connexion
		protected  static function GetConnexion()
		{
			return self::$connexion;
		}
		
		public static function SetConnexion($conn)
		{
			self::$connexion = $conn;
		}
		
		// start session
		protected static function StartSession()
		{
			if (session_status() == PHP_SESSION_NONE)
				session_start();
		}
		
	}
