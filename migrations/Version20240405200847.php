<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240405200847 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, super_category_id INT DEFAULT NULL, therapist_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, filename VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_64C19C1B85A1111 (super_category_id), INDEX IDX_64C19C143E8B094 (therapist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE institution (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, patient_id INT NOT NULL, therapist_id INT NOT NULL, comment LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_CFBDFA146B899279 (patient_id), INDEX IDX_CFBDFA1443E8B094 (therapist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, birth_date DATE NOT NULL, school_grade VARCHAR(100) NOT NULL, roles JSON NOT NULL, sex VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pictogram_adjective (id INT AUTO_INCREMENT NOT NULL, therapist_id INT DEFAULT NULL, category_id INT NOT NULL, sentences_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, filename VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', sing_masculin VARCHAR(255) NOT NULL, sing_feminin VARCHAR(255) NOT NULL, plur_masculin VARCHAR(255) NOT NULL, plur_feminin VARCHAR(255) NOT NULL, INDEX IDX_82B2308F43E8B094 (therapist_id), INDEX IDX_82B2308F12469DE2 (category_id), INDEX IDX_82B2308F175906F5 (sentences_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pictogram_noun (id INT AUTO_INCREMENT NOT NULL, therapist_id INT DEFAULT NULL, category_id INT NOT NULL, sentences_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, filename VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', genre VARCHAR(100) NOT NULL, singular VARCHAR(255) DEFAULT NULL, plurial VARCHAR(255) DEFAULT NULL, INDEX IDX_16C66ECE43E8B094 (therapist_id), INDEX IDX_16C66ECE12469DE2 (category_id), INDEX IDX_16C66ECE175906F5 (sentences_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pictogram_others (id INT AUTO_INCREMENT NOT NULL, therapist_id INT DEFAULT NULL, category_id INT NOT NULL, sentences_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, filename VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_18E59CC143E8B094 (therapist_id), INDEX IDX_18E59CC112469DE2 (category_id), INDEX IDX_18E59CC1175906F5 (sentences_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pictogram_pronoun (id INT AUTO_INCREMENT NOT NULL, therapist_id INT DEFAULT NULL, category_id INT NOT NULL, sentences_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, filename VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', person VARCHAR(255) NOT NULL, number VARCHAR(255) NOT NULL, genre VARCHAR(255) DEFAULT NULL, INDEX IDX_F43977E643E8B094 (therapist_id), INDEX IDX_F43977E612469DE2 (category_id), INDEX IDX_F43977E6175906F5 (sentences_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pictogram_verb (id INT AUTO_INCREMENT NOT NULL, therapist_id INT DEFAULT NULL, category_id INT NOT NULL, sentences_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, filename VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', sing_prem_present VARCHAR(255) NOT NULL, sing_prem_futur VARCHAR(255) NOT NULL, sing_prem_passe VARCHAR(255) NOT NULL, sing_deux_present VARCHAR(255) NOT NULL, sing_deux_futur VARCHAR(255) NOT NULL, sing_deux_passe VARCHAR(255) NOT NULL, sing_trois_present VARCHAR(255) NOT NULL, sing_trois_futur VARCHAR(255) NOT NULL, sing_trois_passe VARCHAR(255) NOT NULL, plur_prem_present VARCHAR(255) NOT NULL, plur_prem_futur VARCHAR(255) NOT NULL, plur_prem_passe VARCHAR(255) NOT NULL, plur_deux_present VARCHAR(255) NOT NULL, plur_deux_futur VARCHAR(255) NOT NULL, plur_deux_passe VARCHAR(255) NOT NULL, plur_trois_present VARCHAR(255) NOT NULL, plur_trois_futur VARCHAR(255) NOT NULL, plur_trois_passe VARCHAR(255) NOT NULL, INDEX IDX_C80B4E8443E8B094 (therapist_id), INDEX IDX_C80B4E8412469DE2 (category_id), INDEX IDX_C80B4E84175906F5 (sentences_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, text VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sentence (id INT AUTO_INCREMENT NOT NULL, patient_id INT NOT NULL, text VARCHAR(255) DEFAULT NULL, audio VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_9D664ED56B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE therapist (id INT AUTO_INCREMENT NOT NULL, institution_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(180) NOT NULL, last_name VARCHAR(180) NOT NULL, job VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, INDEX IDX_C3D632F10405986 (institution_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1B85A1111 FOREIGN KEY (super_category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C143E8B094 FOREIGN KEY (therapist_id) REFERENCES therapist (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA146B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA1443E8B094 FOREIGN KEY (therapist_id) REFERENCES therapist (id)');
        $this->addSql('ALTER TABLE pictogram_adjective ADD CONSTRAINT FK_82B2308F43E8B094 FOREIGN KEY (therapist_id) REFERENCES therapist (id)');
        $this->addSql('ALTER TABLE pictogram_adjective ADD CONSTRAINT FK_82B2308F12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE pictogram_adjective ADD CONSTRAINT FK_82B2308F175906F5 FOREIGN KEY (sentences_id) REFERENCES sentence (id)');
        $this->addSql('ALTER TABLE pictogram_noun ADD CONSTRAINT FK_16C66ECE43E8B094 FOREIGN KEY (therapist_id) REFERENCES therapist (id)');
        $this->addSql('ALTER TABLE pictogram_noun ADD CONSTRAINT FK_16C66ECE12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE pictogram_noun ADD CONSTRAINT FK_16C66ECE175906F5 FOREIGN KEY (sentences_id) REFERENCES sentence (id)');
        $this->addSql('ALTER TABLE pictogram_others ADD CONSTRAINT FK_18E59CC143E8B094 FOREIGN KEY (therapist_id) REFERENCES therapist (id)');
        $this->addSql('ALTER TABLE pictogram_others ADD CONSTRAINT FK_18E59CC112469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE pictogram_others ADD CONSTRAINT FK_18E59CC1175906F5 FOREIGN KEY (sentences_id) REFERENCES sentence (id)');
        $this->addSql('ALTER TABLE pictogram_pronoun ADD CONSTRAINT FK_F43977E643E8B094 FOREIGN KEY (therapist_id) REFERENCES therapist (id)');
        $this->addSql('ALTER TABLE pictogram_pronoun ADD CONSTRAINT FK_F43977E612469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE pictogram_pronoun ADD CONSTRAINT FK_F43977E6175906F5 FOREIGN KEY (sentences_id) REFERENCES sentence (id)');
        $this->addSql('ALTER TABLE pictogram_verb ADD CONSTRAINT FK_C80B4E8443E8B094 FOREIGN KEY (therapist_id) REFERENCES therapist (id)');
        $this->addSql('ALTER TABLE pictogram_verb ADD CONSTRAINT FK_C80B4E8412469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE pictogram_verb ADD CONSTRAINT FK_C80B4E84175906F5 FOREIGN KEY (sentences_id) REFERENCES sentence (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES therapist (id)');
        $this->addSql('ALTER TABLE sentence ADD CONSTRAINT FK_9D664ED56B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE therapist ADD CONSTRAINT FK_C3D632F10405986 FOREIGN KEY (institution_id) REFERENCES institution (id)');
        $this->addSql('ALTER TABLE question_category ADD CONSTRAINT FK_6544A9CD1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question_category ADD CONSTRAINT FK_6544A9CD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE question_category DROP FOREIGN KEY FK_6544A9CD12469DE2');
        $this->addSql('ALTER TABLE question_category DROP FOREIGN KEY FK_6544A9CD1E27F6BF');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1B85A1111');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C143E8B094');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA146B899279');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA1443E8B094');
        $this->addSql('ALTER TABLE pictogram_adjective DROP FOREIGN KEY FK_82B2308F43E8B094');
        $this->addSql('ALTER TABLE pictogram_adjective DROP FOREIGN KEY FK_82B2308F12469DE2');
        $this->addSql('ALTER TABLE pictogram_adjective DROP FOREIGN KEY FK_82B2308F175906F5');
        $this->addSql('ALTER TABLE pictogram_noun DROP FOREIGN KEY FK_16C66ECE43E8B094');
        $this->addSql('ALTER TABLE pictogram_noun DROP FOREIGN KEY FK_16C66ECE12469DE2');
        $this->addSql('ALTER TABLE pictogram_noun DROP FOREIGN KEY FK_16C66ECE175906F5');
        $this->addSql('ALTER TABLE pictogram_others DROP FOREIGN KEY FK_18E59CC143E8B094');
        $this->addSql('ALTER TABLE pictogram_others DROP FOREIGN KEY FK_18E59CC112469DE2');
        $this->addSql('ALTER TABLE pictogram_others DROP FOREIGN KEY FK_18E59CC1175906F5');
        $this->addSql('ALTER TABLE pictogram_pronoun DROP FOREIGN KEY FK_F43977E643E8B094');
        $this->addSql('ALTER TABLE pictogram_pronoun DROP FOREIGN KEY FK_F43977E612469DE2');
        $this->addSql('ALTER TABLE pictogram_pronoun DROP FOREIGN KEY FK_F43977E6175906F5');
        $this->addSql('ALTER TABLE pictogram_verb DROP FOREIGN KEY FK_C80B4E8443E8B094');
        $this->addSql('ALTER TABLE pictogram_verb DROP FOREIGN KEY FK_C80B4E8412469DE2');
        $this->addSql('ALTER TABLE pictogram_verb DROP FOREIGN KEY FK_C80B4E84175906F5');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE sentence DROP FOREIGN KEY FK_9D664ED56B899279');
        $this->addSql('ALTER TABLE therapist DROP FOREIGN KEY FK_C3D632F10405986');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE institution');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE pictogram_adjective');
        $this->addSql('DROP TABLE pictogram_noun');
        $this->addSql('DROP TABLE pictogram_others');
        $this->addSql('DROP TABLE pictogram_pronoun');
        $this->addSql('DROP TABLE pictogram_verb');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE sentence');
        $this->addSql('DROP TABLE therapist');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
