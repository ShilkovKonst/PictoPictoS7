<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240409153442 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE audio_phrase (id INT AUTO_INCREMENT NOT NULL, phrase_id INT NOT NULL, audio_name VARCHAR(255) NOT NULL, score INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_A044E7AA8671F084 (phrase_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, super_category_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, filename VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_64C19C1B85A1111 (super_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE conjugation (id INT AUTO_INCREMENT NOT NULL, irregular_id INT NOT NULL, tense VARCHAR(100) NOT NULL, first_person_singular VARCHAR(100) NOT NULL, first_person_plurial VARCHAR(100) NOT NULL, second_person_singular VARCHAR(100) NOT NULL, second_person_plurial VARCHAR(100) NOT NULL, third_person_singular VARCHAR(100) NOT NULL, third_person_plurial VARCHAR(100) NOT NULL, INDEX IDX_B3109AAD6B04594D (irregular_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE institution (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, phone_number VARCHAR(20) NOT NULL, contact_name VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE irregular (id INT AUTO_INCREMENT NOT NULL, feminin VARCHAR(100) DEFAULT NULL, past_participle VARCHAR(100) DEFAULT NULL, plurial VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, therapist_id INT NOT NULL, patient_id INT NOT NULL, estimation VARCHAR(50) NOT NULL, comment LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_CFBDFA1443E8B094 (therapist_id), INDEX IDX_CFBDFA146B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient (id INT AUTO_INCREMENT NOT NULL, therapist_id INT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, grade VARCHAR(255) NOT NULL, sex VARCHAR(10) NOT NULL, birth_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_1ADAD7EB43E8B094 (therapist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE phrase (id INT AUTO_INCREMENT NOT NULL, patient_id INT NOT NULL, question_id INT DEFAULT NULL, text VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_A24BE60C6B899279 (patient_id), INDEX IDX_A24BE60C1E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE phrase_pictogram (phrase_id INT NOT NULL, pictogram_id INT NOT NULL, INDEX IDX_ECAF04518671F084 (phrase_id), INDEX IDX_ECAF045116B7C33B (pictogram_id), PRIMARY KEY(phrase_id, pictogram_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pictogram (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, irregular_id INT DEFAULT NULL, type VARCHAR(20) NOT NULL, title VARCHAR(255) NOT NULL, filename VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_56E0A15F12469DE2 (category_id), UNIQUE INDEX UNIQ_56E0A15F6B04594D (irregular_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pictogram_tag (pictogram_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_D94081F716B7C33B (pictogram_id), INDEX IDX_D94081F7BAD26311 (tag_id), PRIMARY KEY(pictogram_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, text VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question_category (question_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_6544A9CD1E27F6BF (question_id), INDEX IDX_6544A9CD12469DE2 (category_id), PRIMARY KEY(question_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, institution_id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, phone_number VARCHAR(255) NOT NULL, job VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, is_verified TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_8D93D64910405986 (institution_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE audio_phrase ADD CONSTRAINT FK_A044E7AA8671F084 FOREIGN KEY (phrase_id) REFERENCES phrase (id)');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1B85A1111 FOREIGN KEY (super_category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE conjugation ADD CONSTRAINT FK_B3109AAD6B04594D FOREIGN KEY (irregular_id) REFERENCES irregular (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA1443E8B094 FOREIGN KEY (therapist_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA146B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EB43E8B094 FOREIGN KEY (therapist_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE phrase ADD CONSTRAINT FK_A24BE60C6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE phrase ADD CONSTRAINT FK_A24BE60C1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE phrase_pictogram ADD CONSTRAINT FK_ECAF04518671F084 FOREIGN KEY (phrase_id) REFERENCES phrase (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE phrase_pictogram ADD CONSTRAINT FK_ECAF045116B7C33B FOREIGN KEY (pictogram_id) REFERENCES pictogram (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pictogram ADD CONSTRAINT FK_56E0A15F12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE pictogram ADD CONSTRAINT FK_56E0A15F6B04594D FOREIGN KEY (irregular_id) REFERENCES irregular (id)');
        $this->addSql('ALTER TABLE pictogram_tag ADD CONSTRAINT FK_D94081F716B7C33B FOREIGN KEY (pictogram_id) REFERENCES pictogram (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pictogram_tag ADD CONSTRAINT FK_D94081F7BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question_category ADD CONSTRAINT FK_6544A9CD1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question_category ADD CONSTRAINT FK_6544A9CD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64910405986 FOREIGN KEY (institution_id) REFERENCES institution (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE audio_phrase DROP FOREIGN KEY FK_A044E7AA8671F084');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1B85A1111');
        $this->addSql('ALTER TABLE conjugation DROP FOREIGN KEY FK_B3109AAD6B04594D');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA1443E8B094');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA146B899279');
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EB43E8B094');
        $this->addSql('ALTER TABLE phrase DROP FOREIGN KEY FK_A24BE60C6B899279');
        $this->addSql('ALTER TABLE phrase DROP FOREIGN KEY FK_A24BE60C1E27F6BF');
        $this->addSql('ALTER TABLE phrase_pictogram DROP FOREIGN KEY FK_ECAF04518671F084');
        $this->addSql('ALTER TABLE phrase_pictogram DROP FOREIGN KEY FK_ECAF045116B7C33B');
        $this->addSql('ALTER TABLE pictogram DROP FOREIGN KEY FK_56E0A15F12469DE2');
        $this->addSql('ALTER TABLE pictogram DROP FOREIGN KEY FK_56E0A15F6B04594D');
        $this->addSql('ALTER TABLE pictogram_tag DROP FOREIGN KEY FK_D94081F716B7C33B');
        $this->addSql('ALTER TABLE pictogram_tag DROP FOREIGN KEY FK_D94081F7BAD26311');
        $this->addSql('ALTER TABLE question_category DROP FOREIGN KEY FK_6544A9CD1E27F6BF');
        $this->addSql('ALTER TABLE question_category DROP FOREIGN KEY FK_6544A9CD12469DE2');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64910405986');
        $this->addSql('DROP TABLE audio_phrase');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE conjugation');
        $this->addSql('DROP TABLE institution');
        $this->addSql('DROP TABLE irregular');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE phrase');
        $this->addSql('DROP TABLE phrase_pictogram');
        $this->addSql('DROP TABLE pictogram');
        $this->addSql('DROP TABLE pictogram_tag');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE question_category');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
