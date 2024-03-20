<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240320173012 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, therapist_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, filename VARCHAR(255) NOT NULL, update_at DATETIME NOT NULL, INDEX IDX_64C19C143E8B094 (therapist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE institution (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, therapist_id INT NOT NULL, patient_id INT NOT NULL, comment LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_CFBDFA1443E8B094 (therapist_id), INDEX IDX_CFBDFA146B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, birth_date DATE NOT NULL, school_grade VARCHAR(100) NOT NULL, roles JSON NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pictogram (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, subcategory_id_id INT NOT NULL, therapist_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, filename VARCHAR(255) NOT NULL, update_at DATETIME NOT NULL, genre VARCHAR(255) DEFAULT NULL, pluriel VARCHAR(255) DEFAULT NULL, masculin_sing VARCHAR(50) DEFAULT NULL, masculin_plur VARCHAR(50) DEFAULT NULL, feminin_sing VARCHAR(50) DEFAULT NULL, feminin_plur VARCHAR(50) DEFAULT NULL, prem_pers_sing VARCHAR(50) DEFAULT NULL, deux_pers_sing VARCHAR(50) DEFAULT NULL, trois_pers_sing VARCHAR(50) DEFAULT NULL, prem_pers_plur VARCHAR(50) DEFAULT NULL, deux_pers_plur VARCHAR(50) DEFAULT NULL, trois_pers_plur VARCHAR(50) DEFAULT NULL, prem_pers_sing_futur VARCHAR(50) DEFAULT NULL, deux_pers_sing_futur VARCHAR(50) DEFAULT NULL, trois_pers_sing_futur VARCHAR(50) DEFAULT NULL, prem_pers_plur_futur VARCHAR(50) DEFAULT NULL, deux_pers_plur_futur VARCHAR(50) DEFAULT NULL, trois_pers_plur_futur VARCHAR(50) DEFAULT NULL, prem_pers_sing_passe VARCHAR(50) DEFAULT NULL, deux_pers_sing_passe VARCHAR(50) DEFAULT NULL, trois_pers_sing_passe VARCHAR(50) DEFAULT NULL, prem_pers_plur_passe VARCHAR(50) DEFAULT NULL, deux_pers_plur_passe VARCHAR(50) DEFAULT NULL, trois_pers_plur_passe VARCHAR(50) DEFAULT NULL, INDEX IDX_56E0A15F12469DE2 (category_id), INDEX IDX_56E0A15FF78A56EE (subcategory_id_id), INDEX IDX_56E0A15F43E8B094 (therapist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, text VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question_category (question_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_6544A9CD1E27F6BF (question_id), INDEX IDX_6544A9CD12469DE2 (category_id), PRIMARY KEY(question_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sentence (id INT AUTO_INCREMENT NOT NULL, patient_id INT NOT NULL, text VARCHAR(255) DEFAULT NULL, audio VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_9D664ED56B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sentence_pictogram (sentence_id INT NOT NULL, pictogram_id INT NOT NULL, INDEX IDX_2C8F221A27289490 (sentence_id), INDEX IDX_2C8F221A16B7C33B (pictogram_id), PRIMARY KEY(sentence_id, pictogram_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sub_category (id INT AUTO_INCREMENT NOT NULL, category_id_id INT NOT NULL, therapist_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, filename VARCHAR(255) NOT NULL, update_at DATETIME NOT NULL, INDEX IDX_BCE3F7989777D11E (category_id_id), INDEX IDX_BCE3F79843E8B094 (therapist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE therapist (id INT AUTO_INCREMENT NOT NULL, institution_id INT DEFAULT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, email VARCHAR(100) NOT NULL, password VARCHAR(50) NOT NULL, job VARCHAR(100) NOT NULL, roles JSON NOT NULL, INDEX IDX_C3D632F10405986 (institution_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C143E8B094 FOREIGN KEY (therapist_id) REFERENCES therapist (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA1443E8B094 FOREIGN KEY (therapist_id) REFERENCES therapist (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA146B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE pictogram ADD CONSTRAINT FK_56E0A15F12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE pictogram ADD CONSTRAINT FK_56E0A15FF78A56EE FOREIGN KEY (subcategory_id_id) REFERENCES sub_category (id)');
        $this->addSql('ALTER TABLE pictogram ADD CONSTRAINT FK_56E0A15F43E8B094 FOREIGN KEY (therapist_id) REFERENCES therapist (id)');
        $this->addSql('ALTER TABLE question_category ADD CONSTRAINT FK_6544A9CD1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question_category ADD CONSTRAINT FK_6544A9CD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES therapist (id)');
        $this->addSql('ALTER TABLE sentence ADD CONSTRAINT FK_9D664ED56B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE sentence_pictogram ADD CONSTRAINT FK_2C8F221A27289490 FOREIGN KEY (sentence_id) REFERENCES sentence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sentence_pictogram ADD CONSTRAINT FK_2C8F221A16B7C33B FOREIGN KEY (pictogram_id) REFERENCES pictogram (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sub_category ADD CONSTRAINT FK_BCE3F7989777D11E FOREIGN KEY (category_id_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE sub_category ADD CONSTRAINT FK_BCE3F79843E8B094 FOREIGN KEY (therapist_id) REFERENCES therapist (id)');
        $this->addSql('ALTER TABLE therapist ADD CONSTRAINT FK_C3D632F10405986 FOREIGN KEY (institution_id) REFERENCES institution (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C143E8B094');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA1443E8B094');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA146B899279');
        $this->addSql('ALTER TABLE pictogram DROP FOREIGN KEY FK_56E0A15F12469DE2');
        $this->addSql('ALTER TABLE pictogram DROP FOREIGN KEY FK_56E0A15FF78A56EE');
        $this->addSql('ALTER TABLE pictogram DROP FOREIGN KEY FK_56E0A15F43E8B094');
        $this->addSql('ALTER TABLE question_category DROP FOREIGN KEY FK_6544A9CD1E27F6BF');
        $this->addSql('ALTER TABLE question_category DROP FOREIGN KEY FK_6544A9CD12469DE2');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE sentence DROP FOREIGN KEY FK_9D664ED56B899279');
        $this->addSql('ALTER TABLE sentence_pictogram DROP FOREIGN KEY FK_2C8F221A27289490');
        $this->addSql('ALTER TABLE sentence_pictogram DROP FOREIGN KEY FK_2C8F221A16B7C33B');
        $this->addSql('ALTER TABLE sub_category DROP FOREIGN KEY FK_BCE3F7989777D11E');
        $this->addSql('ALTER TABLE sub_category DROP FOREIGN KEY FK_BCE3F79843E8B094');
        $this->addSql('ALTER TABLE therapist DROP FOREIGN KEY FK_C3D632F10405986');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE institution');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE pictogram');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE question_category');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE sentence');
        $this->addSql('DROP TABLE sentence_pictogram');
        $this->addSql('DROP TABLE sub_category');
        $this->addSql('DROP TABLE therapist');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
