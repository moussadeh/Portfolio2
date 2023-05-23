<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230523224302 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projects ADD work_id INT DEFAULT NULL, DROP work');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT FK_5C93B3A4BB3453DB FOREIGN KEY (work_id) REFERENCES works (id)');
        $this->addSql('CREATE INDEX IDX_5C93B3A4BB3453DB ON projects (work_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projects DROP FOREIGN KEY FK_5C93B3A4BB3453DB');
        $this->addSql('DROP INDEX IDX_5C93B3A4BB3453DB ON projects');
        $this->addSql('ALTER TABLE projects ADD work VARCHAR(255) DEFAULT NULL, DROP work_id');
    }
}
