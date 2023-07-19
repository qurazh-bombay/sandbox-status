<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230303122619 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO `team_settings` (`id`, `team_id`, `space_id`, `board_ids`, `sandbox_ids`) VALUES (NULL, (SELECT t.id FROM `teams` AS t WHERE t.slug = 'improvement'), 43098, '[108201, 180398, 317214]', '[2,3,4,5,6,7,8,47,48,52,53,54,55,56]')");
        $this->addSql("INSERT INTO `team_settings` (`id`, `team_id`, `space_id`, `board_ids`, `sandbox_ids`) VALUES (NULL, (SELECT t.id FROM `teams` AS t WHERE t.slug = 'content'), 43008, '[108053, 180398, 108084, 116932]', '[41,42,43,44,45]')");
        $this->addSql("INSERT INTO `team_settings` (`id`, `team_id`, `space_id`, `board_ids`, `sandbox_ids`) VALUES (NULL, (SELECT t.id FROM `teams` AS t WHERE t.slug = 'interest'), 43183, '[108399, 180398, 253806, 302090]', '[14,15,16,18,19,20]')");
        $this->addSql("INSERT INTO `team_settings` (`id`, `team_id`, `space_id`, `board_ids`, `sandbox_ids`) VALUES (NULL, (SELECT t.id FROM `teams` AS t WHERE t.slug = 'optimize'), 43181, '[108395, 108398]', '[21,23,24,25,36,37,38,39,40]')");
        $this->addSql("INSERT INTO `team_settings` (`id`, `team_id`, `space_id`, `board_ids`, `sandbox_ids`) VALUES (NULL, (SELECT t.id FROM `teams` AS t WHERE t.slug = 'expansion'), 61679, '[152638, 180398, 187474]', '[26,27,28,29,30,57,58,59,60,61,101,102,103]')");
        $this->addSql("INSERT INTO `team_settings` (`id`, `team_id`, `space_id`, `board_ids`, `sandbox_ids`) VALUES (NULL, (SELECT t.id FROM `teams` AS t WHERE t.slug = 'engineer'), 43046, '[108079, 180398]', '[31,32,33,34,35]')");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DELETE FROM `team_settings` WHERE `team_settings`.`space_id` = 43098");
        $this->addSql("DELETE FROM `team_settings` WHERE `team_settings`.`space_id` = 43008");
        $this->addSql("DELETE FROM `team_settings` WHERE `team_settings`.`space_id` = 43183");
        $this->addSql("DELETE FROM `team_settings` WHERE `team_settings`.`space_id` = 43181");
        $this->addSql("DELETE FROM `team_settings` WHERE `team_settings`.`space_id` = 61679");
        $this->addSql("DELETE FROM `team_settings` WHERE `team_settings`.`space_id` = 43046");
    }
}
