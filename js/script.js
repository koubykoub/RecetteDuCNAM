
/**************************************************************/
/* MENU CRITERE						  						  */
/**************************************************************/
function MenuCritere_Init()
{
	// affiche / cache les sous categories
	// lien categorie
	$('.menu_critere form > ul > li > a').hover(
	function() {$(this).parent().find('ul').show();},
	function() {$(this).parent().find('ul').hide();});
	// panneau sous categorie
	$('.menu_critere form > ul ul').hover(	
	function() {$(this).show();},
	function() {$(this).hide();});
}

function MenuCritere_Toutes()
{
	$('.menu_critere form').append($('<input />').attr('type', 'hidden')
											     .attr('name', 'critere_toutes')
											     .attr('id', 'critere_toutes')
											     .attr('value', 'true'));
}

function MenuCritere_Categorie(id)
{
	$('.menu_critere form').append($('<input />').attr('type', 'hidden')
												   .attr('name', 'critere_id_categorie')
												   .attr('id', 'critere_id_categorie')
												   .attr('value', id));
}

function MenuCritere_SousCategorie(idSCat, idCat)
{
	$('.menu_critere form').append($('<input />').attr('type', 'hidden')
												   .attr('name', 'critere_id_sous_categorie')
												   .attr('id', 'critere_id_sous_categorie')
												   .attr('value', idSCat));
	MenuCritere_Categorie(idCat);
}


/**************************************************************/
/* CREER RECETTE											  */
/**************************************************************/
function CreerRecette_Init()
{
	$('.section_principale_large form li#last_ingredient > input').click(CreerRecette_AjouterIngredient);
	$('.section_principale_large form li#last_etape_preparation > input').click(CreerRecette_AjouterEtapePreparation);
	$('.section_principale_large .recette_detail select#categorie').change(CreerRecette_ChangerCategorie);
	CreerRecette_CalculerContenu('ingredient');
	CreerRecette_CalculerContenu('etape_preparation');
}

function CreerRecette_GetNbElement(elt)
{
	return $('.section_principale_large form ul#' + elt + ' > li').length - 1;
}

function CreerRecette_GetEniemeElement(elt, n)
{
	return $('.section_principale_large form ul#' + elt + ' > li:nth-child(' + (n + 1) + ')');
}

function CreerRecette_PermuterRecette(elt, id1, id2)
{
	var li1 = CreerRecette_GetEniemeElement(elt, id1);
	var li2 = CreerRecette_GetEniemeElement(elt, id2);
	var tmp = li1.find('textarea').val();
	li1.find('textarea').val(li2.find('textarea').val());
	li2.find('textarea').val(tmp);
}

function CreerRecette_CalculerContenu(elt)
{
	// recreation des boutons et des id
	var n = CreerRecette_GetNbElement(elt);
	for (var i = 0 ; i < n ; ++i)
	{
		// id
		var li = CreerRecette_GetEniemeElement(elt, i);
		li.find('textarea').attr('name', elt + '_' + i).attr('id', elt + '_' + i);
		
		// boutons
		li.find('input').remove();
		if (n > 1)
		{
			// bouton de suppression
			var supprBouton = $('<input />')
			.attr('type', 'button')
			.attr('value', '-')
			.attr('onclick', 'javascript:CreerRecette_SupprimerElement("' + elt + '", ' + i + ');');
			li.append(supprBouton);
			
			// boutons de deplacements
			if (i > 0)
			{
				var upBouton = $('<input />')
				.attr('type', 'button')
				.attr('value', 'monter')
				.attr('onclick', 'javascript:CreerRecette_PermuterRecette("' + elt + '", ' + i + ', ' + (i - 1) + ');');
				li.append(upBouton);
			}
			if (i < (n - 1))
			{
				var downBouton = $('<input />')
				.attr('type', 'button')
				.attr('value', 'descendre')
				.attr('onclick', 'javascript:CreerRecette_PermuterRecette("' + elt + '", ' + i + ', ' + (i + 1) + ');');
				li.append(downBouton);
			}
		}
	}
}

function CreerRecette_SupprimerElement(elt, n)
{
	// suppression de la cellule
	CreerRecette_GetEniemeElement(elt, n).remove();
	
	// recalculer le contenu des elements
	CreerRecette_CalculerContenu(elt);
}

function CreerRecette_AjouterElement(elt, rows)
{
	// numero de l'element
	var n = CreerRecette_GetNbElement(elt);
	
	// creation du text area
	var textArea = $('<textarea />')
				.attr('rows', rows)
	 			.attr('cols', 75)
	 			.attr('name', elt + '_' + n)
	 			.attr('id', elt + '_' + n);
	 					
	// creation du nouveau li
	var li = $('<li />').append(textArea);
	li.insertBefore('.section_principale_large form li#last_' + elt);
	
	// recalculer le contenu des elements
	CreerRecette_CalculerContenu(elt);
}

function CreerRecette_AjouterIngredient()
{
	CreerRecette_AjouterElement('ingredient', 1);
}

function CreerRecette_AjouterEtapePreparation()
{
	CreerRecette_AjouterElement('etape_preparation', 2);
}

function CreerRecette_ChangerCategorie()
{
	var selected = $('.section_principale_large .recette_detail select#categorie option:selected');
	var inputs = $('.section_principale_large > input');
	var select = $('.section_principale_large .recette_detail select#sous_categorie');
	select.empty();
	inputs.each(function(i){
		if ($(this).attr('id') == selected.attr('value'))
		{
			var option = $('<option />');
			option.attr('value', $(this).attr('value'));
			option.text($(this).attr('name'));
			if (i == 0)
				option.attr('selected', 'selected');
			select.append(option);
		}
	});
}


/**************************************************************/
/* AFFICHER RECETTE											  */
/**************************************************************/
function AfficherRecette_ConfirmDelete()
{
	var confirm = window.confirm("Etes vous sûr de vouloir détruire cette recette ?");
	if (confirm)
		document.supprimer_recette.submit();
}


/**************************************************************/
/* DOCUMENT PRET											  */
/**************************************************************/
$(document).ready(function()
{
	// menu critere
	CreerRecette_Init();
	
	// creation de recette
	MenuCritere_Init();
	
});
