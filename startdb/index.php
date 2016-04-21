<?php
	include_once (dirname(__FILE__) . '/../db/db_define.inc.php');
	include_once (dirname(__FILE__) . '/../src/librairies/define/Define.inc.php');
	include_once (dirname(__FILE__) . '/../src/librairies/dao/Connexion.class.php');
	include_once (dirname(__FILE__) . '/../src/librairies/html/HtmlStruct.class.php');
	
	try
	{
		// connextion a la base
		$conn = new Connexion(SERVEUR, USER, PWD);
		
		// creation des tables
		include (dirname(__FILE__) . '/include/table.inc.php');
		
		// remplissage des tables avec des recettes au hasard
		HtmlStruct::DebutHtml('Création de base de donnée', array('../css/styles.css'), array());
		include (dirname(__FILE__) . '/include/random_recette.inc.php');
		HtmlStruct::FinHtml();
	}
	
	catch (PDOException $e)
	{
		HtmlStruct::DebutHtml('Erreur', array('../css/styles2.css'), array());
		HtmlStruct::Titre(1, 'Une erreur est survenue : '.$e->getMessage().'<br>');
		HtmlStruct::FinHtml();
		die();
	}
	
?>
