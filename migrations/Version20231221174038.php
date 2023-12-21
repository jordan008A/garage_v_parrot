<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231221174038 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cars CHANGE id id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE messages CHANGE car_id car_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE pictures CHANGE car car BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE users CHANGE id id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE schedules_users CHANGE user_id user_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE reviews_users CHANGE user_id user_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE services_users CHANGE user_id user_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE cars_users CHANGE user_id user_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', CHANGE car_id car_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cars CHANGE id id VARCHAR(36) NOT NULL');
        $this->addSql('ALTER TABLE cars_users CHANGE user_id user_id VARCHAR(36) NOT NULL, CHANGE car_id car_id VARCHAR(36) NOT NULL');
        $this->addSql('ALTER TABLE messages CHANGE car_id car_id VARCHAR(36) DEFAULT NULL');
        $this->addSql('ALTER TABLE pictures CHANGE car car VARCHAR(36) DEFAULT NULL');
        $this->addSql('ALTER TABLE reviews_users CHANGE user_id user_id VARCHAR(36) NOT NULL');
        $this->addSql('ALTER TABLE schedules_users CHANGE user_id user_id VARCHAR(36) NOT NULL');
        $this->addSql('ALTER TABLE services_users CHANGE user_id user_id VARCHAR(36) NOT NULL');
        $this->addSql('ALTER TABLE users CHANGE id id VARCHAR(36) NOT NULL');
    }
}
