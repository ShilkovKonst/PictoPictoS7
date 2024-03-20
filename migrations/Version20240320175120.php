<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240320175120 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pictogram DROP FOREIGN KEY FK_56E0A15FF78A56EE');
        $this->addSql('DROP INDEX IDX_56E0A15FF78A56EE ON pictogram');
        $this->addSql('ALTER TABLE pictogram CHANGE subcategory_id_id sub_category_id INT NOT NULL, CHANGE update_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE pictogram ADD CONSTRAINT FK_56E0A15FF7BFE87C FOREIGN KEY (sub_category_id) REFERENCES sub_category (id)');
        $this->addSql('CREATE INDEX IDX_56E0A15FF7BFE87C ON pictogram (sub_category_id)');
        $this->addSql('ALTER TABLE sub_category DROP FOREIGN KEY FK_BCE3F7989777D11E');
        $this->addSql('DROP INDEX IDX_BCE3F7989777D11E ON sub_category');
        $this->addSql('ALTER TABLE sub_category CHANGE category_id_id category_id INT NOT NULL');
        $this->addSql('ALTER TABLE sub_category ADD CONSTRAINT FK_BCE3F79812469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_BCE3F79812469DE2 ON sub_category (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sub_category DROP FOREIGN KEY FK_BCE3F79812469DE2');
        $this->addSql('DROP INDEX IDX_BCE3F79812469DE2 ON sub_category');
        $this->addSql('ALTER TABLE sub_category CHANGE category_id category_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE sub_category ADD CONSTRAINT FK_BCE3F7989777D11E FOREIGN KEY (category_id_id) REFERENCES category (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_BCE3F7989777D11E ON sub_category (category_id_id)');
        $this->addSql('ALTER TABLE pictogram DROP FOREIGN KEY FK_56E0A15FF7BFE87C');
        $this->addSql('DROP INDEX IDX_56E0A15FF7BFE87C ON pictogram');
        $this->addSql('ALTER TABLE pictogram CHANGE sub_category_id subcategory_id_id INT NOT NULL, CHANGE updated_at update_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE pictogram ADD CONSTRAINT FK_56E0A15FF78A56EE FOREIGN KEY (subcategory_id_id) REFERENCES sub_category (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_56E0A15FF78A56EE ON pictogram (subcategory_id_id)');
    }
}
