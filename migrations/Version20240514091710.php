<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240514091710 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE brands (id INT AUTO_INCREMENT NOT NULL, property VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cars (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', motor_technologie INT DEFAULT NULL, brand INT DEFAULT NULL, title VARCHAR(50) NOT NULL, price INT NOT NULL, year VARCHAR(4) NOT NULL, mileage INT NOT NULL, puissance_din INT NOT NULL, puissance_fiscale INT NOT NULL, is_automatically TINYINT(1) NOT NULL, INDEX IDX_95C71D141B37E026 (motor_technologie), INDEX IDX_95C71D141C52F958 (brand), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messages (id INT AUTO_INCREMENT NOT NULL, service_id INT DEFAULT NULL, car_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', firstname VARCHAR(50) NOT NULL, lastname VARCHAR(50) NOT NULL, email VARCHAR(255) NOT NULL, phone_number VARCHAR(20) NOT NULL, text VARCHAR(255) NOT NULL, INDEX IDX_DB021E96ED5CA9E6 (service_id), INDEX IDX_DB021E96C3C6F69F (car_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE motor_technologies (id INT AUTO_INCREMENT NOT NULL, property VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pictures (id INT AUTO_INCREMENT NOT NULL, car BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', picture VARCHAR(255) NOT NULL, is_primary TINYINT(1) NOT NULL, INDEX IDX_8F7C2FC0773DE69D (car), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reviews (id INT AUTO_INCREMENT NOT NULL, service_id INT DEFAULT NULL, firstname VARCHAR(50) NOT NULL, lastname VARCHAR(50) NOT NULL, text VARCHAR(175) NOT NULL, rate INT NOT NULL, approved TINYINT(1) NOT NULL, INDEX IDX_6970EB0FED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE schedules (id INT AUTO_INCREMENT NOT NULL, text VARCHAR(100) NOT NULL, day VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE services (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(50) NOT NULL, text VARCHAR(400) NOT NULL, picture VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', email VARCHAR(255) NOT NULL, password VARCHAR(60) NOT NULL, firstname VARCHAR(50) NOT NULL, lastname VARCHAR(50) NOT NULL, is_admin TINYINT(1) NOT NULL, reset_token VARCHAR(255) DEFAULT NULL, reset_token_expires_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE schedules_users (user_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', schedule_id INT NOT NULL, INDEX IDX_F4875E82A76ED395 (user_id), INDEX IDX_F4875E82A40BC2D5 (schedule_id), PRIMARY KEY(user_id, schedule_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reviews_users (user_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', review_id INT NOT NULL, INDEX IDX_1CD05D5DA76ED395 (user_id), INDEX IDX_1CD05D5D3E2E969B (review_id), PRIMARY KEY(user_id, review_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE services_users (user_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', service_id INT NOT NULL, INDEX IDX_A8611FABA76ED395 (user_id), INDEX IDX_A8611FABED5CA9E6 (service_id), PRIMARY KEY(user_id, service_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cars_users (user_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', car_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_8ECEF66FA76ED395 (user_id), INDEX IDX_8ECEF66FC3C6F69F (car_id), PRIMARY KEY(user_id, car_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cars ADD CONSTRAINT FK_95C71D141B37E026 FOREIGN KEY (motor_technologie) REFERENCES motor_technologies (id)');
        $this->addSql('ALTER TABLE cars ADD CONSTRAINT FK_95C71D141C52F958 FOREIGN KEY (brand) REFERENCES brands (id)');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E96ED5CA9E6 FOREIGN KEY (service_id) REFERENCES services (id)');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E96C3C6F69F FOREIGN KEY (car_id) REFERENCES cars (id)');
        $this->addSql('ALTER TABLE pictures ADD CONSTRAINT FK_8F7C2FC0773DE69D FOREIGN KEY (car) REFERENCES cars (id)');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0FED5CA9E6 FOREIGN KEY (service_id) REFERENCES services (id)');
        $this->addSql('ALTER TABLE schedules_users ADD CONSTRAINT FK_F4875E82A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE schedules_users ADD CONSTRAINT FK_F4875E82A40BC2D5 FOREIGN KEY (schedule_id) REFERENCES schedules (id)');
        $this->addSql('ALTER TABLE reviews_users ADD CONSTRAINT FK_1CD05D5DA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE reviews_users ADD CONSTRAINT FK_1CD05D5D3E2E969B FOREIGN KEY (review_id) REFERENCES reviews (id)');
        $this->addSql('ALTER TABLE services_users ADD CONSTRAINT FK_A8611FABA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE services_users ADD CONSTRAINT FK_A8611FABED5CA9E6 FOREIGN KEY (service_id) REFERENCES services (id)');
        $this->addSql('ALTER TABLE cars_users ADD CONSTRAINT FK_8ECEF66FA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE cars_users ADD CONSTRAINT FK_8ECEF66FC3C6F69F FOREIGN KEY (car_id) REFERENCES cars (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cars DROP FOREIGN KEY FK_95C71D141B37E026');
        $this->addSql('ALTER TABLE cars DROP FOREIGN KEY FK_95C71D141C52F958');
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E96ED5CA9E6');
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E96C3C6F69F');
        $this->addSql('ALTER TABLE pictures DROP FOREIGN KEY FK_8F7C2FC0773DE69D');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0FED5CA9E6');
        $this->addSql('ALTER TABLE schedules_users DROP FOREIGN KEY FK_F4875E82A76ED395');
        $this->addSql('ALTER TABLE schedules_users DROP FOREIGN KEY FK_F4875E82A40BC2D5');
        $this->addSql('ALTER TABLE reviews_users DROP FOREIGN KEY FK_1CD05D5DA76ED395');
        $this->addSql('ALTER TABLE reviews_users DROP FOREIGN KEY FK_1CD05D5D3E2E969B');
        $this->addSql('ALTER TABLE services_users DROP FOREIGN KEY FK_A8611FABA76ED395');
        $this->addSql('ALTER TABLE services_users DROP FOREIGN KEY FK_A8611FABED5CA9E6');
        $this->addSql('ALTER TABLE cars_users DROP FOREIGN KEY FK_8ECEF66FA76ED395');
        $this->addSql('ALTER TABLE cars_users DROP FOREIGN KEY FK_8ECEF66FC3C6F69F');
        $this->addSql('DROP TABLE brands');
        $this->addSql('DROP TABLE cars');
        $this->addSql('DROP TABLE messages');
        $this->addSql('DROP TABLE motor_technologies');
        $this->addSql('DROP TABLE pictures');
        $this->addSql('DROP TABLE reviews');
        $this->addSql('DROP TABLE schedules');
        $this->addSql('DROP TABLE services');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE schedules_users');
        $this->addSql('DROP TABLE reviews_users');
        $this->addSql('DROP TABLE services_users');
        $this->addSql('DROP TABLE cars_users');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
