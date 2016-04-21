<?php
	$file = fopen(dirname(__FILE__) . '/../sql/RecetteDuCNAM.sql', 'r');
	if ($file)
	{
		$contenu = fread($file, filesize(dirname(__FILE__) . '/../sql/RecetteDuCNAM.sql'));
		$conn->GetDB()->exec($contenu);
	}
	fclose($file);
