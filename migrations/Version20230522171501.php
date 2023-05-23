<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230522171501 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(100) NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projects (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(150) NOT NULL, name VARCHAR(150) NOT NULL, thumbnail VARCHAR(255) DEFAULT NULL, content LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projects_categories (projects_id INT NOT NULL, categories_id INT NOT NULL, INDEX IDX_8C4CD7921EDE0F55 (projects_id), INDEX IDX_8C4CD792A21214B7 (categories_id), PRIMARY KEY(projects_id, categories_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skills (id INT AUTO_INCREMENT NOT NULL, icon VARCHAR(150) NOT NULL, position INT NOT NULL, name VARCHAR(150) NOT NULL, percent INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE specialties (id INT AUTO_INCREMENT NOT NULL, icon VARCHAR(150) NOT NULL, position INT NOT NULL, name VARCHAR(150) NOT NULL, content VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE works (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(150) NOT NULL, name VARCHAR(150) NOT NULL, url VARCHAR(255) DEFAULT NULL, content VARCHAR(255) NOT NULL, start_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', end_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', job VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE works_workstypes (works_id INT NOT NULL, workstypes_id INT NOT NULL, INDEX IDX_6014B190F6CB822A (works_id), INDEX IDX_6014B1903FC2C8BC (workstypes_id), PRIMARY KEY(works_id, workstypes_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE works_types (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE projects_categories ADD CONSTRAINT FK_8C4CD7921EDE0F55 FOREIGN KEY (projects_id) REFERENCES projects (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projects_categories ADD CONSTRAINT FK_8C4CD792A21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE works_workstypes ADD CONSTRAINT FK_6014B190F6CB822A FOREIGN KEY (works_id) REFERENCES works (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE works_workstypes ADD CONSTRAINT FK_6014B1903FC2C8BC FOREIGN KEY (workstypes_id) REFERENCES works_types (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projects_categories DROP FOREIGN KEY FK_8C4CD7921EDE0F55');
        $this->addSql('ALTER TABLE projects_categories DROP FOREIGN KEY FK_8C4CD792A21214B7');
        $this->addSql('ALTER TABLE works_workstypes DROP FOREIGN KEY FK_6014B190F6CB822A');
        $this->addSql('ALTER TABLE works_workstypes DROP FOREIGN KEY FK_6014B1903FC2C8BC');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE projects');
        $this->addSql('DROP TABLE projects_categories');
        $this->addSql('DROP TABLE skills');
        $this->addSql('DROP TABLE specialties');
        $this->addSql('DROP TABLE works');
        $this->addSql('DROP TABLE works_workstypes');
        $this->addSql('DROP TABLE works_types');
    }
}
