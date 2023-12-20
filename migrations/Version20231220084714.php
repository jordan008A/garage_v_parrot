<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231220084714 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE schedules_users (user_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', schedule_id INT NOT NULL, INDEX IDX_F4875E82A76ED395 (user_id), INDEX IDX_F4875E82A40BC2D5 (schedule_id), PRIMARY KEY(user_id, schedule_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reviews_users (user_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', review_id INT NOT NULL, INDEX IDX_1CD05D5DA76ED395 (user_id), INDEX IDX_1CD05D5D3E2E969B (review_id), PRIMARY KEY(user_id, review_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE services_users (user_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', service_id INT NOT NULL, INDEX IDX_A8611FABA76ED395 (user_id), INDEX IDX_A8611FABED5CA9E6 (service_id), PRIMARY KEY(user_id, service_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cars_users (user_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', car_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_8ECEF66FA76ED395 (user_id), INDEX IDX_8ECEF66FC3C6F69F (car_id), PRIMARY KEY(user_id, car_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE schedules_users ADD CONSTRAINT FK_F4875E82A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE schedules_users ADD CONSTRAINT FK_F4875E82A40BC2D5 FOREIGN KEY (schedule_id) REFERENCES schedules (id)');
        $this->addSql('ALTER TABLE reviews_users ADD CONSTRAINT FK_1CD05D5DA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE reviews_users ADD CONSTRAINT FK_1CD05D5D3E2E969B FOREIGN KEY (review_id) REFERENCES reviews (id)');
        $this->addSql('ALTER TABLE services_users ADD CONSTRAINT FK_A8611FABA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE services_users ADD CONSTRAINT FK_A8611FABED5CA9E6 FOREIGN KEY (service_id) REFERENCES services (id)');
        $this->addSql('ALTER TABLE cars_users ADD CONSTRAINT FK_8ECEF66FA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE cars_users ADD CONSTRAINT FK_8ECEF66FC3C6F69F FOREIGN KEY (car_id) REFERENCES cars (id)');
        $this->addSql('ALTER TABLE reviews ADD service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0FED5CA9E6 FOREIGN KEY (service_id) REFERENCES services (id)');
        $this->addSql('CREATE INDEX IDX_6970EB0FED5CA9E6 ON reviews (service_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE schedules_users DROP FOREIGN KEY FK_F4875E82A76ED395');
        $this->addSql('ALTER TABLE schedules_users DROP FOREIGN KEY FK_F4875E82A40BC2D5');
        $this->addSql('ALTER TABLE reviews_users DROP FOREIGN KEY FK_1CD05D5DA76ED395');
        $this->addSql('ALTER TABLE reviews_users DROP FOREIGN KEY FK_1CD05D5D3E2E969B');
        $this->addSql('ALTER TABLE services_users DROP FOREIGN KEY FK_A8611FABA76ED395');
        $this->addSql('ALTER TABLE services_users DROP FOREIGN KEY FK_A8611FABED5CA9E6');
        $this->addSql('ALTER TABLE cars_users DROP FOREIGN KEY FK_8ECEF66FA76ED395');
        $this->addSql('ALTER TABLE cars_users DROP FOREIGN KEY FK_8ECEF66FC3C6F69F');
        $this->addSql('DROP TABLE schedules_users');
        $this->addSql('DROP TABLE reviews_users');
        $this->addSql('DROP TABLE services_users');
        $this->addSql('DROP TABLE cars_users');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0FED5CA9E6');
        $this->addSql('DROP INDEX IDX_6970EB0FED5CA9E6 ON reviews');
        $this->addSql('ALTER TABLE reviews DROP service_id');
    }
}
