<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190712100318 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE post ADD deleted_at DATETIME NOT NULL, CHANGE uuid uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', CHANGE published_at published_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE uuid uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE post DROP deleted_at, CHANGE uuid uuid CHAR(36) NOT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:uuid)\', CHANGE published_at published_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE uuid uuid CHAR(36) NOT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:uuid)\', CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin');
    }
}
