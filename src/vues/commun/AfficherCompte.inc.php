<!-- titre -->
<h2>Mon compte :</h2>

<!-- infos -->
<ul>
  <li>Identifiant : <span><?php echo $dVueAfficherCompte['login']; ?></span></li>
  <li>Nom : <span><?php echo $dVueAfficherCompte['nom']; ?></span></li>
  <li>Prénom : <span><?php echo $dVueAfficherCompte['prenom']; ?></span></li>
  <?php if (isset($dVueAfficherCompte['email'])) { ?>
  <li>Email : <span><?php echo $dVueAfficherCompte['email']; ?></span></li>
  <?php } else { ?>
  <li>Email non renseigné</li>
  <?php } ?>
</ul>

<!-- modifier le compte -->
<form method="post" action="" name="modifier_compte">
	<input type="hidden" name="page" id="page" value="modifier_compte" />
	<a href="javascript:document.modifier_compte.submit()">Modifier le compte</a>
</form>
