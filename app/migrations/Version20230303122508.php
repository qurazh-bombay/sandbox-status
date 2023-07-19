<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230303122508 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE team_settings (id INT UNSIGNED AUTO_INCREMENT NOT NULL, team_id INT UNSIGNED DEFAULT NULL, space_id INT NOT NULL, board_ids JSON NOT NULL, sandbox_ids JSON NOT NULL, UNIQUE INDEX UNIQ_5D077CBB296CD8AE (team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE team_settings ADD CONSTRAINT FK_5D077CBB296CD8AE FOREIGN KEY (team_id) REFERENCES teams (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE team_settings DROP FOREIGN KEY FK_5D077CBB296CD8AE');
        $this->addSql('DROP TABLE team_settings');
    }
}
