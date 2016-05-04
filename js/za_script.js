// init menu
function za_InitMenu()
{
	// create menu
	za_data.menu.menu_categorie = za_CreateMenuCategorie();
	za_data.menu.menu_sous_categorie = za_CreateMenuSousCategorie();
	za_data.menu.menu_categorie_diff = za_CreateMenuCategorieDiff();
	za_data.menu.menu_categorie_prix = za_CreateMenuCategoriePrix();
	za_data.menu.menu_utilisateur = za_CreateMenuUtilisateur();
	za_data.menu.menu_recette = za_CreateMenuRecette();
	za_data.menu.menu_commentaire = za_CreateMenuCommentaire();
	
	// init DOM
	var za_section = $('section.section_zone_administration');
	for (var key in za_data.menu)
		za_section.append(za_data.menu[key].DOMElement);
}

/* FIN INIT ***************************************************/


/**************************************************************/
/* DOCUMENT PRET											  */
/**************************************************************/
$(document).ready(function()
{
	// menu
	za_InitMenu();
});
