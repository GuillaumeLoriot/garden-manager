<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250717092843 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE journal_entry (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, area_id INT DEFAULT NULL, title VARCHAR(100) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_C8FAAE5AA76ED395 (user_id), INDEX IDX_C8FAAE5ABD0F409C (area_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE plant_recipe (plant_id INT NOT NULL, recipe_id INT NOT NULL, INDEX IDX_391860BC1D935652 (plant_id), INDEX IDX_391860BC59D8A214 (recipe_id), PRIMARY KEY(plant_id, recipe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE plant_plant (plant_source INT NOT NULL, plant_target INT NOT NULL, INDEX IDX_58D994FABC1AAEF8 (plant_source), INDEX IDX_58D994FAA5FFFE77 (plant_target), PRIMARY KEY(plant_source, plant_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE recipe (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(100) NOT NULL, ingredients_list LONGTEXT NOT NULL, instructions LONGTEXT NOT NULL, servings INT NOT NULL, INDEX IDX_DA88B137A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE journal_entry ADD CONSTRAINT FK_C8FAAE5AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE journal_entry ADD CONSTRAINT FK_C8FAAE5ABD0F409C FOREIGN KEY (area_id) REFERENCES area (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE plant_recipe ADD CONSTRAINT FK_391860BC1D935652 FOREIGN KEY (plant_id) REFERENCES plant (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE plant_recipe ADD CONSTRAINT FK_391860BC59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE plant_plant ADD CONSTRAINT FK_58D994FABC1AAEF8 FOREIGN KEY (plant_source) REFERENCES plant (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE plant_plant ADD CONSTRAINT FK_58D994FAA5FFFE77 FOREIGN KEY (plant_target) REFERENCES plant (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE recipe ADD CONSTRAINT FK_DA88B137A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE journal_entry DROP FOREIGN KEY FK_C8FAAE5AA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE journal_entry DROP FOREIGN KEY FK_C8FAAE5ABD0F409C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE plant_recipe DROP FOREIGN KEY FK_391860BC1D935652
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE plant_recipe DROP FOREIGN KEY FK_391860BC59D8A214
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE plant_plant DROP FOREIGN KEY FK_58D994FABC1AAEF8
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE plant_plant DROP FOREIGN KEY FK_58D994FAA5FFFE77
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE recipe DROP FOREIGN KEY FK_DA88B137A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE journal_entry
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE plant_recipe
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE plant_plant
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE recipe
        SQL);
    }
}
