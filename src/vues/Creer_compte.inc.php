<?php
	include_once (dirname(__FILE__) . '/../librairies/html/HtmlStruct.class.php');
	
	// donnees de la vue
	// titre
	$dVueTitre['head'] = 'Créer un compte';
	$dVueTitre['body'] = 'CREER UN COMPTE';
	// creer compte
	$dVueCreerCompte['mise_a_jour'] = FALSE;
	$dVueCreerCompte['remplissage'] = FALSE;
	if ($donneesModele['identification']['identifie'])
	{
		$dVueCreerCompte['remplissage'] = TRUE;
		$dVueCreerCompte['utilisateur'] = $donneesModele['identification']['utilisateur'];
	}
	
	// include
	include (dirname(__FILE__) . '/Creer_compte_base.inc.php');
	
?>
