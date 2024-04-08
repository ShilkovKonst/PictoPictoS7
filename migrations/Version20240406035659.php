<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240406035659 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pictogram_adjectives_sentences (pictogram_adjective_id INT NOT NULL, sentence_id INT NOT NULL, INDEX IDX_B41DEAB676017D5C (pictogram_adjective_id), INDEX IDX_B41DEAB627289490 (sentence_id), PRIMARY KEY(pictogram_adjective_id, sentence_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pictogram_nouns_sentences (pictogram_noun_id INT NOT NULL, sentence_id INT NOT NULL, INDEX IDX_283B2B074095FC0 (pictogram_noun_id), INDEX IDX_283B2B027289490 (sentence_id), PRIMARY KEY(pictogram_noun_id, sentence_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pictogram_others_sentences (pictogram_others_id INT NOT NULL, sentence_id INT NOT NULL, INDEX IDX_846B031AFBB8EABE (pictogram_others_id), INDEX IDX_846B031A27289490 (sentence_id), PRIMARY KEY(pictogram_others_id, sentence_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pictogram_pronouns_sentences (pictogram_pronoun_id INT NOT NULL, sentence_id INT NOT NULL, INDEX IDX_6DDD5857F4550EEF (pictogram_pronoun_id), INDEX IDX_6DDD585727289490 (sentence_id), PRIMARY KEY(pictogram_pronoun_id, sentence_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pictogram_verbs_sentences (pictogram_verb_id INT NOT NULL, sentence_id INT NOT NULL, INDEX IDX_2326703A7955CDA7 (pictogram_verb_id), INDEX IDX_2326703A27289490 (sentence_id), PRIMARY KEY(pictogram_verb_id, sentence_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pictogram_adjectives_sentences ADD CONSTRAINT FK_B41DEAB676017D5C FOREIGN KEY (pictogram_adjective_id) REFERENCES pictogram_adjective (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pictogram_adjectives_sentences ADD CONSTRAINT FK_B41DEAB627289490 FOREIGN KEY (sentence_id) REFERENCES sentence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pictogram_nouns_sentences ADD CONSTRAINT FK_283B2B074095FC0 FOREIGN KEY (pictogram_noun_id) REFERENCES pictogram_noun (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pictogram_nouns_sentences ADD CONSTRAINT FK_283B2B027289490 FOREIGN KEY (sentence_id) REFERENCES sentence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pictogram_others_sentences ADD CONSTRAINT FK_846B031AFBB8EABE FOREIGN KEY (pictogram_others_id) REFERENCES pictogram_others (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pictogram_others_sentences ADD CONSTRAINT FK_846B031A27289490 FOREIGN KEY (sentence_id) REFERENCES sentence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pictogram_pronouns_sentences ADD CONSTRAINT FK_6DDD5857F4550EEF FOREIGN KEY (pictogram_pronoun_id) REFERENCES pictogram_pronoun (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pictogram_pronouns_sentences ADD CONSTRAINT FK_6DDD585727289490 FOREIGN KEY (sentence_id) REFERENCES sentence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pictogram_verbs_sentences ADD CONSTRAINT FK_2326703A7955CDA7 FOREIGN KEY (pictogram_verb_id) REFERENCES pictogram_verb (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pictogram_verbs_sentences ADD CONSTRAINT FK_2326703A27289490 FOREIGN KEY (sentence_id) REFERENCES sentence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sentence_pictogram DROP FOREIGN KEY FK_2C8F221A27289490');
        $this->addSql('DROP TABLE sentence_pictogram');
        $this->addSql('ALTER TABLE therapist ADD CONSTRAINT FK_C3D632F10405986 FOREIGN KEY (institution_id) REFERENCES institution (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sentence_pictogram (sentence_id INT NOT NULL, pictogram_id INT NOT NULL, INDEX IDX_2C8F221A16B7C33B (pictogram_id), INDEX IDX_2C8F221A27289490 (sentence_id), PRIMARY KEY(sentence_id, pictogram_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE sentence_pictogram ADD CONSTRAINT FK_2C8F221A27289490 FOREIGN KEY (sentence_id) REFERENCES sentence (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pictogram_adjectives_sentences DROP FOREIGN KEY FK_B41DEAB676017D5C');
        $this->addSql('ALTER TABLE pictogram_adjectives_sentences DROP FOREIGN KEY FK_B41DEAB627289490');
        $this->addSql('ALTER TABLE pictogram_nouns_sentences DROP FOREIGN KEY FK_283B2B074095FC0');
        $this->addSql('ALTER TABLE pictogram_nouns_sentences DROP FOREIGN KEY FK_283B2B027289490');
        $this->addSql('ALTER TABLE pictogram_others_sentences DROP FOREIGN KEY FK_846B031AFBB8EABE');
        $this->addSql('ALTER TABLE pictogram_others_sentences DROP FOREIGN KEY FK_846B031A27289490');
        $this->addSql('ALTER TABLE pictogram_pronouns_sentences DROP FOREIGN KEY FK_6DDD5857F4550EEF');
        $this->addSql('ALTER TABLE pictogram_pronouns_sentences DROP FOREIGN KEY FK_6DDD585727289490');
        $this->addSql('ALTER TABLE pictogram_verbs_sentences DROP FOREIGN KEY FK_2326703A7955CDA7');
        $this->addSql('ALTER TABLE pictogram_verbs_sentences DROP FOREIGN KEY FK_2326703A27289490');
        $this->addSql('DROP TABLE pictogram_adjectives_sentences');
        $this->addSql('DROP TABLE pictogram_nouns_sentences');
        $this->addSql('DROP TABLE pictogram_others_sentences');
        $this->addSql('DROP TABLE pictogram_pronouns_sentences');
        $this->addSql('DROP TABLE pictogram_verbs_sentences');
        $this->addSql('ALTER TABLE therapist DROP FOREIGN KEY FK_C3D632F10405986');
    }
}
