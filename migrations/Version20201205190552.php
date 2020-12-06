<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201205190552 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE administration ADD mail VARCHAR(255) DEFAULT NULL, ADD bloquer TINYINT(1) DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL, ADD img VARCHAR(255) DEFAULT NULL, DROP bloque, CHANGE tel tel VARCHAR(8) NOT NULL');
        $this->addSql('ALTER TABLE utilisateur DROP verified');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE administration ADD bloque VARCHAR(1) DEFAULT NULL COLLATE utf8mb4_unicode_ci, DROP mail, DROP bloquer, DROP updated_at, DROP img, CHANGE tel tel VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE utilisateur ADD verified VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
