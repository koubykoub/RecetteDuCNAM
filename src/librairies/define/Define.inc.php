<?php
	// data base
	DEFINE ('SERVEUR', 'mysql:host=localhost;dbname=Recette_du_CNAM');
	DEFINE ('USER', 'RecetteDuCNAM_wb'); // utilisateur
	DEFINE ('PWD', 'koub'); // password
	
	// nombre de recettes par page
	DEFINE ('RECETTES_PAR_PAGE', 10);
	
	// utilisateur validation
	DEFINE ('UT_LOGIN_LONGUEUR_MIN', 6);
	DEFINE ('UT_LOGIN_LONGUEUR_MAX', 30);
	DEFINE ('UT_MDP_LONGUEUR_MIN', 6);
	DEFINE ('UT_MDP_LONGUEUR_MAX', 30);
	DEFINE ('UT_NOM_LONGUEUR_MAX', 50);
	DEFINE ('UT_PRENOM_LONGUEUR_MAX', 50);
	DEFINE ('UT_EMAIL_LONGUEUR_MAX', 100);
	DEFINE ('UT_LOGIN_CARATERES_VALIDES', '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ._@*');
	
	// recette validation
	DEFINE ('REC_NB_INGREDIENT_MIN', 1);
	DEFINE ('REC_NB_INGREDIENT_MAX', 30);
	DEFINE ('REC_NB_ETAPE_MIN', 1);
	DEFINE ('REC_NB_ETAPE_MAX', 50);
	DEFINE ('REC_TITRE_LONGUEUR_MIN', 6);
	DEFINE ('REC_TITRE_LONGUEUR_MAX', 50);
	DEFINE ('REC_COMMENTAIRE_LONGUEUR_MAX', 500);
	DEFINE ('REC_CONSEIL_LONGUEUR_MAX', 500);
	DEFINE ('REC_INGREDIENT_LONGUEUR_MAX', 100);
	DEFINE ('REC_ETAPE_LONGUEUR_MAX', 300);
	DEFINE ('REC_NB_PERSONNE_MIN', 1);
	DEFINE ('REC_TEMPS_CUISSON_MIN', 0);
	DEFINE ('REC_TEMPS_PREPARATION_MIN', 0);
	
	// commentaire
	DEFINE ('COMM_NOTE_MIN', 0);
	DEFINE ('COMM_NOTE_MAX', 5);
	DEFINE ('COMM_TEXTE_LONGUEUR_MAX', 500);
	