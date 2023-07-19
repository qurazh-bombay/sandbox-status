<?php
declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230301094724 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO `teams` (`id`, `title`, `slug`) VALUES (NULL, 'Улучшение продукта', 'improvement')");
        $this->addSql("INSERT INTO `teams` (`id`, `title`, `slug`) VALUES (NULL, 'Ассортимент и контент', 'content')");
        $this->addSql("INSERT INTO `teams` (`id`, `title`, `slug`) VALUES (NULL, 'Пользовательский интерес', 'interest')");
        $this->addSql("INSERT INTO `teams` (`id`, `title`, `slug`) VALUES (NULL, 'Оптимизация трафика', 'optimize')");
        $this->addSql("INSERT INTO `teams` (`id`, `title`, `slug`) VALUES (NULL, 'Экспансия', 'expansion')");
        $this->addSql("INSERT INTO `teams` (`id`, `title`, `slug`) VALUES (NULL, 'Инженерная', 'engineer')");

    }

    public function down(Schema $schema): void
    {
        $this->addSql("DELETE FROM `teams` WHERE `teams`.`slug` = 'improvement'");
        $this->addSql("DELETE FROM `teams` WHERE `teams`.`slug` = 'content'");
        $this->addSql("DELETE FROM `teams` WHERE `teams`.`slug` = 'interest'");
        $this->addSql("DELETE FROM `teams` WHERE `teams`.`slug` = 'optimize'");
        $this->addSql("DELETE FROM `teams` WHERE `teams`.`slug` = 'expansion'");
        $this->addSql("DELETE FROM `teams` WHERE `teams`.`slug` = 'engineer'");
    }
}
