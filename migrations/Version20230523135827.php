<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230523135827 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE works_workstypes DROP FOREIGN KEY FK_6014B190F6CB822A');
        $this->addSql('ALTER TABLE works_workstypes DROP FOREIGN KEY FK_6014B1903FC2C8BC');
        $this->addSql('DROP TABLE works_workstypes');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE works_workstypes (works_id INT NOT NULL, workstypes_id INT NOT NULL, INDEX IDX_6014B1903FC2C8BC (workstypes_id), INDEX IDX_6014B190F6CB822A (works_id), PRIMARY KEY(works_id, workstypes_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE works_workstypes ADD CONSTRAINT FK_6014B190F6CB822A FOREIGN KEY (works_id) REFERENCES works (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE works_workstypes ADD CONSTRAINT FK_6014B1903FC2C8BC FOREIGN KEY (workstypes_id) REFERENCES works_types (id) ON DELETE CASCADE');
    }
}
