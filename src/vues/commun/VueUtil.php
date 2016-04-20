<?php
	// categorie
	function BindGoodCategories($cats, $catsDif, $catsPrix, $rec)
	{
		foreach ($cats as $i => $cat)
		{
			if ($rec['id_categorie'] == $cat['id'])
			{
				$break = FALSE;
				$donnees['categorie_select'] = $i;
				foreach ($cat['sous_categories'] as $j => $scat)
				{
					if ($rec['id_sous_categorie'] == $scat['id'])
					{
						$donnees['sous_categorie_select'] = $j;
						$break = TRUE;
						break;
					}
				}
				if ($break)
					break;
			}
		}
		foreach ($catsDif as $i => $cat)
			if ($rec['id_categorie_difficulte'] == $cat['id'])
			{
				$donnees['categorie_difficulte_select'] = $i;
				break;
			}
		foreach ($catsPrix as $i => $cat)
			if ($rec['id_categorie_prix'] == $cat['id'])
			{
				$donnees['categorie_prix_select'] = $i;
				break;
			}
		return $donnees;
	}