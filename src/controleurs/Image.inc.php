<?php
	// constroleur
	if (isset($_REQUEST['image']) && !is_null($_REQUEST['image']))
		$donneesControleur['image'] = $_REQUEST['image'];
	else
		$donneesControleur['image'] = '';
	
	
	// modele
	if (!empty($donneesControleur['image']))
	{
		$donneesModele['image_name'] = 'upload/image/' . $donneesControleur['image'];
		$donneesModele['image_content'] = file_get_contents($donneesModele['image_name']);
	}
	
	
	// vue
	if (isset($donneesModele))
	{
		header('Content-type:image/png');
		echo $donneesModele['image_content'];
	}
	