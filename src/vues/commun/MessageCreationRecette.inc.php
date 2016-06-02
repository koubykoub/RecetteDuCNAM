<?php if ($dVueMessage['modification_recette']) { ?>
<h2>Modification d'une recette</h2>
<p><span><?php echo $dVueMessage['utilisateur']['prenom'].' '.$dVueMessage['utilisateur']['nom'].' ('.$dVueMessage['utilisateur']['login'].')'; ?></span> a modifié la recette <span>"<?php echo $dVueMessage['recette']['titre']; ?>"</span></p>
<?php } else { ?>
<h2>Création d'une recette</h2>
<p><span><?php echo $dVueMessage['utilisateur']['prenom'].' '.$dVueMessage['utilisateur']['nom'].' ('.$dVueMessage['utilisateur']['login'].')'; ?></span> a créé la recette <span>"<?php echo $dVueMessage['recette']['titre']; ?>"</span></p>
<?php } ?>

