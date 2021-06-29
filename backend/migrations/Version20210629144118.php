<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210629144118 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE platform (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(25) NOT NULL, publisher VARCHAR(25) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE review (id INT AUTO_INCREMENT NOT NULL, videogame_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, author VARCHAR(50) NOT NULL, publication_date DATETIME NOT NULL, display_rating SMALLINT NOT NULL, gameplay_rating SMALLINT NOT NULL, story_rating SMALLINT NOT NULL, lifetime_rating SMALLINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_794381C625EB9E4B (videogame_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE videogame (id INT AUTO_INCREMENT NOT NULL, platform_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, editor VARCHAR(25) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_94D9ED72FFE6496F (platform_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C625EB9E4B FOREIGN KEY (videogame_id) REFERENCES videogame (id)');
        $this->addSql('ALTER TABLE videogame ADD CONSTRAINT FK_94D9ED72FFE6496F FOREIGN KEY (platform_id) REFERENCES platform (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE videogame DROP FOREIGN KEY FK_94D9ED72FFE6496F');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C625EB9E4B');
        $this->addSql('DROP TABLE platform');
        $this->addSql('DROP TABLE review');
        $this->addSql('DROP TABLE videogame');
    }
}
