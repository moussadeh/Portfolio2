<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230523140010 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE works ADD type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE works ADD CONSTRAINT FK_F6E50243C54C8C93 FOREIGN KEY (type_id) REFERENCES works_types (id)');
        $this->addSql('CREATE INDEX IDX_F6E50243C54C8C93 ON works (type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE works DROP FOREIGN KEY FK_F6E50243C54C8C93');
        $this->addSql('DROP INDEX IDX_F6E50243C54C8C93 ON works');
        $this->addSql('ALTER TABLE works DROP type_id');
    }
}
