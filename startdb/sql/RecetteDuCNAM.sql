-- Creation des tables de la base de donnée du site "Recette du CNAM" (creer avec phpMyAdmin)
SET FOREIGN_KEY_CHECKS = 0;


-- Destruction des toutes les vues
DROP VIEW IF EXISTS v_categorie;
DROP VIEW IF EXISTS v_sous_categorie;
DROP VIEW IF EXISTS v_categorie_prix;
DROP VIEW IF EXISTS v_categorie_difficulte;
DROP VIEW IF EXISTS v_ingredient;
DROP VIEW IF EXISTS v_etape_preparation;
DROP VIEW IF EXISTS v_commentaire;
DROP VIEW IF EXISTS v_recette;
DROP VIEW IF EXISTS v_utilisateur;

-- Destruction de toutes les tables
DROP TABLE IF EXISTS Utilisateur CASCADE;
DROP TABLE IF EXISTS Recette CASCADE;
DROP TABLE IF EXISTS Categorie CASCADE;
DROP TABLE IF EXISTS Sous_categorie CASCADE;
DROP TABLE IF EXISTS Categorie_prix CASCADE;
DROP TABLE IF EXISTS Categorie_difficulte CASCADE;
DROP TABLE IF EXISTS Ingredient CASCADE;
DROP TABLE IF EXISTS Etape_preparation CASCADE;
DROP TABLE IF EXISTS Commentaire CASCADE;


-- Creation des tables
CREATE TABLE Utilisateur
(
	id	INT		NOT NULL AUTO_INCREMENT,
	login	VARCHAR(30)	NOT NULL,
	mdp	VARCHAR(30)	NOT NULL,
	nom	VARCHAR(50)	NOT NULL,
	prenom	VARCHAR(50)	NOT NULL,
	email	VARCHAR(100),
	photo	VARCHAR(100),
	date_inscription DATETIME NOT NULL,
	admin	SMALLINT	NOT NULL DEFAULT 0,

	-- cle primaire
	CONSTRAINT pk_utilisateur PRIMARY KEY (id)
);

CREATE TABLE Recette
(
	id		INT		NOT NULL AUTO_INCREMENT,
	titre		VARCHAR(50)	NOT NULL,
	commentaire	VARCHAR(500),
	conseil		VARCHAR(500),
	nb_personne	SMALLINT	NOT NULL,
	photo		VARCHAR(100),
	date_creation	DATETIME	NOT NULL,
	date_maj	DATETIME	NOT NULL,
	temps_cuisson	INT,
	temps_preparation INT,
	id_sous_categorie INT		NOT NULL DEFAULT 0,
	id_categorie 	INT		NOT NULL DEFAULT 1,
	id_utilisateur	INT		NOT NULL,
	id_categorie_prix INT		NOT NULL DEFAULT 1,
	id_categorie_difficulte INT 	NOT NULL DEFAULT 1,

	-- cle primaire
	CONSTRAINT pk_recette PRIMARY KEY (id)
);

CREATE TABLE Categorie
(
	id		INT		NOT NULL AUTO_INCREMENT,
	intitule	VARCHAR(50)	NOT NULL,

	-- cle primaire
	CONSTRAINT pk_categorie PRIMARY KEY (id)
);

CREATE TABLE Sous_categorie
(
	id		INT		NOT NULL,
	id_categorie	INT		NOT NULL,
	intitule	VARCHAR(50)	NOT NULL,

	-- cle primaire
	CONSTRAINT pk_sous_categorie PRIMARY KEY (id, id_categorie)
);

CREATE TABLE Categorie_prix
(
	id		INT		NOT NULL AUTO_INCREMENT,
	intitule	VARCHAR(50)	NOT NULL,

	-- cle primaire
	CONSTRAINT pk_categorie_prix PRIMARY KEY (id)
);

CREATE TABLE Categorie_difficulte
(
	id		INT		NOT NULL AUTO_INCREMENT,
	intitule	VARCHAR(50)	NOT NULL,

	-- cle primaire
	CONSTRAINT pk_categorie_difficulte PRIMARY KEY (id)
);

CREATE TABLE Ingredient
(
	id		SMALLINT	NOT NULL,
	id_recette	INT		NOT NULL,
	texte_ingredient VARCHAR(100)	NOT NULL,

	-- cle primaire
	CONSTRAINT pk_ingredient PRIMARY KEY (id, id_recette)
);

CREATE TABLE Etape_preparation
(
	id		SMALLINT	NOT NULL,
	id_recette	INT		NOT NULL,
	texte_etape	VARCHAR(300)	NOT NULL,

	-- cle primaire
	CONSTRAINT pk_etape_preparation PRIMARY KEY (id, id_recette)
);

CREATE TABLE Commentaire
(
	id_utilisateur	INT		NOT NULL,
	id_recette	INT		NOT NULL,
	texte_commentaire VARCHAR(500)	NOT NULL,
	valeur_note	SMALLINT	NOT NULL,
	date_commentaire DATETIME	NOT NULL,

	-- cle primaire
	CONSTRAINT pk_commentaire PRIMARY KEY (id_utilisateur, id_recette)
);


-- Creation des cles uniques
ALTER TABLE Utilisateur ADD CONSTRAINT uk_utilisateur_login UNIQUE (login);
ALTER TABLE Categorie ADD CONSTRAINT uk_categorie_intitule UNIQUE (intitule);
ALTER TABLE Categorie_prix ADD CONSTRAINT uk_categorie_prix_intitule UNIQUE (intitule);
ALTER TABLE Categorie_difficulte ADD CONSTRAINT uk_categorie_difficulte_intitule UNIQUE (intitule);


-- Creation des cles etrangeres
ALTER TABLE Recette ADD CONSTRAINT fk_recette_id_sous_categorie FOREIGN KEY (id_sous_categorie, id_categorie) REFERENCES Sous_categorie (id, id_categorie);
ALTER TABLE Recette ADD CONSTRAINT fk_recette_id_utilisateur FOREIGN KEY (id_utilisateur) REFERENCES Utilisateur (id);
ALTER TABLE Recette ADD CONSTRAINT fk_recette_id_categorie_prix FOREIGN KEY (id_categorie_prix) REFERENCES Categorie_prix (id);
ALTER TABLE Recette ADD CONSTRAINT fk_recette_id_categorie_difficulte FOREIGN KEY (id_categorie_difficulte) REFERENCES Categorie_difficulte (id);
ALTER TABLE Sous_categorie ADD CONSTRAINT fk_sous_categorie_id_categorie FOREIGN KEY (id_categorie) REFERENCES Categorie (id);
ALTER TABLE Ingredient ADD CONSTRAINT fk_ingredient_id_recette FOREIGN KEY (id_recette) REFERENCES Recette (id);
ALTER TABLE Etape_preparation ADD CONSTRAINT fk_etape_preparation_id_recette FOREIGN KEY (id_recette) REFERENCES Recette (id);
ALTER TABLE Commentaire ADD CONSTRAINT fk_commentaire_id_utilisateur FOREIGN KEY (id_utilisateur) REFERENCES Utilisateur (id);
ALTER TABLE Commentaire ADD CONSTRAINT fk_commentaire_id_recette FOREIGN KEY (id_recette) REFERENCES Recette (id);


-- Creation des contraintes de validation
ALTER TABLE Utilisateur ADD CONSTRAINT ck_utilisateur_login CHECK (LENGTH(login) BETWEEN 6 AND 30);
ALTER TABLE Utilisateur ADD CONSTRAINT ck_utilisateur_mdp CHECK (LENGTH(mdp) BETWEEN 6 AND 30);
ALTER TABLE Utilisateur ADD CONSTRAINT ck_utilisateur_nom CHECK (LENGTH(nom) <= 50);
ALTER TABLE Utilisateur ADD CONSTRAINT ck_utilisateur_prenom CHECK (LENGTH(prenom) <= 50);
ALTER TABLE Utilisateur ADD CONSTRAINT ck_utilisateur_email CHECK (LENGTH(email) <= 100);
ALTER TABLE Utilisateur ADD CONSTRAINT ck_utilisateur_admin CHECK (admin BETWEEN 0 AND 1);
ALTER TABLE Recette ADD CONSTRAINT ck_recette_titre CHECK (LENGTH(titre) BETWEEN 6 AND 50);
ALTER TABLE Recette ADD CONSTRAINT ck_recette_commentaire CHECK (LENGTH(commentaire) <= 500);
ALTER TABLE Recette ADD CONSTRAINT ck_recette_conseil CHECK (LENGTH(conseil) <= 500);
ALTER TABLE Recette ADD CONSTRAINT ck_recette_nb_personne CHECK (nb_personne >= 1);
ALTER TABLE Recette ADD CONSTRAINT ck_recette_temps_cuisson CHECK (temps_cuisson >= 0);
ALTER TABLE Recette ADD CONSTRAINT ck_recette_temps_preparation CHECK (temps_preparation >= 0);
ALTER TABLE Categorie ADD CONSTRAINT ck_categorie_intitule CHECK (LENGTH(intitule) <= 50);
ALTER TABLE Sous_categorie ADD CONSTRAINT ck_sous_categorie_intitule CHECK (LENGTH(intitule) <= 50);
ALTER TABLE Categorie_difficulte ADD CONSTRAINT ck_categorie_difficulte_intitule CHECK (LENGTH(intitule) <= 50);
ALTER TABLE Categorie_prix ADD CONSTRAINT ck_categorie_prix_intitule CHECK (LENGTH(intitule) <= 50);
ALTER TABLE Ingredient ADD CONSTRAINT ck_ingredient_texte_ingredient CHECK (LENGTH(texte_ingredient) <= 100);
ALTER TABLE Ingredient ADD CONSTRAINT ck_ingredient_id CHECK (id < 30);
ALTER TABLE Etape_preparation ADD CONSTRAINT ck_etape_preparation_texte_etape CHECK (LENGTH(texte_etape) <= 300);
ALTER TABLE Etape_preparation ADD CONSTRAINT ck_etape_preparation_id CHECK (id < 50);
ALTER TABLE Commentaire ADD CONSTRAINT ck_commentaire_texte_commentaire CHECK (LENGTH(texte_commentaire) <= 500);
ALTER TABLE Commentaire ADD CONSTRAINT ck_commentaire_valeur_note CHECK (valeur_note BETWEEN 0 AND 5);


-- Creation des index
CREATE INDEX idx_utilisateur_nom ON Utilisateur (nom);
CREATE INDEX idx_utilisateur_prenom ON Utilisateur (prenom);
CREATE INDEX idx_recette_titre ON Recette (titre);
CREATE INDEX idx_recette_id_sous_categorie ON Recette (id_sous_categorie);
CREATE INDEX idx_recette_id_utilisateur ON Recette (id_utilisateur);
CREATE INDEX idx_recette_id_categorie_prix ON Recette (id_categorie_prix);
CREATE INDEX idx_recette_id_categorie_difficulte ON Recette (id_categorie_difficulte);
CREATE INDEX idx_sous_categorie_id_categorie ON Sous_categorie (id_categorie);
CREATE INDEX idx_ingredient_id_recette ON Ingredient (id_recette);
CREATE INDEX idx_etape_preparation_id_recette ON Etape_preparation (id_recette);
CREATE INDEX idx_commentaire_id_utilisateur ON Commentaire (id_utilisateur);
CREATE INDEX idx_commentaire_id_recette ON Commentaire (id_recette);


-- Creation des vues
CREATE VIEW v_utilisateur AS
	SELECT id, login, mdp, nom, prenom, email, photo, date_inscription, admin
	FROM Utilisateur;

CREATE VIEW v_recette AS
	SELECT id, titre, commentaire, conseil, nb_personne, photo, date_creation, date_maj, temps_cuisson, temps_preparation, id_sous_categorie, id_categorie, id_utilisateur, id_categorie_prix, id_categorie_difficulte
	FROM Recette;

CREATE VIEW v_categorie AS
	SELECT id, intitule
	FROM Categorie;

CREATE VIEW v_sous_categorie AS
	SELECT id, id_categorie, intitule
	FROM Sous_categorie;

CREATE VIEW v_categorie_prix AS
	SELECT id, intitule
	FROM Categorie_prix;

CREATE VIEW v_categorie_difficulte AS
	SELECT id, intitule
	FROM Categorie_difficulte;

CREATE VIEW v_ingredient AS
	SELECT id, id_recette, texte_ingredient
	FROM Ingredient;

CREATE VIEW v_etape_preparation AS
	SELECT id, id_recette, texte_etape
	FROM Etape_preparation;

CREATE VIEW v_commentaire AS
	SELECT id_utilisateur, id_recette, texte_commentaire, valeur_note, date_commentaire
	FROM Commentaire;

