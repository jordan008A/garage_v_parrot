<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231220125133 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_C9187D168BF21CDE ON motor_technologies');
        $this->addSql('DROP INDEX UNIQ_313BDC8EE5A02990 ON schedules');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C9187D168BF21CDE ON motor_technologies (property)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_313BDC8EE5A02990 ON schedules (day)');
    }
}
