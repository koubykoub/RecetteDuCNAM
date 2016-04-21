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
		$finfo = new finfo(FILEINFO_MIME_TYPE);
		$ftype = $finfo->file($donneesModele['image_name']);
		$eltInfo = explode('/', $ftype);
		if (isset($eltInfo[1])) $donneesModele['image_type'] = $eltInfo[1];
		$donneesModele['image_content'] = file_get_contents($donneesModele['image_name']);
	}
	
	
	// vue
	if (isset($donneesModele))
	{
		if (isset($donneesModele['image_type']))
		{
			// header
			header('Content-type:image/' . $donneesModele['image_type']);
			
			// affichage de l'image
			echo $donneesModele['image_content'];
		}
	}
	