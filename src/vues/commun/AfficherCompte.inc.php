<!-- titre -->
<h2>Mon compte</h2>

<!-- infos -->
<ul>
  <li><label>Identifiant : </label><span><?php echo $dVueAfficherCompte['login']; ?></span></li>
  <li><label>Nom : </label><span><?php echo $dVueAfficherCompte['nom']; ?></span></li>
  <li><label>Prénom : </label><span><?php echo $dVueAfficherCompte['prenom']; ?></span></li>
  <?php if (isset($dVueAfficherCompte['email'])) { ?>
  <li><label>Email : </label><span><?php echo $dVueAfficherCompte['email']; ?></span></li>
  <?php } else { ?>
  <li><label>Email non renseigné</label></li>
  <?php } ?>
  
  <!-- photo -->
  <?php if (isset($dVueAfficherCompte['photo'])) { ?>
  <li>
  		<img alt="" src="?page=image&image=<?php echo $dVueAfficherCompte['photo']; ?>" />
  </li>
  <?php } ?>
</ul>

<!-- modifier le compte -->
<form method="post" action="" name="modifier_compte">
	<input type="hidden" name="page" id="page" value="modifier_compte" />
	<a href="javascript:document.modifier_compte.submit()">Modifier le compte</a>
</form>

<form method="post" action="" name="supprimer_compte">
	<input type="hidden" name="page" id="page" value="accueil" />
	<input type="hidden" name="detruire_compte" id="detruire_compte" value="true" />
	<a href="javascript:AfficherCompte_ConfirmDelete()">Détruire votre compte</a>
	<input type="checkbox" name="garder_recette" id="garder_recette" value="true" checked="checked" /><label for="garder_recette">Laisser mes recettes sur le site &nbsp;</label>
</form>
