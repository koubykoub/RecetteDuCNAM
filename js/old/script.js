
// gestion du menu categorie / sous categorie
function InputCategorie()
{
	$("ul.menu_categorie li > a").hover(function()
	{
		// afficher le panneau
		$(this).parent().find("ul.menu_sous_categorie").slideDown('fast').show();
		$(this).parent().hover(
			function() {},
			function()
			{	
				$(this).parent().find("ul.menu_sous_categorie").slideUp('fast');
			}
		);
	}).hover();
}


// document pret
$(document).ready(function()
{
	// menu des categories / sous categories
	InputCategorie();
});
