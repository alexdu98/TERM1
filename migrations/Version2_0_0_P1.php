<?php

declare(strict_types=1);

namespace AppBundle\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version2_0_0_P1 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE aimer_phrase DROP FOREIGN KEY FK_F9374D828671F084');
        $this->addSql('ALTER TABLE aimer_phrase DROP FOREIGN KEY FK_F9374D826A99F74A');
        $this->addSql('ALTER TABLE glose DROP FOREIGN KEY FK_E681270460BB6FE6');
        $this->addSql('ALTER TABLE glose DROP FOREIGN KEY FK_E6812704D3DF658');
        $this->addSql('ALTER TABLE groupe DROP FOREIGN KEY FK_4B98C2122EE1947');
        $this->addSql('ALTER TABLE historique DROP FOREIGN KEY FK_EDBFD5EC6A99F74A');
        $this->addSql('ALTER TABLE jugement DROP FOREIGN KEY FK_F53C8E501391DFBF');
        $this->addSql('ALTER TABLE jugement DROP FOREIGN KEY FK_F53C8E5038DFE8A6');
        $this->addSql('ALTER TABLE jugement DROP FOREIGN KEY FK_F53C8E5057AFE0E9');
        $this->addSql('ALTER TABLE jugement DROP FOREIGN KEY FK_F53C8E505F6C043E');
        $this->addSql('ALTER TABLE jugement DROP FOREIGN KEY FK_F53C8E5060BB6FE6');
        $this->addSql('ALTER TABLE membre DROP FOREIGN KEY FK_F6B4FB29B3E9C81');
        $this->addSql('ALTER TABLE membre DROP FOREIGN KEY FK_F6B4FB297A45358C');
        $this->addSql('ALTER TABLE mot_ambigu DROP FOREIGN KEY FK_C73E770060BB6FE6');
        $this->addSql('ALTER TABLE mot_ambigu DROP FOREIGN KEY FK_C73E7700D3DF658');
        $this->addSql('ALTER TABLE mot_ambigu_phrase DROP FOREIGN KEY FK_B8D4ECAE8671F084');
        $this->addSql('ALTER TABLE mot_ambigu_phrase DROP FOREIGN KEY FK_B8D4ECAEC75E376D');
        $this->addSql('ALTER TABLE partie DROP FOREIGN KEY FK_59B1F3D8671F084');
        $this->addSql('ALTER TABLE partie DROP FOREIGN KEY FK_59B1F3DA9E2D76C');
        $this->addSql('ALTER TABLE phrase DROP FOREIGN KEY FK_A24BE60C60BB6FE6');
        $this->addSql('ALTER TABLE phrase DROP FOREIGN KEY FK_A24BE60CD3DF658');
        $this->addSql('ALTER TABLE niveau DROP FOREIGN KEY FK_4BDFF36B20AB2E86');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC7B3E9C81');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC75DAA1781');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC721326CD9');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC760BB6FE6');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC7C6D21FCF');
        $this->addSql('ALTER TABLE succes DROP FOREIGN KEY FK_BFC223836716180A');
        $this->addSql('ALTER TABLE succes DROP FOREIGN KEY FK_BFC22383FA37F5BB');
        $this->addSql('ALTER TABLE succes_membre DROP FOREIGN KEY FK_E1857E2A4EF1B4AB');

        $this->addSql('DROP INDEX IDX_F9374D828671F084 ON aimer_phrase');
        $this->addSql('DROP INDEX IDX_F9374D826A99F74A ON aimer_phrase');
        $this->addSql('DROP INDEX IDX_AIMERPHRASE_DATECREATION ON aimer_phrase');
        $this->addSql('DROP INDEX UNIQ_CDBBCF3ACDBBCF3A ON categorie_jugement');
        $this->addSql('DROP INDEX UNIQ_E68127041B44CD51 ON glose');
        $this->addSql('DROP INDEX IDX_E681270460BB6FE6 ON glose');
        $this->addSql('DROP INDEX IDX_E6812704D3DF658 ON glose');
        $this->addSql('DROP INDEX IDX_GLOSE_DATECREATION ON glose');
        $this->addSql('DROP INDEX IDX_GLOSE_DATEMODIFICATION ON glose');
        $this->addSql('DROP INDEX IDX_4B98C2122EE1947 ON groupe');
        $this->addSql('DROP INDEX UNIQ_4B98C216C6E55B5 ON groupe');
        $this->addSql('DROP INDEX IDX_EDBFD5EC6A99F74A ON historique');
        $this->addSql('DROP INDEX IDX_HISTORIQUE_DATEACTION ON historique');
        $this->addSql('DROP INDEX IDX_F53C8E501391DFBF ON jugement');
        $this->addSql('DROP INDEX IDX_F53C8E5038DFE8A6 ON jugement');
        $this->addSql('DROP INDEX IDX_F53C8E5057AFE0E9 ON jugement');
        $this->addSql('DROP INDEX IDX_F53C8E505F6C043E ON jugement');
        $this->addSql('DROP INDEX IDX_F53C8E5060BB6FE6 ON jugement');
        $this->addSql('DROP INDEX IDX_JUGEMENT_DATECREATION ON jugement');
        $this->addSql('DROP INDEX IDX_JUGEMENT_DATEDELIBERATION ON jugement');
        $this->addSql('DROP INDEX IDX_JUGEMENT_IDOBJET ON jugement');
        $this->addSql('DROP INDEX UNIQ_F6B4FB2986CC499D ON membre');
        $this->addSql('DROP INDEX UNIQ_F6B4FB293BAF2475 ON membre');
        $this->addSql('DROP INDEX IDX_F6B4FB297A45358C ON membre');
        $this->addSql('DROP INDEX IDX_MEMBRE_DATE_CONNEXION ON membre');
        $this->addSql('DROP INDEX UNIQ_F6B4FB29E7927C74 ON membre');
        $this->addSql('DROP INDEX UNIQ_F6B4FB29EA2BF86C ON membre');
        $this->addSql('DROP INDEX UNIQ_F6B4FB29C8F7D2C6 ON membre');
        $this->addSql('DROP INDEX IDX_F6B4FB29B3E9C81 ON membre');
        $this->addSql('DROP INDEX IDX_MEMBRE_CREDITS ON membre');
        $this->addSql('DROP INDEX IDX_MEMBRE_DATEINSCRIPTION ON membre');
        $this->addSql('DROP INDEX IDX_MEMBRE_DATENAISSANCE ON membre');
        $this->addSql('DROP INDEX IDX_MEMBRE_POINTSCLASSEMENT ON membre');
        $this->addSql('DROP INDEX IDX_MEMBRE_SEXE ON membre');
        $this->addSql('DROP INDEX IDX_C73E770060BB6FE6 ON mot_ambigu');
        $this->addSql('DROP INDEX IDX_C73E7700D3DF658 ON mot_ambigu');
        $this->addSql('DROP INDEX IDX_MOTAMBIGU_DATECREATION ON mot_ambigu');
        $this->addSql('DROP INDEX IDX_MOTAMBIGU_DATEMODIFICATION ON mot_ambigu');
        $this->addSql('DROP INDEX UNIQ_C73E77001B44CD51 ON mot_ambigu');
        $this->addSql('DROP INDEX IDX_B8D4ECAE8671F084 ON mot_ambigu_phrase');
        $this->addSql('DROP INDEX IDX_B8D4ECAEC75E376D ON mot_ambigu_phrase');
        $this->addSql('DROP INDEX IDX_59B1F3D8671F084 ON partie');
        $this->addSql('DROP INDEX IDX_59B1F3DA9E2D76C ON partie');
        $this->addSql('DROP INDEX IDX_PARTIE_DATEPARTIE ON partie');
        $this->addSql('DROP INDEX UNIQ_A24BE60CCF7853A4 ON phrase');
        $this->addSql('DROP INDEX IDX_A24BE60C60BB6FE6 ON phrase');
        $this->addSql('DROP INDEX IDX_A24BE60CD3DF658 ON phrase');
        $this->addSql('DROP INDEX IDX_PHRASE_DATECREATION ON phrase');
        $this->addSql('DROP INDEX IDX_PHRASE_DATEMODIFICATION ON phrase');
        $this->addSql('DROP INDEX IDX_5FB6DEC75DAA1781 ON reponse');
        $this->addSql('DROP INDEX IDX_5FB6DEC7B3E9C81 ON reponse');
        $this->addSql('DROP INDEX IDX_5FB6DEC721326CD9 ON reponse');
        $this->addSql('DROP INDEX IDX_5FB6DEC760BB6FE6 ON reponse');
        $this->addSql('DROP INDEX IDX_5FB6DEC7C6D21FCF ON reponse');
        $this->addSql('DROP INDEX IDX_REPONSE_DATEREPONSE ON reponse');
        $this->addSql('DROP INDEX IDX_REPONSE_IP ON reponse');
        $this->addSql('DROP INDEX UNIQ_57698A6A6C6E55B5 ON role');
        $this->addSql('DROP INDEX UNIQ_48C1CBCF48C1CBCF ON type_objet');
        $this->addSql('DROP INDEX UNIQ_8D1F406C8D1F406C ON type_vote');
        $this->addSql('DROP INDEX IDX_VISITE_DATEVISITE ON visite');
        $this->addSql('DROP INDEX IDX_VISITE_IP ON visite');
        $this->addSql('DROP INDEX IDX_VISITE_USERAGENT ON visite');

        $this->addSql('DROP TABLE membre_role');
        $this->addSql('DROP TABLE newsletter');
        $this->addSql('DROP TABLE niveau');
        $this->addSql('DROP TABLE poids_reponse');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE succes');
        $this->addSql('DROP TABLE succes_membre');
        $this->addSql('DROP TABLE type_succes');
        $this->addSql('DROP TABLE vote_jugement');

        $this->addSql('TRUNCATE groupe');

        $this->addSql('RENAME TABLE aimer_phrase TO j_aime');
        $this->addSql('RENAME TABLE jugement TO signalement');
        $this->addSql('RENAME TABLE categorie_jugement TO categorie_signalement');

        $this->addSql('CREATE TABLE membre_groupe (membre_id INT NOT NULL, groupe_id INT NOT NULL, PRIMARY KEY(membre_id, groupe_id)) engine=InnoDB collate=utf8_unicode_ci');
        $this->addSql('CREATE TABLE role(id INT AUTO_INCREMENT PRIMARY KEY, parent_id INT NULL, name VARCHAR(255) NOT NULL) engine=InnoDB collate=utf8_unicode_ci');
        $this->addSql('CREATE TABLE badge (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, nombre INT NOT NULL, ordre INT NOT NULL, description VARCHAR(255) NOT NULL, points INT NOT NULL, UNIQUE INDEX uc_badg_typnbr (type, nombre), PRIMARY KEY(id), UNIQUE INDEX uc_badg_typordr (type, ordre)) engine=InnoDB collate=utf8_unicode_ci');
        $this->addSql('CREATE TABLE membre_badge (id INT AUTO_INCREMENT NOT NULL, membre_id INT NOT NULL, badge_id INT NOT NULL, date_obtention DATETIME NOT NULL, INDEX ix_mbrebadg_mbreid (membre_id), INDEX ix_mbrebadg_badgid (badge_id), INDEX ix_mbrebadg_dtobt (date_obtention), UNIQUE INDEX uc_mbrebadg_mbreidbadgid (membre_id, badge_id), PRIMARY KEY(id)) engine=InnoDB collate=utf8_unicode_ci');

        $this->addSql('ALTER TABLE signalement CHANGE categorie_jugement_id categorie_signalement_id INT NOT NULL');
        $this->addSql('ALTER TABLE categorie_signalement CHANGE categorie_jugement nom VARCHAR(32) NOT NULL');
        $this->addSql('ALTER TABLE type_vote CHANGE type_vote nom VARCHAR(16) NOT NULL');
        $this->addSql('ALTER TABLE groupe ADD name VARCHAR(180) NOT NULL, DROP groupe_parent_id, DROP nom, CHANGE roles roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');

        $this->addSql('DELETE FROM glose WHERE auteur_id IN (SELECT id FROM membre WHERE mdp IS NULL)');
        $this->addSql('DELETE FROM membre WHERE mdp IS NULL');
        $this->addSql('DELETE FROM glose WHERE auteur_id NOT IN (SELECT id FROM membre)');
        $this->addSql('ALTER TABLE membre CHANGE pseudo username VARCHAR(180) NOT NULL, ADD username_canonical VARCHAR(180) NOT NULL, ADD email_canonical VARCHAR(180) NOT NULL, ADD salt VARCHAR(255) DEFAULT NULL, ADD renamable TINYINT(1) NOT NULL DEFAULT 0, CHANGE mdp password VARCHAR(255) NOT NULL, CHANGE date_connexion last_login DATETIME DEFAULT NULL, ADD confirmation_token VARCHAR(180) DEFAULT NULL, ADD password_requested_at DATETIME DEFAULT NULL, ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', DROP groupe_id, DROP cle_oubli_mdp, DROP id_facebook, DROP id_twitter, CHANGE email email VARCHAR(180) NOT NULL, CHANGE sexe sexe VARCHAR(8) DEFAULT NULL, CHANGE date_naissance date_naissance DATETIME DEFAULT NULL, CHANGE commentaire_ban commentaire_ban VARCHAR(128) DEFAULT NULL, CHANGE date_deban date_deban DATETIME DEFAULT NULL, CHANGE actif enabled TINYINT(1) NOT NULL, ADD points_classement_mensuel INT NOT NULL DEFAULT 0, ADD points_classement_hebdomadaire INT NOT NULL DEFAULT 0, ADD facebook_id VARCHAR(255) DEFAULT NULL, ADD twitter_id VARCHAR(255) DEFAULT NULL, ADD google_id VARCHAR(255) DEFAULT NULL, ADD service_creation TINYINT(1) NOT NULL, ADD signale TINYINT(1) NOT NULL DEFAULT 0, CHANGE points_classement points_classement INT NOT NULL DEFAULT 0, CHANGE credits credits INT NOT NULL DEFAULT 0, DROP niveau_id');

        $this->addSql('DELETE FROM mot_ambigu_glose WHERE glose_id NOT IN (SELECT id FROM glose)');

        $this->addSql('DELETE FROM reponse WHERE auteur_id IS NULL');
        $this->addSql('DELETE FROM reponse WHERE glose_id NOT IN (SELECT id FROM glose)');
        $this->addSql('ALTER TABLE reponse ADD phrase_id INT, DROP poids_reponse_id, DROP niveau_id, CHANGE auteur_id auteur_id INT NOT NULL');

        $this->addSql('UPDATE reponse r INNER JOIN mot_ambigu_phrase map ON map.id=r.mot_ambigu_phrase_id SET r.phrase_id = map.phrase_id');
        $this->addSql('ALTER TABLE reponse CHANGE phrase_id phrase_id INT NOT NULL, DROP ip');

        $this->addSql('ALTER TABLE signalement CHANGE id_objet objet_id INT NOT NULL');

        $this->addSql('ALTER TABLE categorie_signalement ADD CONSTRAINT uc_catsig_nom UNIQUE (nom)');
        $this->addSql('ALTER TABLE glose ADD CONSTRAINT uc_glose_val UNIQUE (valeur)');
        $this->addSql('ALTER TABLE groupe ADD CONSTRAINT uc_grp_name UNIQUE (name)');
        $this->addSql('ALTER TABLE j_aime ADD CONSTRAINT uc_jaim_mbreidphraseid UNIQUE (membre_id, phrase_id)');
        $this->addSql('ALTER TABLE membre ADD CONSTRAINT uc_mbre_conftokn UNIQUE (confirmation_token)');
        $this->addSql('ALTER TABLE membre ADD CONSTRAINT uc_mbre_fbid UNIQUE (facebook_id)');
        $this->addSql('ALTER TABLE membre ADD CONSTRAINT uc_mbre_twitid UNIQUE (twitter_id)');
        $this->addSql('ALTER TABLE membre ADD CONSTRAINT uc_mbre_googlid UNIQUE (google_id)');
        $this->addSql('ALTER TABLE mot_ambigu ADD CONSTRAINT uc_motamb_val UNIQUE (valeur)');
        $this->addSql('ALTER TABLE phrase ADD CONSTRAINT uc_phrase_contpur UNIQUE (contenu_pur)');
        $this->addSql('ALTER TABLE role ADD CONSTRAINT uc_rol_name UNIQUE (name)');
        $this->addSql('ALTER TABLE type_objet ADD CONSTRAINT uc_typobj_typobj UNIQUE (type_objet)');
        $this->addSql('ALTER TABLE type_vote ADD CONSTRAINT uc_typvot_typvot UNIQUE (nom)');

        $this->addSql('ALTER TABLE glose ADD CONSTRAINT fk_glose_autid FOREIGN KEY (auteur_id) REFERENCES membre (id)');
        $this->addSql('ALTER TABLE glose ADD CONSTRAINT fk_glose_modifid FOREIGN KEY (modificateur_id) REFERENCES membre (id)');
        $this->addSql('ALTER TABLE historique ADD CONSTRAINT fk_hist_mbreid FOREIGN KEY (membre_id) REFERENCES membre (id)');
        $this->addSql('ALTER TABLE j_aime ADD CONSTRAINT fk_jaim_mbreid FOREIGN KEY (membre_id) REFERENCES membre (id)');
        $this->addSql('ALTER TABLE j_aime ADD CONSTRAINT fk_jaim_phraseid FOREIGN KEY (phrase_id) REFERENCES phrase (id)');
        $this->addSql('ALTER TABLE signalement ADD CONSTRAINT fk_sig_verdid FOREIGN KEY (verdict_id) REFERENCES type_vote (id)');
        $this->addSql('ALTER TABLE signalement ADD CONSTRAINT fk_sig_typobjid FOREIGN KEY (type_objet_id) REFERENCES type_objet (id)');
        $this->addSql('ALTER TABLE signalement ADD CONSTRAINT fk_sig_jugeid FOREIGN KEY (juge_id) REFERENCES membre (id)');
        $this->addSql('ALTER TABLE signalement ADD CONSTRAINT fk_sig_catsigid FOREIGN KEY (categorie_signalement_id) REFERENCES categorie_signalement (id)');
        $this->addSql('ALTER TABLE signalement ADD CONSTRAINT fk_sig_autid FOREIGN KEY (auteur_id) REFERENCES membre (id)');
        $this->addSql('ALTER TABLE mot_ambigu ADD CONSTRAINT fk_motamb_autid FOREIGN KEY (auteur_id) REFERENCES membre (id)');
        $this->addSql('ALTER TABLE mot_ambigu ADD CONSTRAINT fk_motamb_modifid FOREIGN KEY (modificateur_id) REFERENCES membre (id)');
        $this->addSql('ALTER TABLE mot_ambigu_phrase ADD CONSTRAINT fk_motambphrase_phraseid FOREIGN KEY (phrase_id) REFERENCES phrase (id)');
        $this->addSql('ALTER TABLE mot_ambigu_phrase ADD CONSTRAINT fk_motambphrase_motambid FOREIGN KEY (mot_ambigu_id) REFERENCES mot_ambigu (id)');
        $this->addSql('ALTER TABLE partie ADD CONSTRAINT fk_part_phraseid FOREIGN KEY (phrase_id) REFERENCES phrase (id)');
        $this->addSql('ALTER TABLE partie ADD CONSTRAINT fk_part_mbreid FOREIGN KEY (joueur_id) REFERENCES membre (id)');
        $this->addSql('ALTER TABLE phrase ADD CONSTRAINT fk_phrase_autid FOREIGN KEY (auteur_id) REFERENCES membre (id)');
        $this->addSql('ALTER TABLE phrase ADD CONSTRAINT fk_phrase_modifid FOREIGN KEY (modificateur_id) REFERENCES membre (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT fk_rep_gloseid FOREIGN KEY (glose_id) REFERENCES glose (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT fk_rep_mbreid FOREIGN KEY (auteur_id) REFERENCES membre (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT fk_rep_motambphraseid FOREIGN KEY (mot_ambigu_phrase_id) REFERENCES mot_ambigu_phrase (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT fk_rep_phraseid FOREIGN KEY (phrase_id) REFERENCES phrase (id)');
        $this->addSql('ALTER TABLE role ADD CONSTRAINT fk_rol_parentid FOREIGN KEY (parent_id) REFERENCES role (id)');

        $this->addSql('CREATE INDEX ix_glose_autid ON glose (auteur_id)');
        $this->addSql('CREATE INDEX ix_glose_modifid ON glose (modificateur_id)');
        $this->addSql('CREATE INDEX ix_glose_dtcreat ON glose (date_creation)');
        $this->addSql('CREATE INDEX ix_glose_dtmodif ON glose (date_modification)');
        $this->addSql('CREATE INDEX ix_hist_val ON historique (valeur)');
        $this->addSql('CREATE INDEX ix_hist_mbreid ON historique (membre_id)');
        $this->addSql('CREATE INDEX ix_hist_dtact ON historique (date_action)');
        $this->addSql('CREATE INDEX ix_jaim_mbreid ON j_aime (membre_id)');
        $this->addSql('CREATE INDEX ix_jaim_phraseid ON j_aime (phrase_id)');
        $this->addSql('CREATE INDEX ix_jaim_dtcreat ON j_aime (date_creation)');
        $this->addSql('CREATE INDEX ix_sig_verdid ON signalement (verdict_id)');
        $this->addSql('CREATE INDEX ix_sig_typobjid ON signalement (type_objet_id)');
        $this->addSql('CREATE INDEX ix_sig_jugeid ON signalement (juge_id)');
        $this->addSql('CREATE INDEX ix_sig_catsigid ON signalement (categorie_signalement_id)');
        $this->addSql('CREATE INDEX ix_sig_autid ON signalement (auteur_id)');
        $this->addSql('CREATE INDEX ix_sig_dtcreat ON signalement (date_creation)');
        $this->addSql('CREATE INDEX ix_sig_dtdelib ON signalement (date_deliberation)');
        $this->addSql('CREATE INDEX ix_sig_objid ON signalement (objet_id)');
        $this->addSql('CREATE INDEX ix_mbre_ptsclasheb ON membre (points_classement_hebdomadaire)');
        $this->addSql('CREATE INDEX ix_mbre_ptsclasmen ON membre (points_classement_mensuel)');
        $this->addSql('CREATE INDEX ix_mbre_cred ON membre (credits)');
        $this->addSql('CREATE INDEX ix_mbre_dtinscr ON membre (date_inscription)');
        $this->addSql('CREATE INDEX ix_mbre_dtnaiss ON membre (date_naissance)');
        $this->addSql('CREATE INDEX ix_mbre_ptsclas ON membre (points_classement)');
        $this->addSql('CREATE INDEX IDX_9EB019986A99F74A ON membre_groupe (membre_id)');
        $this->addSql('CREATE INDEX IDX_9EB019987A45358C ON membre_groupe (groupe_id)');
        $this->addSql('CREATE INDEX ix_motamb_autid ON mot_ambigu (auteur_id)');
        $this->addSql('CREATE INDEX ix_motamb_modifid ON mot_ambigu (modificateur_id)');
        $this->addSql('CREATE INDEX ix_motamb_dtcreat ON mot_ambigu (date_creation)');
        $this->addSql('CREATE INDEX ix_motamb_dtmodif ON mot_ambigu (date_modification)');
        $this->addSql('CREATE INDEX ix_part_phraseid ON partie (phrase_id)');
        $this->addSql('CREATE INDEX ix_part_joueurid ON partie (joueur_id)');
        $this->addSql('CREATE INDEX ix_part_dtpart ON partie (date_partie)');
        $this->addSql('CREATE INDEX ix_part_gainjoueur ON partie (gain_joueur)');
        $this->addSql('CREATE INDEX ix_phrase_gaincreat ON phrase (gain_createur)');
        $this->addSql('CREATE INDEX ix_phrase_autid ON phrase (auteur_id)');
        $this->addSql('CREATE INDEX ix_phrase_modifid ON phrase (modificateur_id)');
        $this->addSql('CREATE INDEX ix_phrase_dtcreat ON phrase (date_creation)');
        $this->addSql('CREATE INDEX ix_phrase_dtmodif ON phrase (date_modification)');
        $this->addSql('CREATE INDEX ix_rep_phraseid ON reponse (phrase_id)');
        $this->addSql('CREATE INDEX ix_rep_gloseid ON reponse (glose_id)');
        $this->addSql('CREATE INDEX ix_rep_auteurid ON reponse (auteur_id)');
        $this->addSql('CREATE INDEX ix_rep_motambphraseid ON reponse (mot_ambigu_phrase_id)');
        $this->addSql('CREATE INDEX ix_rep_dtrep ON reponse (date_reponse)');
        $this->addSql('CREATE INDEX ix_rol_parentid ON role (parent_id)');
        $this->addSql('CREATE INDEX ix_visit_dtvisit ON visite (date_visite)');
        $this->addSql('CREATE INDEX ix_visit_ip ON visite (ip)');
        $this->addSql('CREATE INDEX ix_visit_useragent ON visite (user_agent)');

        $this->addSql('INSERT INTO groupe(id, name, roles) VALUES(1, "Administrateur", \'a:1:{i:0;s:19:"ROLE_ADMINISTRATEUR";}\')');
        $this->addSql('INSERT INTO groupe(id, name, roles) VALUES(2, "Modérateur", \'a:1:{i:0;s:15:"ROLE_MODERATEUR";}\')');
        $this->addSql('INSERT INTO groupe(id, name, roles) VALUES(3, "Membre", \'a:1:{i:0;s:9:"ROLE_USER";}\')');
        $this->addSql('INSERT INTO membre_groupe(membre_id, groupe_id) VALUES(48, 1)');
        $this->addSql('INSERT INTO membre_groupe(membre_id, groupe_id) VALUES(58, 1)');
        $this->addSql('INSERT INTO membre_groupe(membre_id, groupe_id) VALUES(69, 1)');
        $this->addSql('INSERT INTO membre_groupe(membre_id, groupe_id) VALUES(71, 1)');
        $this->addSql('INSERT INTO membre_groupe(membre_id, groupe_id) VALUES(72, 1)');
        $this->addSql('INSERT INTO membre_groupe(membre_id, groupe_id) VALUES(74, 1)');
        $this->addSql('INSERT INTO role(id, parent_id, name) VALUES(1, null, \'ROLE_SUPER_ADMIN\')');
        $this->addSql('INSERT INTO role(id, parent_id, name) VALUES(2, 1, \'ROLE_ADMINISTRATEUR\')');
        $this->addSql('INSERT INTO role(id, parent_id, name) VALUES(3, 2, \'ROLE_MODERATEUR\')');
        $this->addSql('INSERT INTO role(id, parent_id, name) VALUES(4, 3, \'ROLE_USER\')');
        $this->addSql('INSERT INTO membre_groupe SELECT m.id, 3 FROM membre m WHERE m.id not in (SELECT membre_id FROM membre_groupe)');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'JOUER_PARTIE_TOTAL\', 10, 1, 30, \'Jouer 10 parties\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'JOUER_PARTIE_TOTAL\', 50, 2, 150, \'Jouer 50 parties\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'JOUER_PARTIE_TOTAL\', 250, 3, 750, \'Jouer 250 parties\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'JOUER_PARTIE_TOTAL\', 500, 4, 1500, \'Jouer 500 parties\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'JOUER_PARTIE_TOTAL\', 1000, 5, 3000, \'Jouer 1000 parties\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'JOUER_PARTIE_1_JOUR\', 10, 1, 35, \'Jouer 10 parties en 1 jour\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'JOUER_PARTIE_1_JOUR\', 50, 2, 175, \'Jouer 50 parties en 1 jour\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'JOUER_PARTIE_1_JOUR\', 250, 3, 875, \'Jouer 250 parties en 1 jour\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'JOUER_PARTIE_1_JOUR\', 500, 4, 1750, \'Jouer 500 parties en 1 jour\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'JOUER_PARTIE_3_JOURS\', 10, 1, 60, \'Jouer 10 phrases tous les jours pendant 3 jours\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'JOUER_PARTIE_3_JOURS\', 25, 2, 150, \'Jouer 25 phrases tous les jours pendant 3 jours\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'JOUER_PARTIE_3_JOURS\', 50, 3, 300, \'Jouer 50 phrases tous les jours pendant 3 jours\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'JOUER_PARTIE_3_JOURS\', 100, 4, 600, \'Jouer 100 phrases tous les jours pendant 3 jours\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'JOUER_PARTIE_7_JOURS\', 10, 1, 210, \'Jouer 10 phrases tous les jours pendant 7 jours\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'JOUER_PARTIE_7_JOURS\', 25, 2, 525, \'Jouer 25 phrases tous les jours pendant 7 jours\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'JOUER_PARTIE_7_JOURS\', 50, 3, 1050, \'Jouer 50 phrases tous les jours pendant 7 jours\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'JOUER_PARTIE_7_JOURS\', 100, 4, 2100, \'Jouer 100 phrases tous les jours pendant 7 jours\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'CREER_PHRASE_TOTAL\', 5, 1, 55, \'Créer 5 phrases\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'CREER_PHRASE_TOTAL\', 10, 2, 110, \'Créer 10 phrases\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'CREER_PHRASE_TOTAL\', 25, 3, 275, \'Créer 25 phrases\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'CREER_PHRASE_TOTAL\', 50, 4, 550, \'Créer 50 phrases\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'CREER_PHRASE_TOTAL\', 125, 5, 1375, \'Créer 125 phrases\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'CREER_PHRASE_TOTAL\', 250, 6, 2750, \'Créer 250 phrases\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'CREER_PHRASE_TOTAL\', 500, 7, 5500, \'Créer 500 phrases\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'CREER_PHRASE_1_JOUR\', 5, 1, 55, \'Créer 5 phrases en 1 jour\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'CREER_PHRASE_1_JOUR\', 15, 2, 165, \'Créer 15 phrases en 1 jour\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'CREER_PHRASE_1_JOUR\', 30, 3, 330, \'Créer 30 phrases en 1 jour\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'CREER_PHRASE_3_JOURS\', 5, 1, 155, \'Créer 5 phrases tous les jours pendant 3 jours\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'CREER_PHRASE_3_JOURS\', 10, 2, 310, \'Créer 10 phrases tous les jours pendant 3 jours\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'CREER_PHRASE_7_JOURS\', 5, 1, 355, \'Créer 5 phrases tous les jours pendant 7 jours\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'CREER_PHRASE_7_JOURS\', 10, 2, 710, \'Créer 10 phrases tous les jours pendant 7 jours\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'RECEVOIR_JAIME_TOTAL\', 10, 1, 60, \'Recevoir 10 "j\'\'aime"\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'RECEVOIR_JAIME_TOTAL\', 50, 2, 300, \'Recevoir 50 "j\'\'aime"\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'RECEVOIR_JAIME_TOTAL\', 125, 3, 750, \'Recevoir 125 "j\'\'aime"\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'RECEVOIR_JAIME_TOTAL\', 250, 4, 1500, \'Recevoir 250 "j\'\'aime"\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'RECEVOIR_JAIME_TOTAL\', 500, 5, 3000, \'Recevoir 500 "j\'\'aime"\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'RECEVOIR_JAIME_1_PHRASE\', 5, 1, 105, \'Recevoir 5 "j\'\'aime" sur 1 phrase\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'RECEVOIR_JAIME_1_PHRASE\', 10, 2, 210, \'Recevoir 10 "j\'\'aime" sur 1 phrase\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'RECEVOIR_JAIME_1_PHRASE\', 25, 3, 525, \'Recevoir 25 "j\'\'aime" sur 1 phrase\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'RECEVOIR_JAIME_1_PHRASE\', 50, 4, 1050, \'Recevoir 50 "j\'\'aime" sur 1 phrase\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'RECEVOIR_JAIME_1_PHRASE\', 100, 5, 2100, \'Recevoir 100 "j\'\'aime" sur 1 phrase\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'SIGNALEMENT_VALIDE_TOTAL\', 5, 1, 105, \'Faire 5 signalements valides\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'SIGNALEMENT_VALIDE_TOTAL\', 10, 2, 210, \'Faire 10 signalements valides\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'SIGNALEMENT_VALIDE_TOTAL\', 25, 3, 525, \'Faire 25 signalements valides\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'SIGNALEMENT_VALIDE_TOTAL\', 50, 4, 1050, \'Faire 50 signalements valides\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'SIGNALEMENT_VALIDE_TOTAL\', 100, 5, 2100, \'Faire 100 signalements valides\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'SIGNALEMENT_VALIDE_TOTAL\', 250, 6, 5250, \'Faire 250 signalements valides\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'CLASSEMENT_HEBDO\', 3, 1, 250, \'Finir dans les 3 premiers au classement hebdomadaire\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'CLASSEMENT_HEBDO\', 1, 2, 500, \'Finir premier au classement hebdomadaire\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'CLASSEMENT_MEN\', 3, 1, 500, \'Finir dans les 3 premiers au classement mensuel\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'CLASSEMENT_MEN\', 1, 2, 1000, \'Finir premier au classement mensuel\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'CLASSEMENT_GEN\', 10, 1, 100, \'Être dans les 10 premiers au classement général\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'CLASSEMENT_GEN\', 3, 2, 250, \'Être dans les 3 premiers au classement général\')');
        $this->addSql('INSERT INTO badge(type, nombre, ordre, points, description) VALUES(\'CLASSEMENT_GEN\', 1, 3, 500, \'Être premier au classement général\')');

        $this->addSql('UPDATE membre SET roles = "a:0:{}"');
        $this->addSql('UPDATE membre SET roles = \'a:1:{i:0;s:16:"ROLE_SUPER_ADMIN";}\' WHERE username = \'alex\'');

        $this->addSql('DELETE FROM signalement WHERE type_objet_id = 5');
        $this->addSql('DELETE FROM type_objet WHERE id = 5');
        $this->addSql('DELETE FROM signalement WHERE type_objet_id = 1');
        $this->addSql('DELETE FROM type_objet WHERE id = 1');

        $this->addSql('UPDATE signalement SET date_deliberation = NULL WHERE verdict_id IS NULL');
    }

    public function down(Schema $schema) : void
    {

    }
}
