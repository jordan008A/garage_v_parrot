<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231220102433 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cars CHANGE automatically is_automatically TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE messages ADD car_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', DROP car');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E96C3C6F69F FOREIGN KEY (car_id) REFERENCES cars (id)');
        $this->addSql('CREATE INDEX IDX_DB021E96C3C6F69F ON messages (car_id)');
        $this->addSql('ALTER TABLE pictures CHANGE car car BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE pictures ADD CONSTRAINT FK_8F7C2FC0773DE69D FOREIGN KEY (car) REFERENCES cars (id)');
        $this->addSql('CREATE INDEX IDX_8F7C2FC0773DE69D ON pictures (car)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cars CHANGE is_automatically automatically TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E96C3C6F69F');
        $this->addSql('DROP INDEX IDX_DB021E96C3C6F69F ON messages');
        $this->addSql('ALTER TABLE messages ADD car VARCHAR(36) DEFAULT NULL, DROP car_id');
        $this->addSql('ALTER TABLE pictures DROP FOREIGN KEY FK_8F7C2FC0773DE69D');
        $this->addSql('DROP INDEX IDX_8F7C2FC0773DE69D ON pictures');
        $this->addSql('ALTER TABLE pictures CHANGE car car VARCHAR(36) NOT NULL');
    }
}
