<?php
	include_once (dirname(__FILE__) . '/../librairies/html/HtmlStruct.class.php');
	
	// html
	HtmlStruct::DebutHtml('Erreur', array('css/styles.css'), array('js/script.js'));
	
	
		// header
		HtmlStruct::DebutHeader();
			// logo
			HtmlStruct::DebutNav('section_logo');
				include (dirname(__FILE__) . '/commun/Logo.inc.php');
			HtmlStruct::FinNav();
				
			// en tete
			HtmlStruct::DebutSection('section_header');
				// titre
				HtmlStruct::Titre(1, 'ERREUR');
			HtmlStruct::FinSection(true);
		HtmlStruct::FinHeader();
		
		
		// section
		HtmlStruct::DebutSection();
			// creer compte
			HtmlStruct::DebutSection('section_principale_large');
				echo $excepMessage;
			HtmlStruct::FinSection();
		HtmlStruct::FinSection();
		
	
	// fin html
	HtmlStruct::FinHtml();
	
?>
