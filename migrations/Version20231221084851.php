<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231221084851 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE messages ADD service_id INT DEFAULT NULL, DROP subject');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E96ED5CA9E6 FOREIGN KEY (service_id) REFERENCES services (id)');
        $this->addSql('CREATE INDEX IDX_DB021E96ED5CA9E6 ON messages (service_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E96ED5CA9E6');
        $this->addSql('DROP INDEX IDX_DB021E96ED5CA9E6 ON messages');
        $this->addSql('ALTER TABLE messages ADD subject VARCHAR(255) NOT NULL, DROP service_id');
    }
}
