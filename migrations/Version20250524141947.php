<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250524141947 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE area_plant (area_id INT NOT NULL, plant_id INT NOT NULL, INDEX IDX_26C945A8BD0F409C (area_id), INDEX IDX_26C945A81D935652 (plant_id), PRIMARY KEY(area_id, plant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE area_plant ADD CONSTRAINT FK_26C945A8BD0F409C FOREIGN KEY (area_id) REFERENCES area (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE area_plant ADD CONSTRAINT FK_26C945A81D935652 FOREIGN KEY (plant_id) REFERENCES plant (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE area_plant DROP FOREIGN KEY FK_26C945A8BD0F409C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE area_plant DROP FOREIGN KEY FK_26C945A81D935652
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE area_plant
        SQL);
    }
}
