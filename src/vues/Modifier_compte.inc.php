<?php
	include_once (dirname(__FILE__) . '/../librairies/html/HtmlStruct.class.php');
	
	// donnees de la vue
	// titre
	$dVueTitre['head'] = 'Modifier un compte';
	$dVueTitre['body'] = 'MODIFIER VOTRE COMPTE ('.$donneesModele['identification']['utilisateur']['login'].')';
	// creer compte
	$dVueCreerCompte['mise_a_jour'] = TRUE;
	$dVueCreerCompte['remplissage'] = TRUE;
	if ($donneesModele['compte_session']['identifie'])
	{
		$dVueCreerCompte['utilisateur'] = $donneesModele['compte_session']['utilisateur'];
		if (isset($donneesModele['identification']['utilisateur']['photo']))
			$dVueCreerCompte['utilisateur']['photo'] = $donneesModele['identification']['utilisateur']['photo'];
	}
	else 
	{
		$dVueCreerCompte['utilisateur'] = $donneesModele['identification']['utilisateur'];
		$dVueCreerCompte['utilisateur']['email_left'] = '';
		$dVueCreerCompte['utilisateur']['email_right'] = '';
		if (isset($dVueCreerCompte['utilisateur']['email']))
		{
			$email = explode('@', $dVueCreerCompte['utilisateur']['email']);
			$dVueCreerCompte['utilisateur']['email_left'] = $email[0];
			$dVueCreerCompte['utilisateur']['email_right'] = $email[1];
		}
	}
	
	// include
	include (dirname(__FILE__) . '/Creer_compte_base.inc.php');
