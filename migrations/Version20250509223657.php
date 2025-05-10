<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250509223657 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE plant (id INT AUTO_INCREMENT NOT NULL, family_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, category VARCHAR(40) NOT NULL, description LONGTEXT NOT NULL, plant_picture VARCHAR(255) NOT NULL, sowing_period_start DATE NOT NULL, sowing_period_end DATE NOT NULL, planting_period_start DATE NOT NULL, planting_period_end DATE NOT NULL, harvest_period_start DATE NOT NULL, harvest_period_end DATE NOT NULL, germination_details LONGTEXT NOT NULL, cultivation_details LONGTEXT NOT NULL, growing_time INT NOT NULL, water_need INT NOT NULL, sunlight_need INT NOT NULL, soil_need LONGTEXT NOT NULL, support_need TINYINT(1) NOT NULL, INDEX IDX_AB030D72C35E566A (family_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE plant ADD CONSTRAINT FK_AB030D72C35E566A FOREIGN KEY (family_id) REFERENCES family (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE plant DROP FOREIGN KEY FK_AB030D72C35E566A
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE plant
        SQL);
    }
}
