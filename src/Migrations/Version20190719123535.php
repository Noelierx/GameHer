<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190719123535 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE post CHANGE published_at published_at DATETIME DEFAULT NULL, CHANGE deleted_at deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE partner ADD logo VARCHAR(255) NOT NULL, CHANGE website website VARCHAR(255) DEFAULT NULL, CHANGE twitter twitter VARCHAR(255) DEFAULT NULL, CHANGE facebook facebook VARCHAR(255) DEFAULT NULL, CHANGE instagram instagram VARCHAR(255) DEFAULT NULL, CHANGE deleted_at deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE member ADD picture VARCHAR(255) DEFAULT NULL, CHANGE role_id role_id INT DEFAULT NULL, CHANGE firstname firstname VARCHAR(255) DEFAULT NULL, CHANGE lastname lastname VARCHAR(255) DEFAULT NULL, CHANGE twitch twitch VARCHAR(255) DEFAULT NULL, CHANGE twitter twitter VARCHAR(255) DEFAULT NULL, CHANGE facebook facebook VARCHAR(255) DEFAULT NULL, CHANGE instagram instagram VARCHAR(255) DEFAULT NULL, CHANGE deleted_at deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE role CHANGE deleted_at deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD twitter VARCHAR(255) DEFAULT NULL, ADD facebook VARCHAR(255) DEFAULT NULL, ADD youtube VARCHAR(255) DEFAULT NULL, ADD twitch VARCHAR(255) DEFAULT NULL, ADD discord VARCHAR(255) DEFAULT NULL, ADD instagram VARCHAR(255) DEFAULT NULL, CHANGE discord_id discord_id VARCHAR(255) DEFAULT NULL, CHANGE roles roles JSON NOT NULL, CHANGE deleted_at deleted_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE member DROP picture, CHANGE role_id role_id INT DEFAULT NULL, CHANGE firstname firstname VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE lastname lastname VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE twitch twitch VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE twitter twitter VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE facebook facebook VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE instagram instagram VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE deleted_at deleted_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE partner DROP logo, CHANGE website website VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE twitter twitter VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE facebook facebook VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE instagram instagram VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE deleted_at deleted_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE post CHANGE published_at published_at DATETIME DEFAULT \'NULL\', CHANGE deleted_at deleted_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE role CHANGE deleted_at deleted_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user DROP twitter, DROP facebook, DROP youtube, DROP twitch, DROP discord, DROP instagram, CHANGE discord_id discord_id VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin, CHANGE deleted_at deleted_at DATETIME DEFAULT \'NULL\'');
    }
}
