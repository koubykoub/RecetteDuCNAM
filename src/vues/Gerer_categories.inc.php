<?php
	include_once (dirname(__FILE__) . '/../librairies/html/HtmlStruct.class.php');
	
	// html
	HtmlStruct::DebutHtml('Gérer les catégories', array('css/styles.css'), array('js/script.js'));
	
	
		// header
		HtmlStruct::DebutHeader();
			// logo
			HtmlStruct::DebutNav('section_logo');
				include (dirname(__FILE__) . '/commun/Logo.inc.php');
			HtmlStruct::FinNav();
				
			// en tete
			HtmlStruct::DebutSection('section_header');
				// titre
				HtmlStruct::Titre(1, 'GESTION DES CATEGORIES', 'gerer_categorie_titre');
			HtmlStruct::FinSection(true);
		HtmlStruct::FinHeader();
		
		
		// section
		HtmlStruct::DebutSection();
			// creer compte
			HtmlStruct::DebutSection('section_principale_large');
				echo 'Gestion des catégories';
			HtmlStruct::FinSection();
		HtmlStruct::FinSection();
		
		
		// footer
		HtmlStruct::DebutFooter();
			// lien recette
			HtmlStruct::DebutNav('footer_nav');
				include (dirname(__FILE__) . '/commun/LienRetourListeRecette.inc.php');
			HtmlStruct::FinNav(true);
		HtmlStruct::FinFooter();
	
	// fin html
	HtmlStruct::FinHtml();
